<?php
    require_once('../html2fpdf/html2pdf.class.php');
?>
<?php
    ob_start();
    	include(dirname(__FILE__).'/cetak_isi_harian.php');

    $content = ob_get_clean();
	
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('exemple.pdf');
	//echo $content;
?>