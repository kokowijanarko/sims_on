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
					<th>ongkir (Rp)</th>
					<th>diskon (Rp)</th>					
					<th>Total (Rp)</th>
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
								<td>'. date('d-m-Y', strtotime($val->tgl_trans)) .'</td>
								<td align="right">'. number_format($val->biaya_kirim, 0, ',', '.') .'</td>
								<td align="right">'. number_format($val->diskon, 0, ',', '.') .'</td>
								<td align="right">'. number_format($val->total, 0, ',', '.') .'</td>
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