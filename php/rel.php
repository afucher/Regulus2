<?php

include('MPDF57/mpdf.php');
$mpdf=new mPDF();
header('Content-Type: text/html; charset=utf-8');

$text = '<h1>Meu amigo viado é o...</h1>';
$text = $text . '<h2>Le!</h2>';

$mpdf->WriteHTML(utf8_encode($text));

$mpdf->Output();
exit;


?>