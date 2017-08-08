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

<!-- Main content -->
<section class="content">
	<?php
		// var_dump($detail);
	?>
    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Barang</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<form role="form" method="post" action="<?php echo base_url('index.php/inventory/doEdit')?>">
					<input type="hidden" name="id" id="id" value="<?php echo $detail->id_prod?>">
						<div class="form-group">
							<label>Produk</label>
							<input type="text" name="produk" id="produk" class="form-control" placeholder="Produk" value="<?php echo $detail->nama_prod?>">
						</div>
						
						<div class="form-group">
							<label>Kategori</label>
							<select id="category" name="category" class="form-control select2" style="width: 100%;">
								<option value=''>--Pilih--</option>
								<?php
									foreach($category as $cat){
										$select = '';
										if($cat['id'] == $detail->jenis_prod){
											$select="selected";
										}
										echo '<option value="'.$cat['id'] .'" '. $select .'>'.$cat['name'] .'</option>';
									}
								?>
								
							</select>
						</div>
						<!-- /.form-group -->
						<div class="form-group">
							<label>Harga</label>
							<div class="input-group">
								<span class="input-group-addon">Rp</span>
								<input id="harga"  type="number" name="harga" class="form-control" value="<?php echo $detail->harga?>">
								<span class="input-group-addon">.00</span>
							</div>
						</div>
						
						<div class="form-group">
							<label>Stok</label>
							<div class="input-group">
								<span class="input-group-addon">@</span>
								<input id="stok"  type="number" name="stok" class="form-control" value="<?php echo $detail->stok?>">
								<span class="input-group-addon">Biji</span>
							</div>
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
		
		//console.log('<?php echo $detail->inv_name?>');
	})
</script>
<?php
$this->load->view('template/foot');
?>