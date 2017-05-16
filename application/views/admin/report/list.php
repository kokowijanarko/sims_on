<?php 
$this->load->view('template/head');
?>
<!--tambahkan custom css disini-->

<!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css">
<!-- bootstrap datepicker -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datepicker/datepicker3.css') ?>" rel="stylesheet" type="text/css" />

<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
// var_dump($post);
$date = isset($post['date']) ? ($post['date'] == '' ? 'all' : date('d-m-Y', strtotime($post['date']))):'all';
$fo = isset($post['user']) ? $post['user'] : 'all';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Job Order / Invoice
        <small></small>
    </h1>
    
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
	<div class="box">
		<div class="box-header with-border">
            <h3 class="box-title">Cari Job Order</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
		<div class="box-body">
			<form action="<?php echo site_url('report/daily_list')?>" method="POST">
				<table>					
					<tr>
						<td width="100px" ><br><label>Tanggal Transaksi</label><br></td>
						<td width="200px">
							<br>
							<div class="input-group date">
								
								<input type="text" name="date" id="datepicker" value="<?php $val = isset($post['date']) ? ($post['date'] == 'all' ? null : date('d-m-Y', strtotime($post['date']))):null; echo $val;?>" class="form-control" id="date">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
							</div>	
							<br>
						</td>
					</tr>
					<tr>
						<td width="100px" ><br><label>Front Officer</label><br></td>
						<td width="200px">
							<br>
							<div class="input-group">
								<select name="user" class="form-control">
									<option value="all">---SEMUA---</option>
									<?php
										
										foreach($user as $val){
											$cek = '';
											if(isset($post['user'])){
												if($post['user'] == $val->user_id){
													$cek = 'selected';
												}
											}
											echo '<option value="'. $val->user_id .'" '. $cek .'>'.$val->user_full_name.'</option>';
										}
									?>
								</select>
							</div>
							<br>							
						</td>
					</tr>
					<tr>
						<td width="100px" ></td>
						<td width="200px">
							<div>						
								<button id="proc-order" type="submit" class="btn btn-default btn-sm">Cari</button>
							</div>					
						</td>
					</tr>
					
					
				</table>
			</form>				
		</div>
	
	</div>
	<div class="box">
		<div class="box-header with-border">
            <h3 class="box-title">Daftar Job Order</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
			
        <div class="box-body">
			<div>
				<a href="<?php echo site_url('report/print_report?date='. $date .'&fo='. $fo)?>" target="_blank"><button class="btn btn-sm btn-primary">Cetak Laporan</button></a>
			</div>
			<br>
			<div>
			<table id="tbl-invoice" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nomor Invoice</th>
                  <th>Cara Pembayaran</th>
                  <th>Total</th>
                  <th>Kurang</th>
                  <th>FO</th>
                </tr>
                </thead>
                <tbody>
					<?php
						$no=1;
						$amount = array();
						foreach($invoice as $val){	
							array_push($amount, $val->order_amount);
							echo'
								<tr>
									<td>'. $no .'</td>
									<td>'. $val->order_code .'</td>
									<td>'. $val->payment_way .'</td>
									<td>'. $val->order_amount .'</td>
									<td>'. $val->order_cash_minus .'</td>
									<td>'. $val->user_full_name .'</td>
								</tr>
							';
							
							$no++;
						}
						$omset = array_sum($amount);
						
					?>
				</tbody>
              </table>
			  </div>
				<br>
				<table class="table-bordered table-hover" width="30%">
					<thead>
					<tr>
					  <td>Omset</td>
					  <td>:</td>
					  <td><?php echo $omset?></td>
					</tr>
					</thead>
				</table>
        </div><!-- /.box-body -->
        <div class="box-footer">
            
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
	
        <div class="box-footer">
          </div>
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
	


</section><!-- /.content -->

<?php 
$this->load->view('template/js');
?>
<!--tambahkan custom js disini-->
<!-- DataTables -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datepicker/bootstrap-datepicker.js')?>"></script>

<!-- AutoNumeric -->
<script src="<?php echo base_url('assets/AutoNumeric/autoNumeric.js')?>" type="text/javascript"></script>

<script>
  jQuery(function($) {
	$('#datepicker').datepicker({			
		autoclose: true
	});
	
    $('#tbl-invoice').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
	
	$('.auto').autoNumeric('init');
  });
</script>
<?php
$this->load->view('template/foot');
?>