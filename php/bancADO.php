<?php

include "./basic.php";
include './db.php';

sec_session_start();
if(login_check($mysql_con) == true)
{
$agencia = isset($_REQUEST['agencia']) ? $_REQUEST['agencia']: false;
$cod_banc = isset($_REQUEST['cod_banc']) ? $_REQUEST['cod_banc']: false;
$conta = isset($_REQUEST['conta']) ? $_REQUEST['conta']: false;
$descricao = isset($_REQUEST['desc']) ? $_REQUEST['desc']: false;
$id = isset($_REQUEST['id']) ? $_REQUEST['id']: false;
$del = isset($_REQUEST['del']) ? $_REQUEST['del']: false;



if(!$del && (!$agencia || !$cod_banc || !$conta))
	die("morreu");

if ($id && !$del){
	if(updateBanc($id,$cod_banc,$agencia,$conta,$descricao,$mysql_con)){
		header('Location: ../brwBanc.php');
	}
}elseif ($del){
	deleteBanc($id,$mysql_con);
}
else{
	if(insertBanc($cod_banc,$agencia,$conta,$descricao,$mysql_con)){
		header('Location: ../brwBanc.php');
	}	
}


}

//----------------
//Funções de CRUD
//----------------
function deleteBanc($id,$mysql_con)
{
	$lRet = false;
	$query = "DELETE FROM dados_banc WHERE id = ?";
	if(!$stmt = $mysql_con->prepare($query)){
		echo "Prepare failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
	}
	if(!$stmt->bind_param('i',$id)){
		echo "Bind failed: (" . $mysql_con->errno . ") " . $mysql_con->error;	
	}
	if(!$stmt->execute()){
		$lRet = true;
		echo "Execute failed: (" . $mysql_con->errno . ") " . $mysql_con->error;	
	}
	return $lRet;
}


function updateBanc($id,$cod_banc,$agencia,$conta,$descricao,$mysql_con)
{
	$query = "UPDATE dados_banc SET Cod_Banc = ? , Agencia = ? , Conta = ?, descricao = ? WHERE id = ?";

	if(!$stmt = $mysql_con->prepare($query)){
		echo "Prepare failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
	}
	$stmt->bind_param('ssssi',$cod_banc,$agencia,$conta,$descricao, $id);
	$lRet = $stmt->execute();
	if (!$lRet){
		echo "Execute failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
	}
	return $lRet;
}


function insertBanc($cod_banc,$agencia,$conta,$descricao,$mysql_con)
{
	$query = "INSERT INTO dados_banc (Cod_Banc, Agencia, Conta, descricao) VALUES (?,?,?,?)";

	if(!$stmt = $mysql_con->prepare($query)){
		echo "Prepare failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
	}
	$stmt->bind_param('ssss',$cod_banc,$agencia,$conta,$descricao);
	$lRet = $stmt->execute();
	if (!$lRet){
		echo "Execute failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
	}
	return $lRet;
}



?> 