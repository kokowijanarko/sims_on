<?php
class kmeans{
	// $c pada fungsi hitung merupakan centroid awal
	//sedangkan $data merupakan data yang akan diproses, dalam bentuk array 3 dimensi
	// dengan ketentuan format array(array('jumlah' => <isi [integer atau float]>))
	public function hitung($data = array()){ //var utk declarasi fuction , data utk menampung hitungan dr data masuk
		
		$jarak_tiap_loop = array();
		$keanggotaan_tiap_cluster = array();	
		$centroid = array();
		
		
		if(!empty($data)){ //array dr data produk jml transaksi 
			// untuk langkah awal agar data terhitung tidak sama dg kosong
			$min_data_count = 0; //penghitungan data min d mulai dr 0
			foreach($data as $idx => $val){		// utk mengetahui jml data yg akand dhitung	
				$data_value[$val->product_id] = $val->jumlah; 
				if($val->jumlah > 0){
					$min_data_count++; // buat jml data yg di hitung
				}				
			}		
			
			if($min_data_count < 0){				// deklarasi misal data < 0 maka akan keluar pesan dibawah
				return array('msg'=>'Data kurang banyak (min25entry) !', 'data'=>''); // kenapa? karena terkadang data trlalu sedikit hasilnya tidak akurat 
			}else{
				// #1 penetapan nilai awal centroid
				$data_sum = array_sum($data_value); //menghitung jumlah produk terjual
				$data_count = count($data_value);	// jml data yg hitung brpa		
				$c_rendah = min($data_value); // nilai terendah dr data transak
				$c_tinggi = max($data_value);				
				$c_sedang = (min($data_value) + max($data_value)) / 2;  
				
				array_push($centroid, array('rendah' => $c_rendah, 'sedang' => $c_sedang, 'tinggi' => $c_tinggi)); //isi dr centroid awal, di masukkan kedalam variabel array , menambahkan centroid awal 
				
				// iterasi untuk menghitung centroid dan jarak data terhadap centroid pada tahap awal
				foreach($data_value as $idx => $val){ 
					$jarak[$idx] = $this->hitungJarakKeCentroid($val, $c_rendah, $c_sedang, $c_tinggi);	//			
				} 
				array_push($jarak_tiap_loop, $jarak);			
				
				// #2 mendapatkan $keanggotaan_tiap_cluster
				
				$keanggotaan = $this->distribusiKeanggotan($jarak);			
				array_push($keanggotaan_tiap_cluster, $keanggotaan);
				
				$centroid_baru = $this->centroidBaru($keanggotaan);
				array_push($centroid, $centroid_baru);
				
				foreach($data_value as $idx => $val){
					$jarak[$idx] = $this->hitungJarakKeCentroid($val, $centroid_baru['rendah'], $centroid_baru['sedang'], $centroid_baru['tinggi']);					
				}
				array_push($jarak_tiap_loop, $jarak);	
				
				$keanggotaan = $this->distribusiKeanggotan($jarak);		
				array_push($keanggotaan_tiap_cluster, $keanggotaan);
				
				//////BUAT LOOPING (LANGKAH 3-5) 
				while(1==1){ 
					$idx_last = count($keanggotaan_tiap_cluster) - 1; // karena indeks dimulai dr 0 (array terakhir)
					$idx_before = count($keanggotaan_tiap_cluster) - 2; //keanggotaan sebelumnya 
					//cek apakah tiap cluster ada anggotanya, jika ada yang kosong maka berhenti (selesai).
					if(empty($keanggotaan_tiap_cluster[$idx_last]['rendah']) || empty($keanggotaan_tiap_cluster[$idx_last]['sedang']) || empty($keanggotaan_tiap_cluster[$idx_last]['tinggi'])){
						break;
					}else{
						//cek apakah anggota tiap cluster sudah sama, jika sudah sama maka selsai. var yg d gunakan utk 
						$x = array_diff_key($keanggotaan_tiap_cluster[$idx_last]['rendah'], $keanggotaan_tiap_cluster[$idx_before]['rendah']);  // mencari nilai array yg berbeda
						$y = array_diff_key($keanggotaan_tiap_cluster[$idx_last]['sedang'], $keanggotaan_tiap_cluster[$idx_before]['sedang']);
						$z = array_diff_key($keanggotaan_tiap_cluster[$idx_last]['tinggi'], $keanggotaan_tiap_cluster[$idx_before]['tinggi']);
					//array (isi array yg buat perularngan itu sama ato tidak dg perulangan sebelumnya,, 
//jika tidak berubah maka berhenti
//jika ada nilai maka ke next perulangan

//perulangan langkah 3
						if(empty($x) && empty($y) && empty($z)){ //perulangan kapan iterasi perhitungan berhenti
							break;
						}else{
							$idx_jarak_last = count($jarak_tiap_loop) - 1; // jika tidak berubah
							$centroid_baru = $this->centroidBaru($keanggotaan_tiap_cluster[$idx_last], $jarak_tiap_loop[$idx_jarak_last]); //mencari prulangan centroid baru pemanggilan 
							array_push($centroid, $centroid_baru); 
							foreach($data_value as $idx => $val){
								$jarak[$idx] = $this->hitungJarakKeCentroid($val, $centroid_baru['rendah'], $centroid_baru['sedang'], $centroid_baru['tinggi']);					
							}
							array_push($jarak_tiap_loop, $jarak);
							$keanggotaan = $this->distribusiKeanggotan($jarak);		
							array_push($keanggotaan_tiap_cluster, $keanggotaan);
						}
					}
				}
				
				$idx_last = count($keanggotaan_tiap_cluster) - 1; //indeks last
				return array( //pemanggilan nilai balik
					'msg'=>'', 
					'data'=>$keanggotaan_tiap_cluster[$idx_last], 
					'data_detail' => array(
						'jarak' => $jarak_tiap_loop,
						'keanggotaan' => $keanggotaan_tiap_cluster,	
						'centroid' => $centroid
					)
				);
			}
		}else{
			var_dump('data kosong');
		}	
	}
	
