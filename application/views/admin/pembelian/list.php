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
        Pembelian
        <small>Data</small>
    </h1>
    
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Pembelian</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
			<div class="col-md-12">
				<?php echo isset($message)?$message:NULL?>
			</div>
			<div>
				<a href="<?php echo site_url('pembelian/list_print')?>" target="_blank"><button class="btn btn-sm btn-primary">Cetak Laporan</button></a>
			</div>
			<br />
			<table id="tbl-inventory" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Supplier</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
					<?php
						$no=1;
						foreach($list as $value){
							echo '<tr>';
							echo '<td>'.$no.'</td>';
							echo '<td>'.date('d-m-Y', strtotime($value->tgl_beli)) .'</td>';
							echo '<td>'.$value->nama_sup.'</td>';
							echo '<td><button class="btn btn-success detail" id="'. $value->id_beli .'">Detail</button></td>';
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

	<div id = "box_detail" class="box hide" >
        <div class="box-header with-border">
            <h3 class="box-title">Detail Pembelian</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
			<div class="col-md-4">
				<table class="table table-hover hide">
					<tr>
						<td>Supplier</td>
						<td>:</td>
						<td id="sup"></td>
					</tr>
					<tr>
						<td>Tgl Beli</td>
						<td>:</td>
						<td id="tgl_beli"></td>
					</tr>
				</table>
			</div>
			<table id="tbl_detail_pembelian" class="table table-bordered table-hover">
               <thead>
					<tr>
					  <th>No</th>
					  <th>Produk</th>
					  <th>jumlah</th>
					  <th>Harga</th>
					  <th>Total</th>
					</tr>
                </thead>
				<tbody>
					
				</tbody>
            </table>
            
        </div><!-- /.box-body -->
        <div class="box-footer">
           
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
	$('#tbl-inventory').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
	
	$('.auto').autoNumeric('init');
	
	$('.detail').click(function(){
		$('#box_detail').removeClass('hide');
		var id = $(this).attr('id');
		$.ajax({
			data:{'id':id},
			method:'post',
			url:'<?php echo site_url('pembelian/get_detail_pembelian/')?>/' + id
		}).success(function(result){
			result = JSON.parse(result);
			console.log(result);
			
			$( "tbody#detail_tbody" ).empty();
			$table = $( "<tbody id=detail_tbody></tbody>" );
			
			for(i=0; i < result.length; i++){
				var sub_total = result[i]['jml_brg'] * result[i]['harga_beli'];
				var $line = $( "<tr></tr>" );
				$line.append( $( "<td></td>" ).html(i + 1) );
				$line.append( $( "<td></td>" ).html(result[i]['nama_prod']) );
				$line.append( $( "<td class='auto'></td>" ).html(result[i]['jml_brg']));
				$line.append( $( "<td></td>" ).html(result[i]['harga_beli']));
				$line.append( $( "<td class='auto'></td>" ).html(sub_total));
				$table.append($line);
				//console.log($line);
			}
			$table.appendTo($("#tbl_detail_pembelian"));
		})
		
	})
	
	
	
  });
</script>
<?php
$this->load->view('template/foot');
?>