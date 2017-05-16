</div><!-- /.content-wrapper -->

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.0
    </div>
    <strong>Copyright &copy; 2016 <a href="https://web.facebook.com/renita.juliansasi">Renita Juliansasi</a>.</strong> All rights reserved.
</footer>
</div><!-- ./wrapper -->

<!-- jQuery 2.1.3 -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jQuery/jQuery-2.1.3.min.js') ?>"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/slimScroll/jquery.slimScroll.min.js') ?>" type="text/javascript"></script>
<!-- FastClick -->
<script src='<?php echo base_url('assets/AdminLTE-2.0.5/plugins/fastclick/fastclick.min.js') ?>'></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/dist/js/app.min.js') ?>" type="text/javascript"></script>
<!-- AdminLTE App 
<script src="<?php echo base_url('assets/js/jquery.validate.js') ?>" type="text/javascript"></script>-->
<script src="<?php echo base_url('assets/js/jquery.mask.js') ?>" type="text/javascript"></script>-->

<script>
	jQuery(function($) {
		var level = <?php echo $this->session->userdata('level')?>;
		if(level == 2){
			$('#menu_cashier').addClass('hide');
		}
		if(level == 3){		
			$('#menu_user').addClass('hide');
		}
		if(level == 4){
			$('#menu_cashier').addClass('hide');
			$('#menu_user').addClass('hide');
		}
		console.log(level);		
	});
</script>