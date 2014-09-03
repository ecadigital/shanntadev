<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

define('FPDF_FONTPATH','mpdf/font/');

class pdf_generator {
	
	public function Bflibs()
	{
		$this->session = $CI->load->library('session');
		$this->layout = $CI->load->library('Layout');
		$this->request = $CI->load->library('Request');
	}
			
	function pdf_create_multipage($Array_html, $filename, $stream=TRUE) {
		require_once("mpdf/mpdf.php");
		$mpdf=new mPDF('UTF-8','A4'); 
		$mpdf->SetAutoFont();
		$mpdf->SetDisplayMode('fullpage');
		
		$textHeader = 'Create date : '.date("d/m/Y").'                                                                                                                                                                    ';
		$mpdf->setHeader($textHeader);
		
		$textFooter = 'ThaiMediHerb.     http://www.thaimediherb.com     Call Center -';
		$mpdf->setFooter($textFooter);
		
		if(!empty($Array_html)){
			$num=count($Array_html)-1;
			for($i=0;$i<=$num;$i++){
				$mpdf->WriteHTML($Array_html[$i]);
				if($i<$num){
					$mpdf->AddPage();
				}
			}
		}
		$mpdf->Output($filename.'.pdf','I');
		
		exit;

	}
	
	function pdf_create($html, $filename, $stream=TRUE) {
		require_once("mpdf/mpdf.php");
		$mpdf=new mPDF('UTF-8','A4'); 
		$mpdf->SetAutoFont();
		$mpdf->SetDisplayMode('fullpage');
		
		$textHeader = 'Create date : '.date("d/m/Y");
		$mpdf->setHeader($textHeader);
		
		$textFooter = 'ThaiMediHerb     http://www.thaimediherb.com     Call Center -';
		$mpdf->setFooter($textFooter);
		
		$mpdf->WriteHTML($html);
		
		$mpdf->Output($filename.'.pdf','I');
		
		exit;

	}
	
	function pdf_create_landscape($html, $filename, $stream=TRUE) {
		require_once("mpdf/mpdf.php");
		$mpdf=new mPDF('UTF-8','A4-L'); 
		$mpdf->SetAutoFont();
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->AddPage();
		
		$textHeader = 'Create date : '.date("d/m/Y");
		$mpdf->setHeader($textHeader);
		
		$textFooter = 'ThaiMediHerb     http://www.thaimediherb.com     Call Center -';
		$mpdf->setFooter($textFooter);
		
		$mpdf->WriteHTML($html);
		
		$mpdf->Output($filename.'.pdf','I');
		
		exit;

	}	
	
	function pdf_create_landscape_multipage($Array_html, $filename, $stream=TRUE) {
		require_once("mpdf/mpdf.php");
		$mpdf=new mPDF('UTF-8','A4-L'); 
		$mpdf->SetAutoFont();
		$mpdf->SetDisplayMode('fullpage');
		
		$textHeader = 'Create date : '.date("d/m/Y");
		$mpdf->setHeader($textHeader);
		
		$textFooter = 'ThaiMediHerb     http://www.thaimediherb.com     Call Center -';
		$mpdf->setFooter($textFooter);
		
		if(!empty($Array_html)){
			$num=count($Array_html)-1;
			for($i=0;$i<=$num;$i++){
				$mpdf->WriteHTML($Array_html[$i]);
				if($i<$num){
					$mpdf->AddPage();
				}
			}
		}
		$mpdf->Output($filename.'.pdf','I');
		
		exit;

	}	

}

?>  