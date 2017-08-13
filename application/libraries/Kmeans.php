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
			
			// $data_value = array(
				// '1'=>	16,
				// '2'=>	5,
				// '3'=>	4,
				// '4'=>	17,
				// '5'=>	24,
				// '6'=>	32,
				// '7'=>	7,
				// '8'=>	12,
				// '9'=>	6,
				// '10'=>	3,
				// '11'=>	11,
				// '12'=>	14,
				// '13'=>	16,
				// '14'=>	3,
				// '15'=>	16,
				// '16'=>	4,
				// '17'=>	3,
				// '18'=>	9,
				// '19'=>	14,
				// '20'=>	5,
				// '21'=>	9,
				// '22'=>	5,
				// '23'=>	13,
				// '24'=>	7,
				// '25'=>	22,
				// '26'=>	10,
				// '27'=>	1,
				// '28'=>	7,
				// '29'=>	6,
				// '30'=>	6,
				// '31'=>	23,
				// '32'=>	12,
				// '33'=>	1,
				// '34'=>	1,
				// '35'=>	13,
				// '36'=>	18,
				// '37'=>	40,
				// '38'=>	3,
				// '39'=>	57,
				// '40'=>	30,
				// '41'=>	110,
				// '42'=>	8,
				// '43'=>	2,
				// '44'=>	6,
				// '45'=>	81,
				// '46'=>	4,
				// '47'=>	1,
				// '48'=>	24,
				// '49'=>	3,
				// '50'=>	20,
				// '51'=>	18,
				// '52'=>	91,
				// '53'=>	30,
				// '54'=>	27,
				// '55'=>	1,
				// '56'=>	6,
				// '57'=>	3,
				// '58'=>	1,
				// '59'=>	5,
				// '60'=>	42,
				// '61'=>	17,
				// '62'=>	50,
				// '63'=>	33,
				// '64'=>	7,
				// '65'=>	12,
				// '66'=>	134,
				// '67'=>	1,
				// '68'=>	20,
				// '69'=>	2,
				// '70'=>	38,
				// '71'=>	3,
				// '72'=>	33,
				// '73'=>	2,
				// '74'=>	1,
				// '75'=>	14,
				// '76'=>	4,
				// '77'=>	2,
				// '78'=>	22
			// );		
			
			// #1 penetapan nilai awal centroid
			$data_sum = array_sum($data_value);
			$data_count = count($data_value);			
			$c_rendah = min($data_value);
			$c_tinggi = max($data_value);
			
			$c_sedang = (min($data_value) + max($data_value)) / 2;
			
			// $c_rendah = ($c_sedang + $min) / 2 ;
			// $c_tinggi = ($c_sedang + $max) / 2;
			
			array_push($centroid, array($c_rendah, $c_sedang, $c_tinggi));
		//var_dump($centroid);die;
			
			// iterasi untuk menghitung centroid dan jarak data terhadap centroid pada tahap awal
			foreach($data_value as $idx => $val){
				$jarak[$idx] = $this->hitungJarakKeCentroid($val, $c_rendah, $c_sedang, $c_tinggi);					
			}
			array_push($jarak_tiap_loop, $jarak);			
			
			// #2 mendapatkan $keanggotaan_tiap_cluster
			
			$keanggotaan = $this->distribusiKeanggotan($jarak);			
			array_push($keanggotaan_tiap_cluster, $keanggotaan);
			
			$centroid_baru = $this->centroidBaru($keanggotaan);
			// var_dump($centroid_baru);
			
			foreach($data_value as $idx => $val){
				$jarak[$idx] = $this->hitungJarakKeCentroid($val, $centroid_baru['rendah'], $centroid_baru['sedang'], $centroid_baru['tinggi']);					
			}
			//var_dump($jarak);
			array_push($jarak_tiap_loop, $jarak);	
			
			$keanggotaan = $this->distribusiKeanggotan($jarak);		
			array_push($keanggotaan_tiap_cluster, $keanggotaan);
			
			// var_dump($jarak, $keanggotaan_tiap_cluster);
			// die;
			
			//////BUAT LOOPING (LANGKAH 3-5)
			while(1==1){
				$idx_last = count($keanggotaan_tiap_cluster) - 1;
				$idx_before = count($keanggotaan_tiap_cluster) - 2;
				//cek apakah tiap cluster ada anggotanya, jika ada yang kosong maka berhenti (selesai).
				if(empty($keanggotaan_tiap_cluster[$idx_last]['rendah']) || empty($keanggotaan_tiap_cluster[$idx_last]['rendah']) || empty($keanggotaan_tiap_cluster[$idx_last]['rendah'])){
					break;
				}else{
					//cek apakah anggota tiap cluster sudah sama, jika sudah sama maka selsai.
					$x = array_diff_key($keanggotaan_tiap_cluster[$idx_last]['rendah'], $keanggotaan_tiap_cluster[$idx_before]['rendah']);
					$y = array_diff_key($keanggotaan_tiap_cluster[$idx_last]['sedang'], $keanggotaan_tiap_cluster[$idx_before]['sedang']);
					$z = array_diff_key($keanggotaan_tiap_cluster[$idx_last]['tinggi'], $keanggotaan_tiap_cluster[$idx_before]['tinggi']);
				
					if(empty($x) && empty($y) && empty($z)){
						break;
					}else{
						$idx_jarak_last = count($jarak_tiap_loop) - 1;
						$centroid_baru = $this->centroidBaru($keanggotaan_tiap_cluster[$idx_last], $jarak_tiap_loop[$idx_jarak_last]);
						foreach($data_value as $idx => $val){
							$jarak[$idx] = $this->hitungJarakKeCentroid($val, $centroid_baru['rendah'], $centroid_baru['sedang'], $centroid_baru['tinggi']);					
						}
						array_push($jarak_tiap_loop, $jarak);
						$keanggotaan = $this->distribusiKeanggotan($jarak);		
						array_push($keanggotaan_tiap_cluster, $keanggotaan);
					}
				}
			}
			
			//var_dump($keanggotaan_tiap_cluster);
			$idx_last = count($keanggotaan_tiap_cluster) - 1;
			return $keanggotaan_tiap_cluster[$idx_last];
		}else{
			var_dump('data kosong');
		}	
	}
	
	private function centroidBaru($anggota){
		
		foreach($anggota as $idx=>$val){
			$jumlah_anggota = count($val);
			$jumlah_jarak = array_sum($val);
			$centroid_baru = $jumlah_jarak/$jumlah_anggota;
			// var_dump($jumlah_anggota, $jumlah_jarak, $centroid_baru);
			
			if($idx == 'rendah'){
				$centroid['rendah'] = $centroid_baru;
			}elseif($idx == 'sedang'){
				$centroid['sedang'] = $centroid_baru;
			}elseif($idx == 'tinggi'){
				$centroid['tinggi'] = $centroid_baru;
			}
		}
		//var_dump($anggota, $centroid);die;
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