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
        Customer
        <small>Data</small>
    </h1>
    
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Customer</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
			<div class="col-md-12">
				<?php echo isset($message)?$message:NULL?>
			</div>
			<div style="float:right" class="col-md-2">
				<a href="<?php echo base_url('index.php/customer/add')?>" ><button type="button" class="btn btn-block btn-success btn-sm">Tambah customer</button></a>
			</div>
			</br>
			</br>
			<table id="tbl-inventory" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama customer</th>
                  <th>Alamat</th>
                  <th>No HP</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
					<?php
						$no=1;
						foreach($list as $value){
							echo '<tr>';
							echo '<td>'.$no.'</td>';
							echo '<td>'.$value->nama_cust.'</td>';
							echo '<td>'.$value->alamat_cust.'</td>';
							echo '<td>'.$value->nohp_cust.'</td>';
							echo '<td>
								<div class="btn-group">
									<button type="button" class="btn btn-info btn-flat">Aksi</button>
									<button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="'.site_url('customer/edit/'.$value->id_cust).'">Edit</a></li>
										<li><a href="'.site_url('customer/doDelete/'.$value->id_cust).'">Hapus</a></li>
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