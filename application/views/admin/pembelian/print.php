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
				   <th>Tanggal</th>
				   <th>Supplier</th>
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
						echo '</tr>';
						$no++;
					}
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