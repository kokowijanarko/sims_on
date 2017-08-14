<?php
$this->load->view('template/head');
?>

<!--tambahkan custom css disini-->
<!-- iCheck -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/iCheck/flat/blue.css') ?>" rel="stylesheet" type="text/css" />
<!-- Morris chart -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/morris/morris.css') ?>" rel="stylesheet" type="text/css" />
<!-- jvectormap -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jvectormap/jquery-jvectormap-1.2.2.css') ?>" rel="stylesheet" type="text/css" />
<!-- Date Picker -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datepicker/datepicker3.css') ?>" rel="stylesheet" type="text/css" />
<!-- Daterange picker -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/daterangepicker/daterangepicker-bs3.css') ?>" rel="stylesheet" type="text/css" />
<!-- bootstrap wysihtml5 - text editor -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>" rel="stylesheet" type="text/css" />

<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Alesa</small>
    </h1>
    
</section>

<!-- Main content -->
<section class="content">
    
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-4 connectedSortable">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Top 5 best Seller</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>						
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
                    <div class="row">
						<div id="donut-example" style="position: relative; height: 300px;"></div>				
					</div>
				</div>			
			</div>           
        </section><!-- right col -->
		
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-8 connectedSortable">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Review Klasifikasi Penjualan</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>						
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
                    <table id = "table_kmeans" class="table">
						
                    </table>
				</div>
				<div class="box-footer">
                    <a href="<?php echo site_url('inventory')?>">Detail....</a>
				</div>			
			</div>
          
            
        </section><!-- right col -->
    
	</div><!-- /.row (main row) -->

</section><!-- /.content -->


<?php
$this->load->view('template/js');
?>

<!--tambahkan custom js disini-->
<!-- jQuery UI 1.11.2 -->
<script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>" type="text/javascript"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Morris.js charts -->
<script src="<?php echo base_url('assets/js/raphael-min.js') ?>"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/morris/morris.min.js') ?>" type="text/javascript"></script>

<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/chartjs/Chart.min.js')?>"></script>


<script type="text/javascript">
	jQuery(function($) {
		$.ajax({
			url:'<?php echo site_url('dashboard/get_top5/')?>'
		}).success(function(result){
			result = JSON.parse(result);
			console.log(result);
			
			var params = [];
			$.each(result,function(i){
				var product = result[i]['product_name'];
				var selling_value = result[i]['jumlah'];
				
				params[i] = {label:product, value:selling_value}
				
			})	
			console.log(params);
			donut('donut-example', params);
		});	
		
		$.ajax({
			url:'<?php echo site_url('dashboard/kmeans/')?>'
		}).success(function(result){
			result = JSON.parse(result);
			console.log(result);
			$('#table_kmeans').append(result);
		});	
	})
	
	function donut(id, param){
		Morris.Donut({
			element: id,
			data: param
		});
	}
	
	
</script>
<?php
$this->load->view('template/foot');
?>