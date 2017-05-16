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
					<form role="form" method="post" action="<?php echo site_url('user/doEdit')?>" enctype="multipart/form-data">
					<input type="hidden" value="<?php echo $detail->user_id?>" name="id" id="id">
						<div class="form-group">
							<label>Nama Lengkap</label>
							<input type="text" value="<?php echo $detail->user_name?>" name="user_name" id="user_name" class="form-control" placeholder="Nama Lengkap">
						</div>
						<div class="form-group">
							<label>Username</label>
							<input type="text" value="<?php echo $detail->user_username?>" name="user_username" id="user_username" class="form-control" placeholder="Username">
						</div>
						<div class="form-group">
							<label>Level</label>
							<select id="level" name="level" class="form-control select2" style="width: 100%;">
								<option value=''>--Pilih--</option>
								<?php
									foreach($level as $lvl){
										$cek='';
										if($lvl->level_id == $detail->user_level_id){
											$cek = 'selected';
										}
										echo '<option value="'.$lvl->level_id .'" '. $cek .'>'.$lvl->level_name .'</option>';
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label>Foto</label>
							<input type="file" name="photo" id="photo">							
							<label><img height="100px" src="<?php echo base_url('assets/user_img/'. $detail->user_photo_name)?>"></label>
						</div>
						<div class="form-group">
							<label>Deskripsi</label>
							<textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" placeholder="Enter ..."><?php echo $detail->user_desc?></textarea>
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