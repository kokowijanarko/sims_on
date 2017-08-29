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
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Detail Perhitungan Kmeans
        <small></small>
    </h1>
    
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Statistik Penjualan</h3>    
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>						
				<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="box-body">
			<div class="box-header with-border">
				<h3 class="box-title">Periode <?php echo $filter['date_start'] ?> - <?php echo $filter['date_end'] ?> </h3>    
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>						
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div>
				<table id = "table_statistic" class="table">
				<thead>
					<tr>
						<th>No</th>
						<th>Produk</th>
						<th>Jumlah Terjual</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no = 1;
						foreach($statistic as $idx=>$val){
							echo "
								<tr>
									<td>$no</td>
									<td>". $val->product_name ."</td>
									<td>". $val->jumlah ."</td>
								</tr>
							";
							$no++;
						}					
					?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
	
	
<?php
	$loop = 1;
	foreach($kmeans['centroid'] as $idx=>$cent){
		echo '
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Perhitungan Kmean Iterasi '. $loop .'</h3>    
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>						
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
		';
		
		echo '
			<div>
			<table>
				<tr>
					<th colspan="3">Centroid</th>
				</tr>
				<tr>
					<th>Tinggi</th>
					<td>:</td>
					<td>'. $cent['tinggi'] .'</td>
				</tr>
				<tr>
					<th>Sedang</th>
					<td>:</td>
					<td>'. $cent['sedang'] .'</td>
				</tr>
				<tr>
					<th>Rendah</th>
					<td>:</td>
					<td>'. $cent['rendah'] .'</td>
				</tr>
			</table>
			</div>
		';
		echo '
			<div>
			<table class="table">
			<thead>
				<tr>
					<th>NO</th>
					<th>Produk</th>
					<th>Jumlah</th>
					<th>Rendah</th>
					<th>Sedang</th>
					<th>Tinggi</th>
				</tr>
			</thead>
			<tbody>
		';
		$no = 1;
		foreach($kmeans['jarak'][$idx] as $key=>$space){
				echo '
					<tr>
					<td>'. $no .'</td>
					<td>'. $space['product_name'] .'</td>
					<td>'. $space['jumlah'] .'</td>
					<td>'. $space[0] .'</td>
					<td>'. $space[1] .'</td>
					<td>'. $space[2] .'</td>
				</tr>	
				';
			$no++;
		}
		echo '</tbody></table>';
		echo '</div></div></div>';
		$loop++;
	}
	

?>
			
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
	
    $('.table').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true
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