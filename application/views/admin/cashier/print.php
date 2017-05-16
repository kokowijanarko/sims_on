<!--tambahkan custom css disini-->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="<?php echo base_url('assets/font-awesome-4.3.0/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo base_url('assets/ionicons-2.0.1/css/ionicons.min.css') ?>" rel="stylesheet" type="text/css" />
        
		<style>
		table{
			border:none;
		}
		</style>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-body">
			<div class="row col-md-8">
			<?php
						// var_dump($inv, $inv_detail);
					?>
				<div class="col-md-6">
					
						<table class="table">
							<tr>
								<td>No. Nota</td>
								<td>:</td>
								<td id="no_nota"></td>
							</tr>
							<tr>
								<td>Tanggal Order</td>
								<td>:</td>
								<td id="ord_date_order"></td>
							</tr>
							<tr>
								<td>Tanggal Pengambilan</td>
								<td>:</td>
								<td id="ord_date_take">
								</td>
							</tr>
							<tr>
								<td>Tanggal Lihat Desain</td>
								<td>:</td>
								<td id="ord_date_design">
								</td>
							</tr>										
						</table>
					</div>	
					<div class="col-md-6">
						<table class="table">
							<tr>
								<td>Nama</td>
								<td>:</td>
								<td id="ord_name"></td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td>:</td>
								<td id="ord_address"></td>
							</tr>			
							<tr>
								<td>No. Kontak</td>
								<td>:</td>
								<td id="ord_contact"></td>
							</tr>
							<tr>
								<td>Email</td>
								<td>:</td>
								<td id="ord_email"></td>
							</tr>
						</table>
					</div>
					<div class="col-sm-12">
						<table id="tbl-produk-order" class="table table-bordered table-hover">
							<thead>
							<tr>
								<th>NO</th>
								<th>Produk</th>
								<th>Harga</th>
								<th>Jumlah</th>
								<th>Keterangan</th>
								<th>Sub-Total</th>
							</tr>
							</thead>
							<tfoot>
								<tr>
									<td colspan="5">RETUR</td>
									<td class="auto" id="retur"></td>
								</tr>
								<tr>
									<td colspan="5">TOTAL</td>
									<td class="auto" id="total"></td>
								</tr>
								<tr>
									<td colspan="2">Cara Pembayaran</td>	
									<td id="order_payment_way" colspan="3"> </td>	
								</tr>								
								<tr id="tr_dp">
									<td colspan="2">DP</td>
									<td id="down_payment" colspan="3"><td>
								</tr>
								<tr id="tr_kurang">
									<td colspan="2">Kurang</td>
									<td id="minus" colspan="3"><td>
								</tr>
								<tr id="tr_status hide">
									<td colspan="2"></td>
									<td id="status" colspan="3"><td>
								</tr>								
							</tfoot>
						</table>		
						<input type="hidden" id="order_id">
					</div>
					<div class="col-md-3 pull-right">
						Front Office </br></br></br></br>						
						<label> <?php echo $this->session->userdata('fullname')?>
						</label>					
					</div>	
			</div><!-- /.box-body -->
    </div><!-- /.box -->
	
	
</section><!-- /.content -->
<!--tambahkan custom js disini-->
<!-- Select2 -->
<script src="../../plugins/select2/select2.full.min.js"></script>
<!-- jQuery 2.1.3 -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jQuery/jQuery-2.1.3.min.js') ?>"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
<!-- SlimScroll -->

<script>	

	jQuery(function($) {
		// window.print('<section>');
		var invoice_number = '<?php echo $inv->order_code?>';
		console.log(invoice_number);
		$.ajax({
			data:{'invo_number':invoice_number},
			method:'post',
			url:'<?php echo site_url('cashier/get_detail_invoice')?>'
		}).success(function(result){
			
			console.log(result);
			result = JSON.parse(result);
			if(result['order']['order_cash_minus'] == 0){
				var status = 'LUNAS';				
				$('#tr_kurang').addClass('hide');				
			}else{
				var status = 'BELUM LUNAS';
			}
			$('#tr_status').removeClass('hide');
			$('#status').text(status);
			if(result['order']['order_payment_way'] == 0){
				var payment_way = 'Cash';
			}else if(result['order']['order_payment_way'] == 1){
				var payment_way = 'Transfer';
			}else if(result['order']['order_payment_way'] == 2){
				var payment_way = 'Debit';
			}
			
			$('#order_payment_way').text(payment_way);
			var dp = $('#down_payment' ).text('Rp. ' + result['order']['order_down_payment']);
			var bayar = $('#cash').text();
			var kurang = $('#minus').text('Rp. ' + result['order']['order_cash_minus']);
			var kembali = $('#cash_back' ).text();
			var no_nota = $('#no_nota').text(result['order']['order_code']);
			var tgl_order = $('#ord_date_order').text(result['order']['order_date_order']);
			var tgl_pengambilan = $('#ord_date_take').text(result['order']['order_date_take']);
			var tgl_lihat_design = $('#ord_date_design').text(result['order']['order_date_design']);
			var nama = $('#ord_name').text(result['order']['order_custommer_name']);
			var alamat = $('#ord_address').text(result['order']['order_address']);
			var kontak = $('#ord_contact').text(result['order']['order_contact']);
			var email = $('#ord_email').text(result['order']['order_email']);			
			var total = $('#total').text(result['order']['order_amount']);			
			var retur = $('#retur').text(result['order']['order_retur']);			
			$('#order_id').val($('#list_order_id').val());
			$( "tbody#order_detail_tbody" ).empty();
			$table = $( "<tbody id=order_detail_tbody></tbody>" );
			
			for(i=0; i < result['detail'].length; i++){
				var sub_total = result['detail'][i]['orderdetail_quantity'] * result['detail'][i]['inv_price'];
				var $line = $( "<tr></tr>" );
				$line.append( $( "<td></td>" ).html(i + 1) );
				$line.append( $( "<td></td>" ).html(result['detail'][i]['inv_name']) );
				$line.append( $( "<td class='auto'></td>" ).html(result['detail'][i]['inv_price']));
				$line.append( $( "<td></td>" ).html(result['detail'][i]['orderdetail_quantity']));
				$line.append( $( "<td></td>" ).html(result['detail'][i]['orderdetail_desc']) );
				$line.append( $( "<td class='auto'></td>" ).html(sub_total));
				$table.append($line);
				//console.log($line);
			}
			$table.appendTo($("#tbl-produk-order"));
			
			$('#box_header_detail').removeClass('hide');
			$('#box_content_detail').removeClass('hide');
		});
	
	})
</script>