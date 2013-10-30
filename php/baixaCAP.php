<?php
include "./basic.php";
include './db.php';

sec_session_start();
if(login_check($mysql_con) == true)
{
	$dt_baixa = isset($_REQUEST['dt_baixa']) ? $_REQUEST['dt_baixa']: "";
	$val_pago = isset($_REQUEST['val_pago']) ? $_REQUEST['val_pago']: "";
	$titulo   = isset($_REQUEST['titulo']) ? $_REQUEST['titulo']: "";
	$parcela  = isset($_REQUEST['parcela']) ? $_REQUEST['parcela']: "";
	$val_desc  = isset($_REQUEST['val_desc']) ? $_REQUEST['val_desc']: 0;
	$val_multa  = isset($_REQUEST['val_multa']) ? $_REQUEST['val_multa']: 0;
	$id_banc  = isset($_REQUEST['id_banc']) ? $_REQUEST['id_banc']: false;
	
	$val_pago = str_replace("R$","",$val_pago);
	$val_pago = str_replace(".","",$val_pago);
	$val_pago = str_replace(",",".",$val_pago);

	$val_desc = str_replace("R$","",$val_desc);
	$val_desc = str_replace(".","",$val_desc);
	$val_desc = str_replace(",",".",$val_desc);

	$val_multa = str_replace("R$","",$val_multa);
	$val_multa = str_replace(".","",$val_multa);
	$val_multa = str_replace(",",".",$val_multa);
	
/*	echo $dt_baixa;
	echo      $val_pago;
	echo      $titulo  ;
	echo  $parcela ;
	die();
	echo $id_banc;
	die();*/
	
	$query = "UPDATE titulos SET Dat_Baix=?, Val_Pag=?, Val_mult=?, Val_Desc=?, id_banc=? WHERE Num_Tit=? AND Num_Par=?";
	
	if(!$stmt = $mysql_con->prepare($query)){
		die("Prepare failed: (" . $mysql_con->errno . ") " . $mysql_con->error);
	}
	
	if (!$stmt->bind_param('sdddiss',$dt_baixa,$val_pago,$val_desc,$val_multa,$id_banc,$titulo,$parcela)) {
		die("Bind failed: (" . $mysql_con->errno . ") " . $mysql_con->error);
	}
	
	if (!$stmt->execute()){
		die("Execute failed: (" . $mysql_con->errno . ") " . $mysql_con->error);
	}	
	
}
?>
