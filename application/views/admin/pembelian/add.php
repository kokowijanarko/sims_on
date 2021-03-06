<?php 
$this->load->view('template/head');
?>
<!--tambahkan custom css disini-->
<!-- Select2 -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/select2/select2.min.css') ?>" rel="stylesheet" type="text/css" />
<!-- bootstrap datepicker -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datepicker/datepicker3.css') ?>" rel="stylesheet" type="text/css" />


<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Pembelian
        <small></small>
    </h1>
</section>
<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Form Pembelian</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
			<div class="col-md-12">
				<div id="msg">
				</div>
			</div>
			<div class="row">
				
				<div id="form-order">
				<div class="col-md-4">
						<div class="form-group">
							<label>Produk</label>
							<select id="produk" name="produk" class="form-control select2" style="width: 100%;">
								<option value=''>--Pilih--</option>
								<?php
									foreach($produk as $val){
										echo '<option value="'.$val->id_prod.'|'.$val->harga.'">'.$val->nama_prod .'</option>';
									}
								?>								
							</select>
						</div>						
						<div class="form-group">
							<label>Harga Jual</label>
							<div class="input-group">
								<span class="input-group-addon">Rp</span>
								<input id="harga_jual" required type="text" name="harga_jual" pattern="[1-9].{4,}" class="form-control">
								<span class="input-group-addon">.00</span>
							</div>
						</div>
						
						<div class="form-group">
							<label>Harga Beli</label>
							<div class="input-group">
								<span class="input-group-addon">Rp</span>
								<input id="harga" required type="text" name="harga" pattern="[1-9].{4,}" class="form-control">
								<span class="input-group-addon">.00</span>
							</div>
						</div>
						
						<div class="form-group">
							<label>Jumlah</label>
							<div class="input-group">
								<span class="input-group-addon">@</span>
								<input id="jumlah"  type="number" name="jumlah" min="1" class="form-control">
								<span class="input-group-addon">Biji</span>
							</div>
						</div>
						<div class="box-footer">
							<button id="smt-order" type="submit" class="btn btn-info">Tambah</button>
						</div>
					
				</div>
				<div class="col-md-8">
					<div class="col-md-6">
						<table class="table">
							<tbody>
							<tr>
								<td>Tanggal Order</td>
								<td>:</td>
								<td>
									<div class="input-group date">
										<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
										</div>
										<input type="text" name="ord_date_order" value="<?php echo date('d-m-Y')?>" class="form-control" id="ord_date_order">
									</div>
								</td>
							</tr>
							
						</table>
					</div>	
					<div class="col-md-6">
						<table class="table">
							<tbody>
							<tr>
								<td>Supplier</td>
								<td>:</td>
								<td>
									<div class="form-group">
										<select class="form-control" id="ord_name" name="ord_name">
											<option val="#">---PILIH---</option>
											<?php
												foreach($supplier as $key=>$val){
													echo "<option value='". $val->id_sup ."|". $val->alamat_sup ."|". $val->nohp_sup ."'>". $val->nama_sup ."</option>";
												}
											?>
										</select>
									</div>
								
								</td>
								
								
								
							</tr>
							<tr>
								<td>Alamat</td>
								<td>:</td>
								<td><div class="form-group"><textarea class="form-control" id="ord_address" name="ord_address" required></textarea></div></td>
							</tr>			
							<tr>
								<td>No. Kontak</td>
								<td>:</td>
								<td><div class="form-group"><input class="form-control" id="ord_contact" type="text" name="ord_contact" required></div></td>
							</tr>
							<tbody>
						</table>
					</div>
					<div class="col-sm-12">
						<table id="tbl-produk-order" class="table table-bordered table-hover">
							<thead>
							<tr>
								<th>N O</th>
								<th>P r o d u k</th>
								<th>H a r g a</th>
								<th>J u m l a h</th>
								<th>S u b - T o t a l</th>
							</tr>
							</thead>
							<tfoot>
								<tr>
									<td colspan="4">TOTAL</td>
									<td id="total"></td>
								</tr>								
							</tfoot>
						</table>						
					</div>
					<div class="col-md-4 pull-left">						
						<button id="proc-order" type="submit" class="btn btn-success">Proses</button>
						<button id="proc-print" type="submit" class="btn btn-warning hide">Cetak</button>
					</div>
					
					<div class="col-md-3 pull-right">
						Front Office </br></br></br></br>						
						<label> <?php echo $this->session->userdata('fullname')?>
						</label>					
					</div>					
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
<!-- bootstrap datepicker -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datepicker/bootstrap-datepicker.js')?>"></script>


