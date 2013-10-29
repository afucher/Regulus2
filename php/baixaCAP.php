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
	
	$val_pago = str_replace(".","",$val_pago);
	$val_pago = str_replace(",",".",$val_pago);
	
	echo $dt_baixa;
	echo      $val_pago;
	echo      $titulo  ;
	    echo  $parcela ;
	
	
	$query = "UPDATE titulos SET Dat_Baix=?, Val_Pag=? WHERE Num_Tit=? AND Num_Par=?";
	
	if(!$stmt = $mysql_con->prepare($query)){
		echo "Prepare failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
	}
	
	if (!$stmt->bind_param('sdss',$dt_baixa,$val_pago,$titulo,$parcela)){
		echo "Prepare failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
	}
	
	if (!$stmt->execute()){
		echo "Prepare failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
	}	
	
}
?>