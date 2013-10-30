<?php

include "./basic.php";
include './db.php';

sec_session_start();
if(login_check($mysql_con) == true)
{
$num_tit = isset($_REQUEST['titulo']) ? $_REQUEST['titulo']: "";
$parcela = isset($_REQUEST['numparc']) ? $_REQUEST['numparc']: "1";
$num_nf  = isset($_REQUEST['nf']) ? $_REQUEST['nf']: "";
$desc_tit = isset($_REQUEST['desc']) ? $_REQUEST['desc']: "";
$id_forn = isset($_REQUEST['id_forn']) ? $_REQUEST['id_forn']: "";
$dat_emis = isset($_REQUEST['emissao']) ? $_REQUEST['emissao']: "";
$dat_venc = isset($_REQUEST['venc']) ? $_REQUEST['venc']: "";
$val_mult = isset($_REQUEST['vlrmlt']) ? $_REQUEST['vlrmlt']: "1";
$val_desc = isset($_REQUEST['vlrdesc']) ? $_REQUEST['vlrdesc']: "";
$val_tot = isset($_REQUEST['vlrtot']) ? $_REQUEST['vlrtot']: "";
$tipo = isset($_REQUEST['tipo_conta']) ? $_REQUEST['tipo_conta']: "";

$imposto = isset($_REQUEST['homepage']) ? $_REQUEST['homepage']: "";

$dat_baix = isset($_REQUEST['contato']) ? $_REQUEST['contato']: "";
$num_par = isset($_REQUEST['bairro']) ? $_REQUEST['bairro']: "";
//$val_tit = isset($_REQUEST['vlrtot']) ? $_REQUEST['cep']: "";
$val_pag = isset($_REQUEST['tipo_forn']) ? $_REQUEST['tipo_forn']: "";

$parcela = is_numeric($parcela) ? $parcela : "1";

$val_tot = str_replace(".","",$val_tot);
$val_tot = str_replace(",",".",$val_tot);

$dat_venc_tit = $dat_venc;
$val_tit	=	(float)$val_tot/(float)$parcela;
$num_par = "1";
$nFor = 1;
$diff = 0.00;
$arr_val_tit = Array();
$arr_data_tit = Array();

for($nFor = 1;$nFor <= $parcela; $nFor++){
	$arr_data_tit[$nFor] = somar_data($dat_venc,0,$nFor-1,0);

	$arr_val_tit[$nFor] = round($val_tit,2);
	$diff += $val_tit - $arr_val_tit[$nFor];
}

$arr_val_tit[$parcela] += $diff;
$arr_val_tit[$parcela] = round($arr_val_tit[$parcela],2);

for($nFor = 1;$nFor <= $parcela; $nFor++)
{
	$num_par = $nFor;
	$val_tit = $arr_val_tit[$nFor];
	$dat_venc_tit = $arr_data_tit[$nFor];

	insertTit($num_tit,$parcela,$num_nf,$desc_tit,$id_forn,$dat_emis,$dat_venc_tit,$val_tit,$num_par,$tipo,$val_tot,$mysql_con);
}
	
header('Location: ../brwCAP.php');

}

function insertTit($num_tit,$parcela,$num_nf,$desc_tit,$id_forn,$dat_emis,$dat_venc_tit,$val_tit,$num_par,$tipo,$val_tot,$mysql_con)
{
$query = "INSERT INTO titulos (num_tit, parcela, num_nf, desc_tit, id_forn, dat_emis, dat_venc, val_tit, num_par, tipo, val_tot) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

if(!$stmt = $mysql_con->prepare($query)){
	die("Prepare failed: (" . $mysql_con->errno . ") " . $mysql_con->error);
}

	if (!$stmt->bind_param('ssssissdssd',$num_tit,$parcela,$num_nf,$desc_tit,$id_forn,$dat_emis,$dat_venc_tit,$val_tit,$num_par,$tipo,$val_tot)){
		die("Bind failed: (" . $mysql_con->errno . ") " . $mysql_con->error);	
	}
	if (!$stmt->execute()){
	 die("Execute failed: (" . $mysql_con->errno . ") " . $mysql_con->error);
	}
}

function somar_data($data, $dias, $meses, $ano){
  $data = explode("-", $data);
  $resData = date("Y-m-d", mktime(0, 0, 0, $data[1] + $meses, $data[2] + $dias, $data[0] + $ano));
  return $resData;
 }
?> 