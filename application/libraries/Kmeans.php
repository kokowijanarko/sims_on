<?php
class kmeans{
	// $c pada fungsi hitung merupakan centroid awal
	//sedangkan $data merupakan data yang akan diproses, dalam bentuk array 3 dimensi
	// dengan ketentuan format array(array('jumlah' => <isi [integer atau float]>))
	public function hitung($data = array()){
		
		$jarak_tiap_loop = array();
		$keanggotaan_tiap_cluster = array();	
		$centroid = array();
		
		
		if(!empty($data)){
			
			foreach($data as $idx => $val){
				$data_value[$val->product_id] = $val->jumlah;
			}
			
			// #1 penetapan nilai awal centroid
			$data_sum = array_sum($data_value);
			$data_count = count($data_value);			
			$c_rendah = min($data_value);
			$c_tinggi = max($data_value);
			$c_sedang = ($c_tinggi + $c_rendah) / 2;		
			array_push($centroid, array($c_rendah, $c_sedang, $c_tinggi));
			
			
			// iterasi untuk menghitung centroid dan jarak data terhadap centroid pada tahap awal
			foreach($data_value as $idx => $val){
				$jarak[$idx] = $this->hitungJarakKeCentroid($val, $c_rendah, $c_sedang, $c_tinggi);					
			}
			array_push($jarak_tiap_loop, $jarak);			
			
			// #2 mendapatkan $keanggotaan_tiap_cluster
			
			$keanggotaan = $this->distribusiKeanggotan($jarak);			
			array_push($keanggotaan_tiap_cluster, $keanggotaan);
			
			$centroid_baru = $this->centroidBaru($keanggotaan, $jarak);
			
			
			foreach($data_value as $idx => $val){
				$jarak[$idx] = $this->hitungJarakKeCentroid($val, $centroid_baru['rendah'], $centroid_baru['sedang'], $centroid_baru['tinggi']);					
			}
			
			array_push($jarak_tiap_loop, $jarak);	
			
			$keanggotaan = $this->distribusiKeanggotan($jarak);		
			array_push($keanggotaan_tiap_cluster, $keanggotaan);
			
			var_dump($keanggotaan_tiap_cluster);
			
			//////BUAT LOOPING (LANGKAH 3-5)
			
			
		}else{
			var_dump('data kosong');
		}
		
	}
	
	private function centroidBaru($anggota, $jarak){
		foreach($anggota as $idx=>$val){
			$jumlah_anggota = count($val);
			$jumlah_jarak = array_sum($val);
			$centroid_baru = $jumlah_anggota/$jumlah_jarak;
			// var_dump($centroid_baru);
			
			if($idx == 'rendah'){
				$centroid['rendah'] = $centroid_baru;
			}elseif($idx == 'sedang'){
				$centroid['sedang'] = $centroid_baru;
			}elseif($idx == 'tinggi'){
				$centroid['tinggi'] = $centroid_baru;
			}
		}
		return $centroid;
	}
	
	
	private function hitungJarakKeCentroid($data, $c1, $c2, $c3){
		$jarak_c1 = sqrt(($data - $c1) * ($data - $c1));
		$jarak_c2 = sqrt(($data - $c2) * ($data - $c2));
		$jarak_c3 = sqrt(($data - $c3) * ($data - $c3));
		
		//1 = rendah, 2 = sedang, 3 = tinggi
		//hanya sebagai penanda
		// var_dump($jarak_c1, $jarak_c2, $jarak_c3);
		return array($jarak_c1, $jarak_c2, $jarak_c3);	
	}
	
	private function distribusiKeanggotan($jarak){
		foreach($jarak as $idx=>$val){				
			foreach($val as $key=>$value){
				if($value == min($val)){
					if($key == 0){
						$keanggotaan['rendah'][$idx] = $value;
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



?>