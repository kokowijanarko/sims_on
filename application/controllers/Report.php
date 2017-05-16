<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('cashier_model');
		$this->load->model('report_model');
		$this->load->model('user_model');
		$this->load->library('authex');
		$this->load->library('rep_pdf');
		$login = $this->authex->logged_in();
		if(!$login){
			redirect(site_url(''));
		}
    }
	
	
	public function get_type_by_cat(){
		//var_dump($_POST);die;
		$type = $this->cashier_model->getTypeByCat($_POST['category_id']);
		
		$result = json_encode($type);
		echo $result;
		exit;
		
	}
	
	
	public function daily_list(){
		if(!empty($this->session->userdata('level'))){
			$filter = array(
				'user'=>'all'
			);
			if(!empty($_POST)){
				if($_POST['date'] == '1970-01-01' || $_POST['date'] == ''){
					$date = 'all';
				}else{
					$date = date('Y-m-d', strtotime($_POST['date']));
				}
				$filter = array(
					'date'=> $date,
					'user'=>$_POST['user']
				);
				$data['post'] = $_POST;
			}
			// var_dump($_POST, $filter);die;
			$data['invoice'] = $this->report_model->getTransactionByDate($filter);
			// var_dump($this->db->last_query());
			$data['user'] = $this->report_model->getUser();
			//var_dump($data);die;
			
			$this->load->view('admin/report/list', $data);
		}else{
			redirect(site_url(''));
		}			
	}
	
	public function get_detail_invoice(){
		
		$result = $this->cashier_model->getDetailInvoiceByInvoiceCode($_POST['invo_number']);
		//var_dump($result);die;
		echo json_encode($result);
		exit;
	}
	public function print_report(){
			if(!empty($_GET)){
				if($_GET['date'] == '01-01-1970' || $_GET['date'] == '' || $_GET['date'] == 'all'){
					$date = 'all';
				}else{
					$date = date('Y-m-d', strtotime($_GET['date']));
				}
				$filter = array(
					'date'=> $date,
					'user'=>$_GET['fo']
				);
			}
			$data = $this->report_model->getTransactionByDate($filter);
			// var_dump($filter, $data);die;
			$PDF = $this->rep_pdf;			
			$mPDF = new $PDF(
				'', 
				array(216, 330), 
				7, 
				'Times New Roman',
				15, //l
				15, //r
				16, //t
				16, //b
				9, 
				9, 
				'L'
			);
			
			if(!empty($data)){
				$no = 1;
				foreach($data as $val){
					$data_order .= '
						<tr>
							<td>'. $no .'</td>
							<td>'. $val->order_code .'</td>
							<td>'. $val->order_date_order .'</td>
							<td>'. $val->order_date_take .'</td>
							<td>'. $val->order_custommer_name .'</td>
							<td>'. $val->order_address .'</td>
							<td>'. $val->order_contact .'</td>
							<td>'. $val->user_full_name .'</td>
							<td style="text-align:center">'. date('d-m-Y H:i:s', strtotime($val->insert_timestamp)) .'</td>
							<td style="text-align:right">'. number_format($val->order_amount, 2, ',', '.') .'</td>
							<td style="text-align:right">'. number_format($val->order_cash_minus, 2, ',', '.') .'</td>
						</tr>
					';
					$no++;
					$amount[] = $val->order_amount;
					$minus[] = $val->order_cash_minus;
				}
				$total_amount = array_sum($amount);
				$total_minus = array_sum($minus);
				$data_order .= '
					<tr>
						<td colspan="9" style="text-align:center"><b>JUMLAH (Rp)</b></td>
						<td style="text-align:right">'. number_format($total_amount, 2, ',', '.') .'</td>
						<td style="text-align:right">'. number_format($total_minus, 2, ',', '.') .'</td>
					</tr>
				';
				
			}else{
				$data_order .= '
						<tr>
							<td colspan="11" style="text-align=center;">Data Tidak Ditemukan</td>
						</tr>
					';
			}
			$tgl_header = $filter['date'] == 'all' ? 'Semua' : date('d-m-Y', strtotime($filter['date']));
			$fo_name = $filter['user'] == 'all' ? 'Semua' : $this->user_model->getDetailUser($filter['user']);
			$fo_name = is_object($fo_name) ? $fo_name->user_full_name : 'Semua';
			// var_dump($fo_name);die;
			$html_body = '
				<div style="position:right;">
					<table>
						<tr>
							<td><img height="50px" src="'. base_url('assets/kd.JPG') .'"></td>
						</tr>
					</table>
				</div>
				<div style="text-align:center;">
					<h3>Laporan Penjualan</h3>
				</div>
				<table>
					<tr>
						<td>Tanggal</td>
						<td>:</td>
						<td>'. $tgl_header .'</td>
					</tr>
					<tr>
						<td>Front Officer</td>
						<td>:</td>
						<td>'. $fo_name .'</td>
					</tr>
				</table>
				<table width="100%" cellpadding="0" cellPadding="0" border="1" style="font-family:Times New Roman 12pt; border-collapse:collapse;">
					<thead>
						<tr>
							<th>NO</th>
							<th>NO J.O</th>
							<th>TGL ORDER</th>
							<th>TGL PENGAMBILAN</th>
							<th>NAMA</th>
							<th>ALAMAT</th>
							<th>NO. KONTAK</th>
							<th>F.O</th>
							<th>WAKTU PEMBUATAN J.O</th>
							<th>NOMINAL (Rp)</th>
							<th>KURANG (Rp)</th>
						</tr>
					</thead>
					<tbody>
					'. $data_order .'
					</tbody>
				</table>
			
			';	
			// echo $html_body;die;
			
			$title = 'Laporan Penjualan ';
			if(!empty($filter['date']) && $filter['date'] != 'all'){
				$title .= date('d-M-Y', strtotime($filter['date']));
			}else{
				$title .= $filter['date'];
			}
			if(!empty($filter['user'])){
				$title .= date('d-M-Y', strtotime($filter['date']));
			}		
			$mPDF->WriteHTML($html_body);
			$mPDF->Output($title . '.pdf', 'D');
			exit;
	}	
}
