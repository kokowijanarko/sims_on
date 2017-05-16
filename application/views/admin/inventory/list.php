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
        Inventori
        <small></small>
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Barang dan Stok</h3>
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
					<form role="form" method="post" action="<?php echo site_url('inventory')?>">
						<div class="form-group">
							<label>Produk</label>
							<input type="text" name="product" id="product" class="form-control" placeholder="Produk" value="<?php if(isset($filter['product'])){echo $filter['product'];}?>">
						</div>
						
						<div class="form-group">
							<label>Kategori</label>
							<select id="category" name="category" class="form-control select2" style="width: 100%;">
								<option value=''>--Pilih--</option>
								<?php
									foreach($category as $cat){
										$select = '';
										
										if(isset($filter['category'])){
											if($filter['category'] !== '' || !empty($filter['category'])){
												if($filter['category'] == $cat['id']){
													$select = 'selected';
												}
											}
										}
										
										echo '<option value="'.$cat['id'] .'" '. $select .'>'.$cat['name'] .'</option>';
									}
								?>
								
							</select>
						</div>
						
						<div class="box-footer">
							<button type="cancel" class="btn btn-warning">Cari</button>
						</div>
					<form>
				</div>
			</div>
		
			<div class="col-md-12">
				<?php echo isset($message)?$message:NULL?>
			</div>
			<div class="col-md-12">
				<div style="float:right" class="col-md-2">
					<a href="<?php echo base_url('index.php/inventory/add')?>" ><button type="button" class="btn btn-block btn-success btn-sm">Tambah Produk</button></a>
				</div>
			</div>
			</br>
			</br>
			<table id="tbl-inventory" class="table table table-striped table-bordered table-hover">
                <thead>
					<tr>
					  <th>No</th>
					  <th width="15%">Produk</th>
					  <th width="10%">Kategori</th>
					  <th>Harga Jual</th>
					  <th>Harga</th>
					  <th>Stok</th>
					  <th>Input</th>
					  <th>Update</th>
					  <th class="hidden-480">Deskripsi</th>
					  <th class="action">Aksi</th>
					</tr>
                </thead>
                <tbody>
					<?php
						$no=1;
						foreach($list as $value){
							echo '<tr>';
							echo '<td>'.$no.'</td>';
							echo '<td>'.$value->product_name.'</td>';
							echo '<td>'.$value->category_name.'</td>';
							echo '<td>'.number_format($value->product_price, '2', ',', '.') .'</td>';
							echo '<td>'.number_format($value->product_price_base, '2', ',', '.') .'</td>';
							echo '<td>'.$value->product_stock.'</td>';
							echo '<td>'.$value->insert_user.', '.$value->insert_timestamp.'</td>';
							echo '<td>'.$value->update_user.', '.$value->update_timestamp.'</td>';
							echo '<td class="hidden-480">'.$value->product_desc.'</td>';
							echo '<td class = "action">
								<div class="btn-group">
									<button type="button" class="btn btn-info btn-flat">Aksi</button>
									<button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="'.base_url('index.php/inventory/edit/'.$value->product_id).'">Edit</a></li>
										<li><a href="'.site_url('inventory/doDelete/'.$value->product_id).'">Hapus</a></li>
										<li class = "hide"><a href="'.site_url('mass_price/listing/'.$value->product_id).'">Lihat Harga Massal</a></li>
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