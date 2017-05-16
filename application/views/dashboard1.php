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
        <section class="col-lg-8 connectedSortable">
            <div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Monthly Recap Report</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button></div>
				</div>
				<div class="box-body">
                    <div class="row">
						<div class="chart">
							<!-- Sales Chart Canvas -->
							<canvas id="salesChart" style="height: 180px;"></canvas>
						</div>					
					</div>
				</div>
				
			</div>
            
        </section><!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
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
		var param = [
				{label: "Download Sales", value: 150},
				{label: "In-Store Sales", value: 10},
				{label: "Mail-Order Sales", value: 10}
			];
		
		donut('donut-example', param);
		
		// Get context with jQuery - using jQuery's .get() method.
		var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
		// This will get the first returned node in the jQuery collection.
		var salesChart = new Chart(salesChartCanvas);

		var salesChartData = {
			labels: ["January", "February", "March", "April", "May", "June", "July"],
			datasets: [
			  {
				label: "Electronics",
				fillColor: "rgb(210, 214, 222)",
				strokeColor: "rgb(210, 214, 222)",
				pointColor: "rgb(210, 214, 222)",
				pointStrokeColor: "#c1c7d1",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgb(220,220,220)",
				data: [65, 59, 80, 81, 56, 55, 40]
			  },
			  {
				label: "Digital Goods",
				fillColor: "rgba(60,141,188,0.9)",
				strokeColor: "rgba(60,141,188,0.8)",
				pointColor: "#3b8bba",
				pointStrokeColor: "rgba(60,141,188,1)",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(60,141,188,1)",
				data: [28, 48, 40, 19, 86, 27, 90]
			  }
			]
		  };

		var salesChartOptions = {
			//Boolean - If we should show the scale at all
			showScale: true,
			//Boolean - Whether grid lines are shown across the chart
			scaleShowGridLines: false,
			//String - Colour of the grid lines
			scaleGridLineColor: "rgba(0,0,0,.05)",
			//Number - Width of the grid lines
			scaleGridLineWidth: 1,
			//Boolean - Whether to show horizontal lines (except X axis)
			scaleShowHorizontalLines: true,
			//Boolean - Whether to show vertical lines (except Y axis)
			scaleShowVerticalLines: true,
			//Boolean - Whether the line is curved between points
			bezierCurve: true,
			//Number - Tension of the bezier curve between points
			bezierCurveTension: 0.3,
			//Boolean - Whether to show a dot for each point
			pointDot: false,
			//Number - Radius of each point dot in pixels
			pointDotRadius: 4,
			//Number - Pixel width of point dot stroke
			pointDotStrokeWidth: 1,
			//Number - amount extra to add to the radius to cater for hit detection outside the drawn point
			pointHitDetectionRadius: 20,
			//Boolean - Whether to show a stroke for datasets
			datasetStroke: true,
			//Number - Pixel width of dataset stroke
			datasetStrokeWidth: 2,
			//Boolean - Whether to fill the dataset with a color
			datasetFill: true,
			//String - A legend template
			legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%=datasets[i].label%></li><%}%></ul>",
			//Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
			maintainAspectRatio: true,
			//Boolean - whether to make the chart responsive to window resizing
			responsive: true
		  };

		//Create the line chart
		salesChart.Line(salesChartData, salesChartOptions);

		//---------------------------
		//- END MONTHLY SALES CHART -
		//---------------------------
		
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