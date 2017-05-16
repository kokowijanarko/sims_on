<?php 
$this->load->view('template/head');
?>
<!--tambahkan custom css disini-->
<!-- Select2 -->
<link rel="stylesheet" href="../../plugins/select2/select2.min.css">
<!-- bootstrap datepicker -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datepicker/datepicker3.css') ?>" rel="stylesheet" type="text/css" />


<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Order
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
            <h3 class="box-title">Buat Order</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
			<div class="row">
				<div class="col-md-4">
						<div class="form-group">
							<label>Produk</label>
							<select id="produk" name="produk" class="form-control select2" style="width: 100%;">
								<option value=''>--Pilih--</option>
								<?php
									foreach($produk as $val){
										echo '<option value="'.$val->inv_id.'|'.$val->inv_price.'">'.$val->inv_name .'</option>';
									}
								?>								
							</select>
						</div>						
						<div class="form-group">
							<label>Harga</label>
							<div class="input-group">
								<span class="input-group-addon">Rp</span>
								<input id="harga"  readonly type="text" name="harga" pattern="[1-9].{4,}" class="form-control">
								<span class="input-group-addon">.00</span>
							</div>
						</div>
						
						<div class="form-group">
							<label>Jumlah</label>
							<div class="input-group">
								<span class="input-group-addon">@</span>
								<input id="jumlah"  type="jumlah" name="jumlah" pattern="[1-9].{1,}" class="form-control">
								<span class="input-group-addon">Biji</span>
							</div>
						</div>
						
						<div class="form-group">
							<label>Catatan</label>
							<textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" placeholder="Enter ..."></textarea>
						</div>
						
						<div class="box-footer">
							<button id="smt-order" type="submit" class="btn btn-info">Tambah</button>
						</div>
					
				</div>
				<div class="col-md-8">
					<div class="col-md-6">
						<table class="table">
							<tr>
								<td>No. Nota</td>
								<td>:</td>
								<td id="no_nota"><?php echo $order_code?></td>
							</tr>
							<tr>
								<td>Tanggal Order</td>
								<td>:</td>
								<td>
									<div class="input-group date">
										<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
										</div>
										<input type="text" name="ord_date_order" readonly value="<?php echo date('d-m-Y')?>" class="form-control" id="ord_date_order">
									</div>
								</td>
							</tr>
							<tr>
								<td>Tanggal Pengambilan</td>
								<td>:</td>
								<td>
									<div class="input-group date">
										<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
										</div>
										<input type="text" name="ord_date_take" data-date-format="dd-mm-yyyy" class="form-control" id="ord_date_take">
									</div>
								</td>
							</tr>
							<tr>
								<td>Tanggal Lihat Desain</td>
								<td>:</td>
								<td>
									<div class="input-group date">
										<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
										</div>
										<input type="text" name="ord_date_design" data-date-format="dd-mm-yyyy" class="form-control" id="datepicker">
									</div>
								</td>
							</tr>										
						</table>
					</div>	
					<div class="col-md-6 pull-right">
						<table class="table">
							<tr>
								<td>Nama</td>
								<td>:</td>
								<td><input id="ord_name" type="text" name="ord_name" ></td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td>:</td>
								<td><textarea id="ord_address" name="ord_address"></textarea></td>
							</tr>			
							<tr>
								<td>No. Kontak</td>
								<td>:</td>
								<td><input id="ord_contact" type="text" name="ord_contact" ></td>
							</tr>
							<tr>
								<td>Email</td>
								<td>:</td>
								<td><input id="ord_email" type="text" name="ord_email" ></td>
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
									<td colspan="5">TOTAL</td>
									<td id="total"></td>
								</tr>
								<tr>
									<td colspan="2">Pembayaran</td>	
									<td colspan="4">
										<div>
											<input type="radio" name="payment" id="payment_dp" value="0"><label for="payment_dp">DP</label>
											&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
											<input type="radio" name="payment" id="payment_lunas" value="1"><label for="payment_lunas">Lunas</label>
										</div>
									</td>	
								</tr>
								<tr>
									<td colspan="2">Cara Pembayaran</td>	
									<td colspan="4">
										<div>
											<input type="radio" name="payment_way" id="payment_cash" value="0" ><label for="payment_cash">Cash</label>
											&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
											<input type="radio" name="payment_way" id="payment_transfer" value="1"><label for="payment_transfer">Transfer</label>
											&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
											<input type="radio" name="payment_way" id="payment_debit" value="3"><label for="payment_debit">Debit</label>
										</div>
									</td>	
								</tr>								
								<tr id="tr_dp">
									<td colspan="5">DP</td>
									<td><input type="number" min="0" value="0" name="down_payment" id="down_payment"></td>
								</tr>
								<tr id="tr_kurang">
									<td colspan="5">Kurang</td>
									<td ><input readonly type="number" min="0" value="0" name="minus" id="minus"></td>
								</tr>
								<tr>
									<td colspan="5">Bayar</td>
									<td ><input type="number" min="0" value="0" name="cash" id="cash"></td>
								</tr>
								<tr>
									<td colspan="5">Kembali</td>
									<td ><input readonly type="number" min="0" value="0" name="cash_back" id="cash_back"></td>
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
						<label> Rere
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


