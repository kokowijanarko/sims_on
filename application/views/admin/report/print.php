<html>
	<head>
		<style>
			table {
				border-collapse: collapse;
			}

			table, th, td {
				border: 1px solid black;
				padding: 2px;
			}
		</style>
	</head>
	
	<body>
		<h3>
			Daftar Penjualan
		</h3>
		<table>
			<thead>
				<tr>
					<th>No</th>
					<th>Nomor Invoice</th>
					<th>Atas Nama</th>				  
					<th>Alamat</th>		
					<th>tanggal</th>
					<th>ongkir</th>
					<th>diskon</th>					
					<th>Total</th>
					<th>User</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$no=1;
					$amount = array();
					foreach($invoice as $val){	
						echo'
							<tr>
								<td>'. $no .'</td>
								<td>'.$val->kode_invoice.'</td>
								<td>'. $val->nama_cust .'</td>
								<td>'. $val->alamat_cust .'</td>
								<td>'. $val->tgl_trans .'</td>
								<td>'. $val->biaya_kirim .'</td>
								<td>'. $val->diskon .'</td>
								<td>'. $val->total .'</td>
								<td>'. $val->nama_user .'</td>
							</tr>
						';
						
						$no++;
					}
					$omset = array_sum($amount);
					
				?>
			</tbody>
        </table>
	</body>
	<br />
	<br />
	<button OnClick="myFunction()">Cetak</button>
</html>

<script>
	function myFunction() {
		window.print();
	}
</script>