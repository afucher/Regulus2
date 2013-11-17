<?php

include "./basic.php";
include './db.php';

sec_session_start();
if(login_check($mysql_con) == true)
{
$name = isset($_REQUEST['name']) ? $_REQUEST['name']: false;
$username = isset($_REQUEST['username']) ? $_REQUEST['username']: false;
$password = isset($_REQUEST['password']) ? $_REQUEST['password']: false;

$id = isset($_REQUEST['id']) ? $_REQUEST['id']: false;


// 0 - desativado, outros valores ativado.
$ativo = isset($_REQUEST['ativo']) ? $_REQUEST['ativo']: "0";

// 0 - desabilitado, outros valores habilitado.
$relatorio = isset($_REQUEST['relatorio']) ? $_REQUEST['relatorio']: "0";
$CAP = isset($_REQUEST['CAP']) ? $_REQUEST['CAP']: "0";
$cadastro = isset($_REQUEST['cadastro']) ? $_REQUEST['cadastro']: "0";

$admin = isset($_REQUEST['admin']) ? $_REQUEST['admin']: "0";


	if(!$name || !$username || !$password)
		die("morreu");

	if($id){
		if(updateUser($name,$username,$password,$ativo,$relatorio,$CAP,$cadastro,$admin,$id,$mysql_con)){
			header('Location: ../brwUser.php');
		}
	}else{
		if(insertUser($name,$username,$password,$ativo,$relatorio,$CAP,$cadastro,$admin,$mysql_con)){
			header('Location: ../brwUser.php');
		}
	}
}

function insertUser($name,$username,$password,$ativo,$relatorio,$CAP,$cadastro,$admin,$mysql_con)
{
	$query = "INSERT INTO reg_user (name, username, password, ativo, relatorio, CAP, cadastro, admin) VALUES (?,?,?,?,?,?,?,?)";

	if(!$stmt = $mysql_con->prepare($query)){
		echo "Prepare failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
	}
	$stmt->bind_param('sssiiiii',$name,$username,$password,$ativo,$relatorio,$CAP,$cadastro,$admin);
	$lRet = $stmt->execute();
	if (!$lRet){
		echo "Execute failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
	}
	return $lRet;
}


function updateUser($name,$username,$password,$ativo,$relatorio,$CAP,$cadastro,$admin,$id,$mysql_con)
{
	$atualizaPass = !($password == '******');

	if($atualizaPass){
		$query = "UPDATE reg_user SET name = ?, username = ?, password = ?, ativo = ?, relatorio = ?, CAP = ?, cadastro = ?, admin = ? WHERE id = ?";
	}else{
		$query = "UPDATE reg_user SET name = ?, username = ?, ativo = ?, relatorio = ?, CAP = ?, cadastro = ?, admin = ? WHERE id = ?";
	}
	
	if(!$stmt = $mysql_con->prepare($query)){
		echo "Prepare failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
	}

	if($atualizaPass){
		$stmt->bind_param('sssiiiiii',$name,$username,$password,$ativo,$relatorio,$CAP,$cadastro,$admin,$id);
	}else{
		$stmt->bind_param('ssiiiiii',$name,$username,$ativo,$relatorio,$CAP,$cadastro,$admin,$id);
	}
	
	$lRet = $stmt->execute();
	if (!$lRet){
		echo "Execute failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
	}
	return $lRet;
}


?> 