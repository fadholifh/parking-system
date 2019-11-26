<?php
    require_once('../html2fpdf/html2pdf.class.php');
?>
<?php
	// get the HTML
    ob_start();
	if($_GET['p'] == "awal"){
    	include(dirname(__FILE__).'/cetak_awal.php');
	}

	else{
		include(dirname(__FILE__).'/cetak_akhir.php');
	}
    $content = ob_get_clean();
	
    $html2pdf = new HTML2PDF('P','A8','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('exemple.pdf');
	//echo $content;
?>