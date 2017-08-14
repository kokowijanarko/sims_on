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
        Supplier
        <small>Data</small>
    </h1>
</section>
<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Tambah Supplier</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<form role="form" method="post" action="<?php echo base_url('index.php/supplier/doAdd')?>" enctype="multipart/form-data">
						<div class="form-group">
							<label>Nama Supplier</label>
							<input type="text" name="nama_sup" id="nama_sup" class="form-control" placeholder="Nama Supplier">
						</div>
						
						<div class="form-group">
							<label>Alamat</label>
							<textarea class="form-control" name="alamat_sup" id="alamat_sup"></textarea>
						</div>
						
						<div class="form-group">
							<label>Nomor Hp</label>
							<input type="text" min="0" name="nohp_sup" id="nohp_sup" class="form-control">
						</div>
						<div class="box-footer">
							<button type="cancel" class="btn btn-warning">Batal</button>
							<button type="submit" class="btn btn-info pull-right">Simpan</button>
						</div>
					</form>
				</div>
			</div><!-- /.box-body -->
        
		</div>
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
		//url='<?php echo site_url('inventory/get_type_by_cat/')?>'
		//console.log(url);
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
				data:{'category_id':cat_id},
				method:'post',
				url:'<?php echo site_url('cashier/get_type_by_cat/')?>'
			}).success(function(result){
				$('#type').empty();
				result = JSON.parse(result);
				for(i=0; i<result.length; i++){
					$('#type').append('<option value="'+result[i]['type_id']+'">'+result[i]['type_name']+'</option>');
				}
				
			});
			
		}
	})
</script>
<?php
$this->load->view('template/foot');
?>