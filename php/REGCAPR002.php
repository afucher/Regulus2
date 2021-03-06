<?php

include "./basic.php";
include "./basicRel.php";
include './db.php';

sec_session_start();
if(login_check($mysql_con) == true){

	$data_ini = isset($_REQUEST['data_ini']) ? $_REQUEST['data_ini']: false;
	$data_fim = isset($_REQUEST['data_fim']) ? $_REQUEST['data_fim']: false;
	$id_forn = isset($_REQUEST['id_forn']) ? $_REQUEST['id_forn']: false;


	$query = "SELECT num_tit,num_par,val_tit,raz_social,dat_venc FROM titulos AS tit,  fornecedores as forn where tit.ID_Forn = forn.id_forn AND dat_baix IS NULL";

	//------------------------
	//Tratamento de par�metros
	//------------------------
	if($data_ini){
		$query = $query . " AND dat_venc >= '" . $data_ini . "'"; 
	}
	
	if($data_fim){
		$query = $query . " AND dat_venc <= '" . $data_fim . "'"; 
	}
	
	if($id_forn && !($id_forn == "*")){
		$query = $query . " AND forn.id_forn = '" . $id_forn . "'"; 
	}

	$query .= " ORDER BY dat_venc";

	$stmt = $mysql_con->prepare($query);
	$stmt->execute();
	$stmt->bind_result($num_tit,$num_par,$val_tit,$raz_social,$dat_venc);
	
	$html = '';
	
	$html = $html . getHeaderRel('Relat�rio Contas a Pagar');//'<h1>Relatório Contas a Pagar</h1>';
	
	$html = $html . '<table class ="CSSTableGenerator" border="1">
		<tbody>';
	$html = $html . geraLinha(Array("T�tulo","Parcela","Valor T�tulo","Fornecedor","Data de Vencimento"));
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