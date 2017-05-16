<?php

/**
 * PT. Gamatechno Indonesia
 */
require_once 'MPDF57/mpdf.php';

class Rep_pdf extends mpdf {

    public function __construct(
		$mode = '', 
		$format = 'A5-L', 
		$default_font_size = 7, 
		$default_font = 'Helvetica',
		$mgl = 15, 
		$mgr = 15, 
		$mgt = 16, 
		$mgb = 16, 
		$mgh = 9, 
		$mgf = 9, 
		$orientation = 'P') {
        
		parent::__construct(
		
		$mode, 
		$format, 
		$default_font_size, 
		$default_font, 
		$mgl, 
		$mgr, 
		$mgt, 
		$mgb, 
		$mgh, 
		$mgf, 
		$orientation);
    }

}

?>