	private function centroidBaru($anggota){ 
//setelah nilai anggota udh berubah, maka masuk kesini, centroid baru udh berubah rumus dr penghitungan awal
		foreach($anggota as $idx=>$val){
			$jumlah_anggota = count($val); //jumlah anggota didapat dr penghitungan banyaknya data yg masuk 
			$jumlah_jarak = array_sum($val); //jumlah jarak didapat dr penghitungan data array dr data yg masuk
			$centroid_baru = $jumlah_jarak/$jumlah_anggota; //rumus menentukan centroid baru
			
			if($idx == 'rendah'){ //jika indeks data centroid baru merupakan data rendah maka nilai tsb merupakan c baru rendah
				$centroid['rendah'] = $centroid_baru;
			}elseif($idx == 'sedang'){  
				$centroid['sedang'] = $centroid_baru;  //jika indeks data centroid baru merupakan data sedang maka nilai tsb merupakan c baru sedang
			}elseif($idx == 'tinggi'){
				$centroid['tinggi'] = $centroid_baru;  //jika indeks data centroid baru merupakan data tinggi maka nilai tsb merupakan c baru tinggi
			}
		}
		return $centroid;
	}
	
	// function dalam langkah k-2 ( utk menentukan jarak data per cluster)
	private function hitungJarakKeCentroid($data, $c1, $c2, $c3){  // fuction cara menghitung jarak 
		$jarak_c1 = sqrt(($data - $c1) * ($data - $c1)); // akar kuadrat dr data-c1 
		$jarak_c2 = sqrt(($data - $c2) * ($data - $c2));
		$jarak_c3 = sqrt(($data - $c3) * ($data - $c3));
		
		return array($jarak_c1, $jarak_c2, $jarak_c3);	
	}
	
	private function distribusiKeanggotan($jarak){ // untuk menentukan keanggotan tggi rendh sdg
		foreach($jarak as $idx=>$val){  // nilai jarak terendah
			foreach($val as $key=>$value){				 
				if($value == min($val)){
					if($key == 0){
						$keanggotaan['rendah'][$idx] = $value; //pendefinisian 
					}elseif($key == 1){
						$keanggotaan['sedang'][$idx] = $value;
					}elseif($key == 2){
						$keanggotaan['tinggi'][$idx] = $value;
					}
				}
			}				
		}
		return $keanggotaan;
	}
	
	
}
 // array push buat nampung data tiap x perulangan


?>