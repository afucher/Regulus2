<?php

include "./basic.php";
include './db.php';

sec_session_start();
if(login_check($mysql_con) == true)
{
$cgc = isset($_REQUEST['cgc']) ? $_REQUEST['cgc']: false;
$name = isset($_REQUEST['name']) ? $_REQUEST['name']: "";
$end = isset($_REQUEST['end']) ? $_REQUEST['end']: "";
$ie = isset($_REQUEST['ie']) ? $_REQUEST['ie']: "";
$bairro = isset($_REQUEST['bairro']) ? $_REQUEST['bairro']: "";
$cidade = isset($_REQUEST['cidade']) ? $_REQUEST['cidade']: "";
$estado = isset($_REQUEST['estado']) ? $_REQUEST['estado']: "";
$municipio = isset($_REQUEST['municipio']) ? $_REQUEST['municipio']: "";
$cep = isset($_REQUEST['cep']) ? $_REQUEST['cep']: "";
$telefone = isset($_REQUEST['telefone']) ? $_REQUEST['telefone']: "";
$email = isset($_REQUEST['email']) ? $_REQUEST['email']: "";
$homepage = isset($_REQUEST['homepage']) ? $_REQUEST['homepage']: "";
$contato = isset($_REQUEST['contato']) ? $_REQUEST['contato']: "";
//1 - Pessoa Jurídica | 2 - Pessoa Física
$tipo_forn = isset($_REQUEST['tipo_forn']) ? $_REQUEST['tipo_forn']: "1";

$cgc_real = isset($_REQUEST['cgc_real']) ? $_REQUEST['cgc_real']: false;
$tel_real = isset($_REQUEST['tel_real']) ? $_REQUEST['tel_real']: false;
$cep_real = isset($_REQUEST['cep_real']) ? $_REQUEST['cep_real']: false;


if(!$cgc_real || !$name)
	die("morreu");
	
/*	
echo $cgc_real;
echo $name;
echo $end;
echo $ie;
echo $bairro;
echo $cidade;
echo $estado;
echo $municipio;
echo $cep_real;
echo $tipo_pessoa;
echo $tel_real;
echo $email;
echo $homepage;
echo $contato;
echo $tipo_forn;

die();
*/
if(insertForn($cgc_real,$name,$end,$ie,$bairro,$cidade,$estado,$municipio,$cep_real,$tipo_pessoa,$tel_real,$email,$homepage,$contato,$tipo_forn,$mysql_con)){
	header('Location: ../brwForn.php');
}

}

function insertForn($cgc,$name,$end,$ie,$bairro,$cidade,$estado,$municipio,$cep,$tipo_pessoa,$telefone,$email,$homepage,$contato,$tipo_forn,$mysql_con)
{
$query = "INSERT INTO fornecedores (raz_social, endereco, bairro, cidade, estado, municip, cep, telefone, email, homep, contato, cgc, ie, tipo_forn) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

if(!$stmt = $mysql_con->prepare($query)){
	echo "Prepare failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
}
$stmt->bind_param('sssssssssssssi',$name,$end,$bairro,$cidade,$estado,$municipio,$cep,$telefone,$email,$homepage,$contato,$cgc,$ie,$tipo_forn);
$lRet = $stmt->execute();
if (!$lRet){
	echo "Execute failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
}
return $lRet;
}
?> 