<?php
include './db.php';

$id = $_REQUEST['id']; // get the requested page


$responce = new stdClass;

$stmt = null;

$stmt = $mysql_con->prepare("SELECT raz_social, endereco, bairro, cidade, estado, municip, cep, telefone, email, homep, contato, cgc, ie, tipo_forn FROM fornecedores WHERE id_forn = ?");
$stmt->bind_param('i',$id);
$stmt->execute();
$stmt->bind_result($raz_social, $endereco, $bairro, $cidade, $estado, $municip, $cep, $telefone, $email, $homep, $contato, $cgc, $ie, $tipo_forn);
if($stmt->fetch()){
	$responce->id=$id;


	$responce->raz_social=$raz_social;
	$responce->endereco=$endereco;
	$responce->bairro=$bairro;
	$responce->cidade=$cidade;
	$responce->estado=$estado;
	$responce->municip=$municip;
	$responce->cep=$cep;
	$responce->telefone=$telefone;
	$responce->email=$email;
	$responce->homep=$homep;
	$responce->contato=$contato;
	$responce->cgc=$cgc;
	$responce->ie=$ie;
	$responce->tipo_forn=$tipo_forn;
}

echo json_encode($responce);


?>