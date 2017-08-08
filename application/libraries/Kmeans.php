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
				
			// foreach($data as $idx => $val){
				// $data_value[$val->product_id] = $val->jumlah;
			// }
			
			$data_value = array(
				'123'=>2,
				'124'=>3,
				'125'=>4,
				'126'=>7,
				'127'=>9,
				'128'=>2,
				'129'=>5,
				'130'=>4,
				'131'=>6,
				'132'=>4,			
				'132'=>9,			
				'132'=>10			
			);
			foreach($data_value as $key=>$val){
				$data_val[] = $val;
			}
			
			// #1 penetapan nilai awal centroid
			$data_sum = array_sum($data_val);
			$data_count = count($data_val);			
			$c_rendah = min($data_val);
			$c_tinggi = max($data_val);
			$c_sedang = $data_sum / $data_count;
			array_push($centroid, array($c_rendah, $c_sedang, $c_tinggi));
			
			//var_dump($centroid);
			
			// iterasi untuk menghitung centroid dan jarak data terhadap centroid pada tahap awal
			foreach($data_value as $idx => $val){
				$jarak[$idx] = $this->hitungJarakKeCentroid($val, $c_rendah, $c_sedang, $c_tinggi);					
			}
			array_push($jarak_tiap_loop, $jarak);	
			// #2 mendapatkan $keanggotaan_tiap_cluster
			
			$keanggotaan = $this->distribusiKeanggotan($jarak);			
			array_push($keanggotaan_tiap_cluster, $keanggotaan);
			
			$centroid_baru = $this->centroidBaru($keanggotaan);
			var_dump($centroid_baru);
			foreach($data_value as $idx => $val){
				$jarak[$idx] = $this->hitungJarakKeCentroid($val, $centroid_baru['rendah'], $centroid_baru['sedang'], $centroid_baru['tinggi']);					
			}
			array_push($jarak_tiap_loop, $jarak);
			$keanggotaan = $this->distribusiKeanggotan($jarak, 2);	
			array_push($keanggotaan_tiap_cluster, $keanggotaan);
			
			//----------
			
			$centroid_baru = $this->centroidBaru($keanggotaan);
			var_dump($centroid_baru);
			foreach($data_value as $idx => $val){
				$jarak[$idx] = $this->hitungJarakKeCentroid($val, $centroid_baru['rendah'], $centroid_baru['sedang'], $centroid_baru['tinggi']);					
			}
			array_push($jarak_tiap_loop, $jarak);
			$keanggotaan = $this->distribusiKeanggotan($jarak, 3);	
			array_push($keanggotaan_tiap_cluster, $keanggotaan);
			
			
			
			
			// var_dump(count($keanggotaan_tiap_cluster), $jarak);
			
			//////BUAT LOOPING (LANGKAH 3-5)
			
			// while(1==1){
				// $idx = count($keanggotaan_tiap_cluster)-1;
				// $idx_low = count($keanggotaan_tiap_cluster) - 2;
				
				// $x = array_diff_key($keanggotaan_tiap_cluster[$idx]['rendah'], $keanggotaan_tiap_cluster[$idx_low]['rendah']);
				// $y = array_diff_key($keanggotaan_tiap_cluster[$idx]['sedang'], $keanggotaan_tiap_cluster[$idx_low]['sedang']);
				// $z = array_diff_key($keanggotaan_tiap_cluster[$idx]['tinggi'], $keanggotaan_tiap_cluster[$idx_low]['tinggi']);
				
				// if(empty($x) && empty($y) && empty($z)){
					// break;					
				// }else{
					// $centroid_baru = $this->centroidBaru($keanggotaan_tiap_cluster[$idx]);
					// foreach($data_value as $idx => $val){
						// $jarak[$idx] = $this->hitungJarakKeCentroid($val, $centroid_baru['rendah'], $centroid_baru['sedang'], $centroid_baru['tinggi']);					
					// }
					// $keanggotaan = $this->distribusiKeanggotan($jarak);
					
					// array_push($keanggotaan_tiap_cluster, $keanggotaan);
					
				// }
				
			// }
			var_dump($keanggotaan_tiap_cluster);			
		}else{
			var_dump('data kosong');
		}
		
	}
	
	private function centroidBaru($anggota){
		// var_dump($anggota);
		foreach($anggota as $idx=>$val){
			$jumlah_anggota = count($val);
			$jumlah_jarak = array_sum($val);
			if($jumlah_jarak == 0){
				$centroid_baru = 0;
			}else{
				$centroid_baru = $jumlah_jarak/$jumlah_anggota ;
			}
			// var_dump($jumlah_anggota, $jumlah_jarak);
			// var_dump($centroid_baru);
			// var_dump('-----');
			if($idx == 'rendah'){
				$centroid['rendah'] = $centroid_baru;
			}elseif($idx == 'sedang'){
				$centroid['sedang'] = $centroid_baru;
			}elseif($idx == 'tinggi'){
				$centroid['tinggi'] = $centroid_baru;
			}
		}
		// var_dump($centroid);
		return $centroid;
	}
	
	
	private function hitungJarakKeCentroid($data, $c1, $c2, $c3){
		$jarak_c1 = sqrt(($data - $c1)^2);
		$jarak_c2 = sqrt(($data - $c2)^2);
		$jarak_c3 = sqrt(($data - $c3)^2);
		
		//1 = rendah, 2 = sedang, 3 = tinggi
		//hanya sebagai penanda
		// var_dump($jarak_c1, $jarak_c2, $jarak_c3);
		return array($jarak_c1, $jarak_c2, $jarak_c3);	
	}
	
	private function distribusiKeanggotan($jarak, $loop=null){
		foreach($jarak as $idx=>$val){	
			foreach($val as $key=>$value){
				/* if($loop == 2){
				var_dump('===', $idx, $key, min($val), $val, '===');					
				} */
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