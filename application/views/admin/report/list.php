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
        Daftar Penjualan
        <small></small>
    </h1>
    
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
	<div class="box">
		<div class="box-header with-border">
            <h3 class="box-title">Cari</h3>
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
								<input type="text" name="date" id="datepicker" value="<?php $val = isset($post['date']) ? ($post['date'] == 'all' ? null : date('d-m-Y', strtotime($post['date']))):null; echo $val;?>" class="form-control">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
							</div>	
							<br>
						</td>
						<td>
							s/d
						</td>
						<td width="200px">
							<br>
							<div class="input-group date">								
								<input type="text" name="date_end" id="date_end" value="<?php $val = isset($post['date_end']) ? ($post['date_end'] == 'all' ? null : date('d-m-Y', strtotime($post['date_end']))):null; echo $val;?>" class="form-control">
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
												if($post['user'] == $val->id_user){
													$cek = 'selected';
												}
											}
											echo '<option value="'. $val->id_user .'" '. $cek .'>'.$val->nama_user.'</option>';
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
					<h3 class="box-title">Review Klasifikasi Penjualan</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>						
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div>
					<a href="<?php echo site_url('report/kmeans_detail?date_start='. $post['date'] .'&date_end='.$post['date_end'].'&user='. $post['user'])?>" target="_blank">
						<button class="btn btn-success">
							Detail Perhitungan
						</button>
					</a>
					</div>
					<div>
                    <table id = "table_kmeans" class="table">
						<?php echo $kmeans?>
                    </table>
					</div>
				</div>
			</div>
	<div class="box">
		<div class="box-header with-border">
            <h3 class="box-title">Daftar Penjualan</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
			
        <div class="box-body">
			<div>
				<a href="<?php echo site_url('report/daily_list_print?date='. $date .'&fo='. $fo)?>" target="_blank"><button class="btn btn-sm btn-primary">Cetak Laporan</button></a>
			</div>
			<br>
			<div>
			<table id="tbl-invoice" class="table table-bordered table-hover">
                <thead>
                <tr>
					<th>No</th>
					<th>Nomor Invoice</th>
					<th>Atas Nama</th>				  
					<th>Alamat</th>		
					<th>tanggal</th>
					<th>ongkir</th>
					<th>diskon</th>					
					<th>Total</th>
					<th>User</th>
                </tr>
                </thead>
                <tbody>
					<?php
						$no=1;
						$amount = array();
						foreach($invoice as $val){	
							echo'
								<tr>
									<td>'. $no .'</td>
									<td><button  type="button" class="invoice_detail btn btn-sm btn-info">'.$val->kode_invoice.'</button></td>
									<td>'. $val->nama_cust .'</td>
									<td>'. $val->alamat_cust .'</td>
									<td>'. $val->tgl_trans .'</td>
									<td>'. $val->biaya_kirim .'</td>
									<td>'. $val->diskon .'</td>
									<td>'. $val->total .'</td>
									<td>'. $val->nama_user .'</td>
								</tr>
							';
							
							$no++;
						}
						$omset = array_sum($amount);
						
					?>
				</tbody>
              </table>
			  </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
            
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
	
	<div id="box_detail" class="box hide">
        <div class="box-header with-border">
            <h3 class="box-title">Detail Penjualan</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool hide" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
			<div class="row">
				
					<div class="col-md-6">
						<table class="table">
							<tr>
								<td>No. Nota</td>
								<td>:</td>
								<td id="no_nota"></td>
							</tr>
							<tr>
								<td>Tanggal Order</td>
								<td>:</td>
								<td id="ord_date_order"></td>
							</tr>						
						</table>
					</div>	
					<div class="col-md-6 pull-right">
						<table class="table">
							<tr>
								<td>Nama</td>
								<td>:</td>
								<td id="ord_name"></td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td>:</td>
								<td id="ord_address"></td>
							</tr>			
							<tr>
								<td>No. Kontak</td>
								<td>:</td>
								<td id="ord_contact"></td>
							</tr>
						</table>
					</div>
					<div class="col-sm-12">
						<table id="tbl-produk-order" class="table table-bordered table-hover">
							<thead>
							<tr>
								<th>NO</th>
								<th>Produk</th>
								<th>Harga</th>
								<th>Jumlah</th>
								<th>Sub-Total</th>
							</tr>
							</thead>
							<tfoot>
								<tr>
									<td colspan="4">Ongkir</td>
									<td class="auto" id="ongkir"></td>
								</tr>
								<tr>
									<td colspan="4">Diskon</td>
									<td class="auto" id="diskon"></td>
								</tr>
								<tr>
									<td colspan="4">TOTAL</td>
									<td class="auto" id="total"></td>
								</tr>
							</tfoot>
						</table>								
						<input type="hidden" id="order_id">
					</div>
					<div class="col-md-4 pull-left hide">
						<button id="proc-print" type="submit" class="btn btn-warning">Cetak</button>
					</div>
						
			</div><!-- /.box-body -->
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
	$('#date_end').datepicker({			
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
	
	
	$('.invoice_detail').click(function(){
		$('#box_detail').removeClass('hide');
		
		var invoice_number = $(this).text();
		console.log(invoice_number);
		$.ajax({
			data:{'invo_number':invoice_number},
			method:'post',
			url:'<?php echo site_url('cashier/get_detail_invoice')?>'
		}).success(function(result){			
			
			result = JSON.parse(result);
			console.log(result);
			
			var no_nota = $('#no_nota').text(result['penjualan']['kode_invoice']);
			var tgl_order = $('#ord_date_order').text(result['penjualan']['tgl_trans']);
			var nama = $('#ord_name').text(result['penjualan']['nama_cust']);
			var alamat = $('#ord_address').text(result['penjualan']['alamat_cust']);
			var kontak = $('#ord_contact').text(result['penjualan']['nohp_cust']);			
			var total = $('#total').text(result['penjualan']['ttl_byr']);
			var total = $('#ongkir').text(result['penjualan']['biaya_kirim']);
			var total = $('#diskon').text(result['penjualan']['diskon']);
			
			$( "tbody#order_detail_tbody" ).empty();
			$table = $( "<tbody id=order_detail_tbody></tbody>" );
			
			for(i=0; i < result['detail'].length; i++){
				//var sub_total = result['detail'][i]['orderdetail_quantity'] * result['detail'][i]['inv_price'];
				var $line = $( "<tr></tr>" );
				$line.append( $( "<td></td>" ).html(i + 1) );
				$line.append( $( "<td></td>" ).html(result['detail'][i]['nama_prod']) );
				$line.append( $( "<td class='auto'></td>" ).html(result['detail'][i]['harga']));
				$line.append( $( "<td></td>" ).html(result['detail'][i]['jml_jual']));
				$line.append( $( "<td></td>" ).html(result['detail'][i]['total']));
				$table.append($line);
				//console.log($line);
			}
			$table.appendTo($("#tbl-produk-order"));
			
			$('#box_header_detail').removeClass('hide');
			$('#box_content_detail').removeClass('hide');
		});
	});
	
	// $.ajax({
			// url:'<?php echo site_url('dashboard/kmeans/')?>'
		// }).success(function(result){
			// result = JSON.parse(result);
			// console.log(result);
			// $('#table_kmeans').append(result);
		// });	
  });
</script>
<?php
$this->load->view('template/foot');
?>