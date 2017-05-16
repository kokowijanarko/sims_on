<?php 
$this->load->view('template/head');
?>
<!--tambahkan custom css disini-->

<!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css">
<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Order
        <small></small>
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Order</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
			<?php
				
				// var_dump($filter, $category);
			?>
			<div class="col-md-12">
				<div class="col-md-4">
					
				</div>
			</div>
		
			<div class="col-md-12">
				<?php echo isset($message)?$message:NULL?>
			</div>
			</br>
			</br>
			<table id="tbl-inventory" class="table table table-striped table-bordered table-hover">
                <thead>
					<tr>
					  <th rowspan="2">No</th>
					  <th rowspan="2">No. Invoice</th>
					  <th rowspan="2">Nama Pelanggan</th>
					  <th colspan="12" align="center">Shipping Detail</th>
					</tr>
					<tr>
					  <th>Nama</th>
					  <th>Alamat</th>
					  <th>Kode POS</th>
					  <th>No. Telp</th>
					  <th>Total Order</th>
					  <th>Pengiriman</th>
					  <th>Catatan Pengiriman</th>
					  <th>Biaya Kirim</th>
					  <th>Total</th>
					  <th>Insert</th>
					  <th>Update</th>
					  <th class="action">Aksi</th>
					</tr>
                </thead>
                <tbody>
					<?php
						$no=1;
						foreach($list as $value){
							echo '<tr>';
							echo '<td>'.$no.'</td>';
							echo '<td>'.$value->order_number.'</td>';
							echo '<td>'.$value->customer_name.'</td>';
							echo '<td>'.$value->order_name.'</td>';
							echo '<td>'.$value->order_address.'</td>';
							echo '<td>'.$value->order_post_code.'</td>';
							echo '<td>'.$value->order_phone_number.'</td>';
							echo '<td>'.number_format($value->order_amount, '2', ',', '.').'</td>';
							echo '<td>'.$value->order_shipping .'</td>';
							echo '<td>'.$value->order_shipping_note .'</td>';
							echo '<td>'.number_format($value->order_shipping_cost, '2', ',', '.').'</td>';
							echo '<td>'.number_format($value->order_total, '2', ',', '.').'</td>';
							echo '<td>'.$value->insert_by .'</td>';
							echo '<td>'.$value->update_by .'</td>';
							echo '<td class = "action">
								<div class="btn-group">
									<button type="button" class="btn btn-info btn-flat">Aksi</button>
									<button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="'.base_url('index.php/inventory/edit/'.$value->order_id).'">Edit</a></li>
										<li><a href="'.site_url('inventory/doDelete/'.$value->order_id).'">Hapus</a></li>
										<li class = "hide"><a href="'.site_url('mass_price/listing/'.$value->order_id).'">Lihat Harga Massal</a></li>
									</ul>
								</div>
							
							</td>';
							echo '</tr>';
							$no++;
						}
					?>
                </tbody>
              </table>
            
        </div><!-- /.box-body -->
        <div class="box-footer">
           
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

<!-- AutoNumeric -->
<script src="<?php echo base_url('assets/AutoNumeric/autoNumeric.js')?>" type="text/javascript"></script>

<script>
  jQuery(function($) {
	  var level = <?php echo $this->session->userdata('level')?>;
	  if(level == 3 || level == 4){
			$('.action').addClass('hide');
	  }
    $('#tbl-inventory').DataTable({
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