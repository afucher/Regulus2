<?php

include "./basic.php";
include "./basicRel.php";
include './db.php';

sec_session_start();
if(login_check($mysql_con) == true){

	$stmt = $mysql_con->prepare("SELECT num_tit,num_par,val_tit,raz_social,dat_venc FROM titulos AS tit,  fornecedores as forn where tit.ID_Forn = forn.id_forn AND dat_baix IS NULL AND dat_venc < current_date ORDER BY dat_venc");
	$stmt->execute();
	$stmt->bind_result($num_tit,$num_par,$val_tit,$raz_social,$dat_venc);
	
	$html = '';
	
	$html = $html . getHeaderRel('Relatório Contas Vencidas');//'<h1>Relatório Contas Vencidas</h1>';
	
	$html = $html . '<table class ="CSSTableGenerator" border="1">
		<tbody>';
	$html = $html . geraLinha(Array("Título","Parcela","Valor Título","Fornecedor","Data de Vencimento"));
	while($stmt->fetch()){
		$html = $html . geraLinha(Array($num_tit,$num_par,toMoney($val_tit,'R$'),$raz_social,$dat_venc));
	}
	$html = $html . '</tbody>
		</table>';

include('MPDF57/mpdf.php');
$mpdf=new mPDF();
//header('Content-Type: text/html; charset=utf-8');

$stylesheet = file_get_contents('../css/relatorio.css');
$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML(utf8_encode($html));

$mpdf->Output();
exit;
}

function geraLinha($arr)
{
$linha = '<tr>';

foreach($arr as $value ){
	$linha = $linha . '<td>' . $value . '</td>';
}

$linha = $linha . '</tr>';
return $linha;
}

function toMoney($val,$symbol='$',$r=2)
{


    $n = $val; 
    $c = is_float($n) ? 1 : number_format($n,$r);
    $d = '.';
    $t = ',';
    $sign = ($n < 0) ? '-' : '';
    $i = $n=number_format(abs($n),$r); 
    $j = (($j = strlen($i)) > 3) ? $j % 3 : 0; 

   return  $symbol.$sign .($j ? substr($i,0, $j) + $t : '').preg_replace('/(\d{3})(?=\d)/',"$1" + $t,substr($i,$j)) ;

}

?>