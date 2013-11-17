<?php
include './db.php';

$id = $_REQUEST['id']; // get the requested page


$responce = new stdClass;

$stmt = null;

$stmt = $mysql_con->prepare("SELECT username, name, relatorio, cadastro, CAP, ativo, admin FROM reg_user WHERE id = ?");
$stmt->bind_param('i',$id);
$stmt->execute();
$stmt->bind_result($username, $name, $relatorio, $cadastro, $CAP, $ativo, $admin);
if($stmt->fetch()){
	$responce->id=$id;

	$responce->username=$username;
	$responce->name=$name;
	$responce->relatorio=$relatorio;
	$responce->cadastro=$cadastro;
	$responce->CAP=$CAP;
	$responce->ativo=$ativo;
	$responce->admin=$admin;

	//retorna 6 * no password, para que não veja a senha do usuário
	$responce->password='******';
}

echo json_encode($responce);


?>