<script>	

	jQuery(function($) {
	
		
		$('input:radio[name=payment][id=payment_lunas]').prop('checked', true);
		$('input:radio[name=payment_way][id=payment_cash]').prop('checked', true);
		
		if($('input:radio[name=payment][id=payment_lunas]').is(':checked') == true){
			var xxx = $('input:radio[name=payment][id=payment_lunas]').val();			
		}
		if($('input:radio[name=payment][id=payment_dp]').is(':checked') == true){
			xxx = $('input:radio[name=payment][id=payment_dp]').val();
		}	
		showHide(xxx);
		var product_name = [];
		var product_id = [];
		var price = [];
		var quantity = [];
		var sub_total = [];
		var desc = [];
		var data_order = {product_name, product_id, price, quantity, sub_total, desc};
		var id_order = [];
		
		$('#smt-order').click(function(){
			var prod_val = $('#produk').val();
			var prod_name = $('#produk option:selected').text();
			var prod = prod_val.split('|');			
			var prod_price = prod[1];
			var prod_id = prod[0];
			var prod_quantity = $('#jumlah').val(); 
			var prod_desc = $('#deskripsi').val(); 
			var prod_sub_total = prod_price * prod_quantity;
						
			if(prod_id != ""){
				product_id.push(prod_id);
				product_name.push(prod_name);
				price.push(prod_price);
				quantity.push(prod_quantity);
				sub_total.push(prod_sub_total);
				desc.push(prod_desc);
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
				$line.append( $( "<td></td>" ).html(desc[i]) );
				$line.append( $( "<td></td>" ).html(sub_total[i]) );
				$table.append($line);
				console.log($line);
			}
			$table.appendTo($("#tbl-produk-order"));
		});
		
		$('#proc-order').click(function(){			
			var payment_way = $('input:radio[name=payment_way]:checked' ).val();
			var payment = $('input:radio[name=payment]:checked' ).val();
			var dp = $('input[name=down_payment]' ).val();
			var bayar = $('input[name=cash]' ).val();
			var kurang = $('input[name=minus]' ).val();
			var kembali = $('input[name=cash_back]' ).val();
			var no_nota = $('#no_nota').text();
			var tgl_order = $('input[name=ord_date_order]').val();
			var tgl_pengambilan = $('input[name=ord_date_take]').val();
			var tgl_lihat_design = $('input[name=ord_date_design]').val();
			var nama = $('#ord_name').val();
			var alamat = $('#ord_address').val();
			var kontak = $('#ord_contact').val();
			var email = $('#ord_email').val();
			
			
			var total = 0;
			for (var i = 0; i < sub_total.length; i++) {
				total += sub_total[i] << 0;
			}
			
			var params = {
					data_order, 
					payment_way, 
					payment, 
					dp, bayar, 
					kurang, 
					kembali, 
					total,
					no_nota,
					tgl_lihat_design,
					tgl_order,
					tgl_pengambilan,
					nama,
					alamat,
					kontak,
					email
				};
			
			console.log(params);
			// $('#proc-order').addClass('hide');
			// $('#proc-print').removeClass('hide');
			var url = '<?php echo site_url('cashier/add_order')?>';
			$.ajax({
				url: url,
				method:'post',
				data: params				
			}).success(function(result){		
					result = JSON.parse(result);
					id_order.push(result);
					alert('Order Sukses Dibuat');
					$('#proc-order').addClass('hide');
					$('#proc-print').removeClass('hide');
			});
			
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
		
		
		
		$('#down_payment').change(function(){
			var total = parseInt($('#total').text());
			var dp = $('#down_payment').val();
			var minus = total - dp;
			$('#minus').val(minus);
			
		});
		
		$('#cash').change(function(){
			var total = parseInt($('#total').text());
			var bayar = $('#cash').val();
			var dp = $('#down_payment').val();			
			
			if(xxx == '0'){
				var minus = total - dp;
				var kembali = bayar - dp;
				$('#minus').val(minus);
				$('#cash_back').val(kembali);
			}else if(xxx == '1'){
				$('#down_payment').val('0');
				$('#minus').val('0');
				var kembali = bayar - total;
				$('#cash_back').val(kembali);
			}
			
			console.log(kembali);
			
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

		$('#produk').change(function(){
			var prod_val = $('#produk').val();
			var prod = prod_val.split('|');			
			var prod_price = prod[1];
			
			$('#harga').val(prod_price);
			$('#jumlah').val('1');
			//console.log(prod);
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
		
	});
	
	
	
	
	
</script>
<?php
$this->load->view('template/foot');
?>