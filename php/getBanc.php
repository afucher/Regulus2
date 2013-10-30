<?php
include './db.php';

$id = $_REQUEST['id']; // get the requested page


$responce = new stdClass;

$stmt = null;

$stmt = $mysql_con->prepare("SELECT cod_banc, agencia, conta, descricao FROM dados_banc WHERE id = ?");
$stmt->bind_param('i',$id);
$stmt->execute();
$stmt->bind_result($cod_banc,$agencia,$conta,$descricao);
if($stmt->fetch()){
	$responce->id=$id;
	$responce->cod_banc=$cod_banc;
	$responce->agencia=$agencia;
	$responce->conta=$conta;
	$responce->descricao=$descricao;
}

echo json_encode($responce);


?>