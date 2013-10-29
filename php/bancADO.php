<?php

include "./basic.php";
include './db.php';

sec_session_start();
if(login_check($mysql_con) == true)
{
$agencia = isset($_REQUEST['agencia']) ? $_REQUEST['agencia']: false;
$cod_banc = isset($_REQUEST['cod_banc']) ? $_REQUEST['cod_banc']: false;
$conta = isset($_REQUEST['conta']) ? $_REQUEST['conta']: false;


if(!$agencia || !$cod_banc || !$conta)
	die("morreu");
	
if(insertBanc($cod_banc,$agencia,$conta,$mysql_con)){
	header('Location: ../brwBanc.php');
}

}

function insertBanc($cod_banc,$agencia,$conta,$mysql_con)
{
$query = "INSERT INTO dados_banc (Cod_Banc, Agencia, Conta) VALUES (?,?,?)";

if(!$stmt = $mysql_con->prepare($query)){
	echo "Prepare failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
}
$stmt->bind_param('sss',$cod_banc,$agencia,$conta);
$lRet = $stmt->execute();
if (!$lRet){
	echo "Execute failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
}
return $lRet;
}
?> 