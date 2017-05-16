<?php 
$this->load->view('template/head');
?>
<!--tambahkan custom css disini-->
<!-- Select2 -->
<link rel="stylesheet" href="../../plugins/select2/select2.min.css">

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
            <h3 class="box-title">Tambah Barang</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<form role="form" method="post" action="<?php echo base_url('index.php/inventory/doAdd')?>">
						<div class="form-group">
							<label>Produk</label>
							<input type="text" name="produk" id="produk" class="form-control" placeholder="Produk">
						</div>
						
						<div class="form-group">
							<label>Kategori</label>
							<select id="category" name="category" class="form-control select2" style="width: 100%;">
								<option value=''>--Pilih--</option>
								<?php
									foreach($category as $cat){
										echo '<option value="'.$cat->category_id .'">'.$cat->category_name .'</option>';
									}
								?>
								
							</select>
						</div>
						<!-- /.form-group -->
						
						<div class="form-group">
							<label>Tipe</label>
							<select id="type" name="type" class="form-control select2" style="width: 100%;">
								<option value=''>--Pilih--</option>
								<?php
									// foreach($type as $tp){
										// echo '<option value="'.$tp->type_id .'">'.$tp->type_name .'</option>';
									// }
								?>
								
							</select>
						</div>
						<!-- /.form-group -->					
						
						<div class="form-group">
							<label>Harga</label>
							<div class="input-group">
								<span class="input-group-addon">Rp</span>
								<input id="harga"  type="text" name="harga" pattern="[1-9].{4,}" class="form-control">
								<span class="input-group-addon">.00</span>
							</div>
						</div>
						
						<div class="form-group">
							<label>Stok</label>
							<div class="input-group">
								<span class="input-group-addon">@</span>
								<input id="harga"  type="stok" name="stok" pattern="[1-9].{1,}" class="form-control">
								<span class="input-group-addon">Biji</span>
							</div>
						</div>
						
						<div class="form-group">
							<label>Deskripsi</label>
							<textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" placeholder="Enter ..."></textarea>
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
<script src="../../plugins/select2/select2.full.min.js"></script>

<script>	
	jQuery(function($) {
		url='<?php echo site_url('inventory/getTypeByCat/')?>'
		console.log(url);
		$('#type').prop('disabled', true);
		
		$('#category').change(function(){
			$('#type').prop('disabled', false);
			var category_id = $('#category option:selected').val();
			getTypeOpt(category_id);
			
		});
		$('#type').change(function(){
			var category = $('#category option:selected').text();
			
			var type = $('#type option:selected').text();
			var produk = category + ' ' + type;
			//console.log(produk);
			$('#produk').val(produk);
			
		});
		
		function getTypeOpt(cat_id){
			$.ajax({
				data={'category_id':cat_id},
				method='post',
				url='<?php echo site_url('inventory/getTypeByCat/')?>'
			}).success(function(result){
				result = JSON.parse(result);
				for(i=0; i<result.length; i++){
					$('type').apend('<option val="'+result[i]['type_id']+'">'+result[i]['type_name']+'</option>');
				}
				
			});
			
		}
	})
</script>
<?php
$this->load->view('template/foot');
?>