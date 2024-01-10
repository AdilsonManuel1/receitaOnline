<?php
use Dompdf\Dompdf;
require_once 'dompdf/autoload.inc.php';
$dompdf = new Dompdf();
$dompdf->loadHtml("Olá mundo! ");

$dompdf->set_option('defaultfont','sans');
//$dompdf->setPaper('A4', 'portrait');
$dompdf->setPaper('A4', 'landscape'); 
$dompdf->render();
$dompdf->stream();
?>