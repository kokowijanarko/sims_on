<?php 
$this->load->view('template/head');
?>
<!--tambahkan custom css disini-->

<!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css">
<!-- bootstrap datepicker -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datepicker/datepicker3.css') ?>" rel="stylesheet" type="text/css" />

<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Detail Perhitungan Kmeans
        <small></small>
    </h1>
    
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Tahapan Perhitungan Kmeans</h3>    
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>						
				<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="box-body">
			<div>
				<p> 
					1. Menentukan data set dan jumlah cluster (centroid). Nilai centroid awal dalam hal ini adalah klasifikasi peminat produk tinggi, sedang dan rendah.
					Nilai centroid awal ditentukan dengan perhitungan sebagai berikut: <br>
					a. Centroid Tinggi = jumlah transaksi penjualan produk tertinggi.<br>
					b. Centroid Rendah = jumlah transaksi penjualan produk terrendah.<br>
					c. Centroid Sedang = (jumlah transaksi penjualan Tinggi + jumlah transaksi penjualan Rendah) : 2
				</p>
				<p> 
					2. Mengalokasikan data sesuai dengan jumlah cluster yang telah ditentukan dengan cara menghitung jarak 
					setiap data terhadap tiap-tiap centroid dengan rumus:<br>
					<img height="35px" src="<?php echo base_url('assets/formula_img/jarak_centroid.JPG')?>">					
					
				</p>
				<p> 
					3. Menghitung nilai centroid baru pada tiap-tiap cluster.<br>
					<img height="45px" src="<?php echo base_url('assets/formula_img/centroid_baru.JPG')?>">	dengan Ni adalah jumlah data pada anggota cluster ke-i, 
					X_kj adalah jarak data dengan centroid
					
					
				</p>
				<p> 
					4. Mengalokasikan masing-masing data ke-centroid terdekat dengan menghitung selisih jumlah total penjualan 
					tiap produk dengan nilai centroid tiap-tiap cluster. Jumlah yang paling kecil dialokasikan 
					pada anggota cluster tersebut.<br>
					
				</p>
				<p> 
					5. Mengulangi langkah 3 dan 4 hingga keanggottan masing-masing cluster tidak berubah.<br>
					
				</p>
			</div>
		</div>
	</div>
	
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Statistik Penjualan</h3>    
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>						
				<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="box-body">
			<div>
				<table id = "table_statistic" class="table">
				<thead>
					<tr>
						<th>No</th>
						<th>Produk</th>
						<th>Jumlah Transaksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no = 1;
						foreach($statistic as $idx=>$val){
							echo "
								<tr>
									<td>$no</td>
									<td>". $val->product_name ."</td>
									<td>". $val->jumlah ."</td>
								</tr>
							";
							$no++;
						}					
					?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
	
	
<?php
	$loop = 1;
	foreach($kmeans['centroid'] as $idx=>$cent){
		echo '
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Perhitungan Kmean Iterasi '. $loop .'</h3>    
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>						
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
		';
		
		echo '
			<div>
			<table>
				<tr>
					<th colspan="3">Centroid</th>
				</tr>
				<tr>
					<th>Tinggi</th>
					<td>:</td>
					<td>'. $cent['tinggi'] .'</td>
				</tr>
				<tr>
					<th>Sedang</th>
					<td>:</td>
					<td>'. $cent['sedang'] .'</td>
				</tr>
				<tr>
					<th>Rendah</th>
					<td>:</td>
					<td>'. $cent['rendah'] .'</td>
				</tr>
			</table>
			</div>
		';
		echo '
			<div>
			<table class="table">
			<thead>
				<tr>
					<th>NO</th>
					<th>Produk</th>
					<th>Jumlah</th>
					<th>Tinggi</th>
					<th>Rendah</th>
					<th>Sedang</th>
				</tr>
			</thead>
			<tbody>
		';
		$no = 1;
		foreach($kmeans['jarak'][$idx] as $key=>$space){
				echo '
					<tr>
					<td>'. $no .'</td>
					<td>'. $space['product_name'] .'</td>
					<td>'. $space['jumlah'] .'</td>
					<td>'. $space[1] .'</td>
					<td>'. $space[2] .'</td>
					<td>'. $space[0] .'</td>
				</tr>	
				';
			$no++;
		}
		echo '</tbody></table>';
		echo '</div></div></div>';
		$loop++;
	}
	

