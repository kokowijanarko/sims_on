<?php 
$this->load->view('template/head');
?>
<!--tambahkan custom css disini-->
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/select2/select2.css')?>">

<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Customer 
        <small></small>
    </h1>
    
</section>
<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Customer</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<form role="form" method="post" action="<?php echo base_url('index.php/customer/doEdit')?>" enctype="multipart/form-data">
						<input type="hidden" name="id_cust" id="id_cust" value="<?php echo $detail->id_cust?>">
						<div class="form-group">
							<label>Nama Customer</label>
							<input type="text" name="nama_cust" id="nama_cust" class="form-control" placeholder="Nama customer" value="<?php echo $detail->nama_cust?>">
						</div>
						
						<div class="form-group">
							<label>Alamat</label>
							<textarea class="form-control" name="alamat_cust" id="alamat_cust" ><?php echo $detail->alamat_cust?></textarea>
						</div>
						
						<div class="form-group">
							<label>Nomor Hp</label>
							<input type="text" min="0" name="nohp_cust" id="nohp_cust" class="form-control" value="<?php echo $detail->nohp_cust?>">
						</div>
						<div class="box-footer">
							<button type="cancel" class="btn btn-warning">Batal</button>
							<button type="submit" class="btn btn-info pull-right">Simpan</button>
						</div>
					</form>
				</div>
			</div><!-- /.box-body -->
        <div class="box-footer">
            
        </div><!-- /.box-footer-->
    </div><!-- /.box -->

</section><!-- /.content -->

<?php 
$this->load->view('template/js');
?>
<!--tambahkan custom js disini-->
<!-- Select2 -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/select2/select2.full.js')?>"></script>

<script>	
	jQuery(function($) {
		
		
	})
</script>
<?php
$this->load->view('template/foot');
?>