<?php 
$this->load->view('template/head');
?>
<!--tambahkan custom css disini-->

<!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css">
<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Job Order / Invoice
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
            <h3 class="box-title">Form Laporan Harian</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
			<div>
				<?php
					if(!empty($msg)){
						echo $msg;
					}
				?>
			</div>
			<table id="tbl-invoice" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nomor Invoice</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Tanggal Order</th>
                  <th>Tanggal Pengambilan</th>
                  <th>Total</th>
                  <th>Kurang</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
					<?php
						$no=1;
						foreach($invoice as $value){
							$hide='';
							$disabled = 'disabled';
							$disabled_stat = '';
							$url_stat = base_url('index.php/cashier/orderDone/'.$value->order_id);
							if($value->order_cash_minus > 0){
								$hide='hide';
								$disabled = '';
							}
							if($value->order_status == 1){
								$disabled_stat = 'disabled';
								$url_stat='#';
							}
							echo '<input type="hidden" id="list_order_id" value="'.$value->order_id.'">';
							echo '<tr>';
							echo '<td>'.$no.'</td>';
							echo '<td><button  type="button" class="invoice_detail btn btn-sm btn-info '.$disabled.'">'.$value->order_code.'</button></td>';
							echo '<td>'.$value->order_custommer_name.'</td>';
							echo '<td>'.$value->order_address.'</td>';
							echo '<td>'.$value->order_date_order.'</td>';
							echo '<td>'.$value->order_date_take.'</td>';
							echo '<td class="auto">'.$value->order_amount.'</td>';
							echo '<td class="auto" id="cash_minus">'.$value->order_cash_minus.'</td>';
							echo '<td>
								<div class="btn-group">
									<a class="hide" id="order_edit" href="'.base_url('index.php/invoice/edit/'.$value->order_id).'">
										<button type="button" class="btn btn-info btn-flat">Edit</button>
									</a>
									<a class="'.$hide.'" id="order_done" href="'.$url_stat.'">
										<button type="button" class="btn btn-success btn-flat '.$disabled_stat.'">Selesai</button>
									</a>								
								</div>
							
							</td>';
							echo '</tr>';
							$no++;
						}
					?>
                </tbody>
              </table>
            
        </div><!-- /.box-body -->
        <div class="box-footer">
            
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
	
	<div id="box_pelunasan" class="box hide">
        <div class="box-header with-border">
            <h3 class="box-title">Pelunasan Order</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool hide" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
			<div class="row">
				
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
								<td id="ord_date_take"></div>
								</td>
							</tr>
							<tr>
								<td>Tanggal Lihat Desain</td>
								<td>:</td>
								<td id="ord_date_design"></div>
								</td>
							</tr>										
						</table>
					</div>	
					<div class="col-md-6 pull-right">
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
									<td colspan="5">TOTAL</td>
									<td class="auto" id="total"></td>
								</tr>
								<tr>
									<td colspan="2">Cara Pembayaran</td>	
									<td id="cara_pembayaran" colspan="4"> </td>	
								</tr>								
								<tr id="tr_dp">
									<td colspan="5">DP</td>
									<td ><input class="auto" readonly type="number" min="0" value="0" name="down_payment" id="down_payment"></td>
								</tr>
								<tr id="tr_kurang">
									<td colspan="5">Kurang</td>
									<td ><input class="auto" readonly type="number" min="0" value="0" name="minus" id="minus"></td>
								</tr>
								<tr>
									<td colspan="5">Bayar</td>
									<td ><input class="auto" type="number" min="0" value="0" name="cash" id="cash"></td>
								</tr>
								<tr>
									<td colspan="5">Kembali</td>
									<td ><input class="auto" readonly type="number" min="0" value="0" name="cash_back" id="cash_back"></td>
								</tr>
							</tfoot>
						</table>		
						<input type="hidden" id="order_id">
					</div>
					<div class="col-md-4 pull-left">						
						<button id="proc-order" type="submit" class="btn btn-success">Proses</button>
						<button id="proc-print" type="submit" class="btn btn-warning hide">Cetak</button>
					</div>
						
			</div><!-- /.box-body -->
        <div class="box-footer">
          </div>
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
	


</section><!-- /.content -->

<?php 
$this->load->view('template/js');
?>
<!--tambahkan custom js disini-->
<!-- DataTables -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<!-- AutoNumeric -->
<script src="<?php echo base_url('assets/AutoNumeric/autoNumeric.js')?>" type="text/javascript"></script>

<script>
  jQuery(function($) {
	$('#cash').change(function(){
		var kurang = $('#minus').val();
		var bayar = $('#cash').val();
		var kembali = bayar - kurang;
		$('#cash_back').val(kembali);
		//console.log(kembali);
	});
	$('#proc-order').click(function(){
		var invo_number = $('#no_nota').text();
		var kembali = $('#cash_back').val();
		console.log(invo_number);
		if(kembali >= 0){
			$.ajax({
				url:"<?php echo site_url('cashier/doAcQuittal')?>",
				method:'post',
				data:{'invo_number':invo_number}
			}).success(function(result){
				result = JSON.parse(result);
				
				if(result){
					alert('Pelunasan Berhasil');
					$('#cash_minus').empty();
					$('#cash_minus').append('0');
					$('#box_pelunasan').addClass('hide');
					$('#order_done').removeClass('hide');
					$('.invoice_detail').addClass('disabled');
				}
			});
		}else{
			alert('Pembayaran Tidak Cukup Untuk Pelunasan!');
		}
	});
	
	$('.invoice_detail').click(function(){
		$('#box_pelunasan').removeClass('hide');
		var invoice_number = $(this).text();
		console.log(invoice_number);
		$.ajax({
			data:{'invo_number':invoice_number},
			method:'post',
			url:'<?php echo site_url('cashier/get_detail_invoice')?>'
		}).success(function(result){
			result = JSON.parse(result);
			console.log(result);
			
			var payment_way = $('#cara_pembayaran').text(result['order']['order_payment_way']);
			var dp = $('#down_payment' ).val(result['order']['order_down_payment']);
			var bayar = $('#cash' ).text();
			var kurang = $('#minus' ).val(result['order']['order_cash_minus']);
			var kembali = $('#cash_back' ).text();
			var no_nota = $('#no_nota').text(result['order']['order_code']);
			var tgl_order = $('#ord_date_order').text(result['order']['order_date_order']);
			var tgl_pengambilan = $('#ord_date_take').text(result['order']['order_date_take']);
			var tgl_lihat_design = $('#ord_date_design').text(result['order']['order_date_design']);
			var nama = $('#ord_name').text(result['order']['order_custommer_name']);
			var alamat = $('#ord_address').text(result['order']['order_address']);
			var kontak = $('#ord_contact').text(result['order']['order_contact']);
			var email = $('#ord_email').text(result['order']['order_email']);			
			var email = $('#total').text(result['order']['order_amount']);			
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
	});
		
    $('#tbl-invoice').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
	
	$('.auto').autoNumeric('init');
  });
</script>
<?php
$this->load->view('template/foot');
?>