<script type="text/javascript">	

	jQuery(function($) {
		$('#ord_contact').mask('0000-0000-0000');
		// showHide(xxx);
		
		$('#ord_name').change(function(){
			var val = $('#ord_name option:selected').val();
			values = val.split('|');
			
			$('#ord_address').val(values[1]);
			$('#ord_contact').val(values[2]);
		});
		
		
		
		var product_name = [];
		var product_id = [];
		var price = [];
		var price_sell = [];
		var quantity = [];
		var sub_total = [];
		var desc = [];
		var data_order = {product_name, product_id, price, price_sell, quantity, sub_total, desc};
		var id_order = [];
		var is_prod_load;
		
		$('#smt-order').click(function(){
			var prod_val = $('#produk').val();
			var prod_name = $('#produk option:selected').text();
			var prod = prod_val.split('|');			
			//var prod_price = prod[1];
			var prod_id = prod[0];
			var prod_price_sell = $('#harga_jual').val();
			var prod_price = $('#harga').val();
			var prod_quantity = $('#jumlah').val(); 
			var prod_sub_total = prod_price * prod_quantity;
						
			if(prod_id != ""){
				product_id.push(prod_id);
				product_name.push(prod_name);
				price.push(prod_price);
				price_sell.push(prod_price_sell);
				quantity.push(prod_quantity);
				sub_total.push(prod_sub_total);
			}			
			var total = 0;
			for (var i = 0; i < sub_total.length; i++) {
				total += sub_total[i] << 0;
			}
			$('#total').text(total);
			$("#tbl-produk-order").find('tbody').empty();
			var $table = $( "<tbody></tbody>" );
			
			for(i=0; i < product_id.length; i++){
				var $line = $( "<tr></tr>" );
				$line.append( $( "<td></td>" ).html(i + 1) );
				$line.append( $( "<td></td>" ).html(product_name[i]) );
				$line.append( $( "<td></td>" ).html(price[i]) );
				$line.append( $( "<td></td>" ).html(quantity[i]) );
				$line.append( $( "<td></td>" ).html(sub_total[i]) );
				$table.append($line);
				//console.log($line);
			}
			$table.appendTo($("#tbl-produk-order"));
			is_prod_load = 1;
			$('#harga_jual').val('');
			$('#harga').val('');
			$('#jumlah').val(''); 
		});
		
		$('#proc-order').click(function(){		
			var validation = formVal();
			console.log(validation);
			if(validation == false){
				var val = $('#ord_name option:selected').val();
				var values = val.split('|');
				var sup_id = values[0];
				var tgl_order = $('input[name=ord_date_order]').val();
				var nama = $('#ord_name').val();
				var alamat = $('#ord_address').val();
				var kontak = $('#ord_contact').val();
				var ongkir = $('#ongkir').val()
				var discount = $('#discount').val()
				var total = $('#total').text()	
				
				var params = {
						sup_id,
						tgl_order,
						total,
						data_order
					};
				
				console.log(params);
				var url = '<?php echo site_url('pembelian/add_pembelian')?>';
				$.ajax({
					url: url,
					method:'post',
					data: params				
				}).success(function(result){
						console.log(result);
						result = JSON.parse(result);
						id_order.push(result);
					if(alert('Pembelian Sukses Dibuat')){
						//
					}else{
						window.location.reload(); 
					}
						
				});				
			}else{
				//var msg_param = '';
				var par_lenght = validation.length;
				console.log(par_lenght);
				for(i=0; i < par_lenght; i++){
					console.log(validation[i]);
					var msg_param = '<div class="alert alert-warning alert-dismissible">' +
					'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
					'<h4><i class="icon fa fa-check"></i> Cek Form!</h4>' + validation[i] +
					'</div>';
					console.log(msg_param);
					$('#msg').append(msg_param);
				}				
			}
		});
		
		$('#proc-print').click(function(){			
			// url = '<?php echo site_url('cashier/inv_print/7')?>';			
			url = '<?php echo site_url('cashier/inv_print')?>/'+id_order[0];
			window.location.replace(url);
		});
		
		$('input:radio[name=payment]').change(function(){
			if($('input:radio[name=payment][id=payment_lunas]').is(':checked') == true){
			 xxx = $('input:radio[name=payment][id=payment_lunas]').val();
			}
			if($('input:radio[name=payment][id=payment_dp]').is(':checked') == true){
				xxx = $('input:radio[name=payment][id=payment_dp]').val();
			}
			showHide(xxx);
		});
		
		
		
		
		
		//Date picker
		$('#datepicker').datepicker({			
		  autoclose: true
		});
		
		$('#ord_date_take').datepicker({
		  autoclose: true
		});
		$('#type').prop('disabled', true);
		
		$('#category').change(function(){
			$('#type').prop('disabled', false);
		});
		$('#type').change(function(){
			var category = $('#category option:selected').text();
			var type = $('#type option:selected').text();
			var produk = category + ' ' + type;
			//console.log(produk);
			$('#produk').val(produk);
			
		});

		function showHide(par){
			
			if(par == '1'){
				$('#tr_dp').addClass('hide');
				$('#tr_kurang').addClass('hide');
			}else if(par == '0'){
				$('#tr_dp').removeClass('hide');
				$('#tr_kurang').removeClass('hide');
			}
		}
		
		function formVal(){
			var msg = [];
			var payment_way = $('input:radio[name=payment_way]:checked' ).val();
			var payment = $('input:radio[name=payment]:checked' ).val();
			var dp = $('input[name=down_payment]' ).val();
			var bayar = $('input[name=cash]' ).val();
			var kurang = $('input[name=minus]' ).val();
			var kembali = $('input[name=cash_back]' ).val();
			//var no_nota = $('#no_nota').text();
			var tgl_order = $('input[name=ord_date_order]').val();
			var nama = $('#ord_name').val();
			var alamat = $('#ord_address').val();
			var kontak = $('#ord_contact').val();
			var email = $('#ord_email').val();
			if((payment == '0') && (dp == 0)){
				msg.push('Tidak bisa melakukan proses order tampa DP')
			}
			if(!nama){
				msg.push('Nama Supplier Tidak Boleh Kosong');
			}
			if(!alamat){
				msg.push('Alamat Supplier Tidak Boleh Kosong');
			}
			if(!kontak){
				msg.push('Kontak Supplier Tidak Boleh Kosong');
			}
			
			if(is_prod_load != 1){
				msg.push('Tidak Bisa Membuat Order Kosong');
			}
			
			return msg;		
		}
		
		
		
	});
	
	
	
	
	
</script>
<?php
$this->load->view('template/foot');
?>