?>
	
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Hasil akhir Clustering</h3>    
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>						
				<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="box-body">
			<?php
				foreach($final_kmeans as $idx=>$val){
                    If($idx == 'sedang'){
						echo '<div><h4>TINGGI</h4>';
					}elseIf($idx == 'tinggi'){
						echo '<div><h4>RENDAH</h4>';						
					}elseIf($idx == 'rendah'){
						echo '<div><h4>SEDANG</h4>';		
					}
	
					echo'
						<table class="table">
							<thead>
								<tr>
									<th>NO</th>
									<th>Produk</th>
								</tr>
							</thead>
							<tbody>';
					$i=1;
					foreach($val as $key=>$value){
						echo '
							<tr>
								<td>'. $i .'</td>
								<td>'. $value->product_name .'</td>
							</tr>
						';
						$i++;
					}
					echo '</tbody></table></div>';
				}
				
			?>
	
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">PENGUJIAN</h3>    
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>						
				<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="box-body">
			<?php
				$last_centroid = $kmeans['centroid'][count($kmeans['centroid']) - 1];		//pemanggilan nilai centroid dr iterasi sebelumnya				
			?>
			
			<td>tinggi: </td>
			<input type='numerik' id="centroid_tinggi" value="<?php echo $last_centroid['tinggi']?>">
			<td>rendah : </td>
			<input type='numerik' id="centroid_rendah" value="<?php echo $last_centroid['rendah']?>">
			<td>sedang : </td>
			<input type='numerik' id="centroid_sedang" value="<?php echo $last_centroid['sedang']?>">
			
			<table>
				<tr>
					<td>Nama produk Baru</td>
					<td>:</td>
					<td><input type="text" id="prod_baru" placeholder="Produk Baru"/></td> <!--input type adl text, id dr textbox adl prod_baru-->
				</tr>
				<tr>
					<td>Jumlah Penjualan</td>
					<td>:</td>
					<td><input type="number" min="0" id="jml_penjualan" placeholder="Jumlah Terjual"/></td>
				</tr>
				<tr>
					
					<td>
						<button id="hitung" class="btn btn-default btn-sm">Hitung</button>
					</td>
					<td></td>
					<td></td>
				</tr>
			</table>	
			
			<table class="table" id="new_table">
				<thead>
				<tr>
					<th>produk</th> 
					<th>jumlah terjual</th>
					<th>Anggota Cluster Tinggi</th>
					<th>Anggota Cluster Rendah</th>
					<th>Anggota Cluster Sedang</th>
				</tr>
				<thead>
				<tbody id="hasil_hitung">
				</tbody>
			</table>
		</div>
	</div>	
		</div>
	</div>
		
</section><!-- /.content -->

<?php 
$this->load->view('template/js');
?>
<!--tambahkan custom js disini-->
<!-- DataTables -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datepicker/bootstrap-datepicker.js')?>"></script>

<!-- AutoNumeric -->
<script src="<?php echo base_url('assets/AutoNumeric/autoNumeric.js')?>" type="text/javascript"></script>

<script>

jQuery(function($) {
	  $('.table').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": true,
      "autoWidth": true
    });
	
	$('.auto').autoNumeric('init');
	
	$('#hitung').click(function(){
			
		var prod_baru = $('#prod_baru').val(); //var prod_baru = ambil value dr form yg mempunyai id prod_baru
		var jml_penjualan = $('#jml_penjualan').val(); //var jml_penjualan = ambil value dr form yg mempunyai id jml_penjualan
		
		var c_tinggi = $('#centroid_tinggi').val(); //var c_tinggi = ambil value dr form yg mempunyai id centroid_tinggi
		var c_sedang = $('#centroid_sedang').val(); //var c_sedang = ambil value dr form yg mempunyai id centroid_sedang
		var c_rendah = $('#centroid_rendah').val(); //var c_rendah = ambil value dr form yg mempunyai id centroid_rendah
		
		var tinggi = Math.sqrt((jml_penjualan - c_tinggi)*(jml_penjualan - c_tinggi)); //var tinggi = rumus matematika dr akar(jml_penjualan - c_tinggi)^
		var sedang = Math.sqrt((jml_penjualan - c_sedang)*(jml_penjualan - c_sedang)); //var sedang = rumus matematika dr akar(jml_penjualan - c_sedang)^
		var rendah = Math.sqrt((jml_penjualan - c_rendah)*(jml_penjualan - c_rendah)); //var sedang = rumus matematika dr akar(jml_penjualan - c_rendah)^
		
		console.log(tinggi);
		
		$('#hasil_hitung').empty();
		$('#hasil_hitung').append('<td>'+prod_baru+'</td><td>'+jml_penjualan+'</td><td>'+sedang+'</td><td>'+tinggi+'</td><td>'+rendah+'</td>');
	})
	
	
  });
</script>
<?php
$this->load->view('template/foot');
?>