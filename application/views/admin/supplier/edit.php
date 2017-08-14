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
        User 
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Pengguna Aplikasi</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<form role="form" method="post" action="<?php echo base_url('index.php/supplier/doEdit')?>" enctype="multipart/form-data">
						<input type="hidden" name="id_sup" id="id_sup" value="<?php echo $detail->id_sup?>">
						<div class="form-group">
							<label>Nama Supplier</label>
							<input type="text" name="nama_sup" id="nama_sup" class="form-control" placeholder="Nama Supplier" value="<?php echo $detail->nama_sup?>">
						</div>
						
						<div class="form-group">
							<label>Alamat</label>
							<textarea class="form-control" name="alamat_sup" id="alamat_sup" ><?php echo $detail->alamat_sup?></textarea>
						</div>
						
						<div class="form-group">
							<label>Nomor Hp</label>
							<input type="text" min="0" name="nohp_sup" id="nohp_sup" class="form-control" value="<?php echo $detail->nohp_sup?>">
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
		$('#user').val('<?php echo $detail->inv_name?>');	
		$('#category').val('<?php echo $detail->inv_category_id?>');
		$('#type').val('<?php echo $detail->inv_type_id?>');
		$('#harga').val('<?php echo $detail->inv_price?>');
		$('#stok').val('<?php echo $detail->inv_stock?>');
		$('#deskripsi').val('<?php echo $detail->inv_desc?>');
		$('#id').val('<?php echo $detail->inv_id?>');
		//console.log('<?php echo $detail->inv_name?>');
		
		$('#type').change(function(){
			var category = $('#category option:selected').text();
			var type = $('#type option:selected').text();
			var produk = category + ' ' + type;
			//console.log(produk);
			$('#produk').val(produk);
			
		});		
	})
</script>
<?php
$this->load->view('template/foot');
?>