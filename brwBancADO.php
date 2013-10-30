<?php
include './php/db.php';

$page = $_REQUEST['page']; // get the requested page
$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
//$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
//$sord = $_REQUEST['sord']; // get the direction
//if(!$sidx) $sidx =1;

//$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows']: false;
//if($totalrows) {$limit = $totalrows;}

	$stmt = $mysql_con->prepare("SELECT COUNT(*) AS count FROM dados_banc");
	$stmt->execute();
	$stmt->bind_result($count);
	$row = $stmt->fetch();
	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$responce = new stdClass;
	$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	
	$stmt = null;
	
	$stmt = $mysql_con->prepare("SELECT id, cod_banc, agencia, conta, descricao FROM dados_banc");
	$stmt->execute();
	$stmt->bind_result($id,$cod_banc,$agencia,$conta, $descricao);
	while($stmt->fetch()){
		$responce->rows[$i]['id']=$id;
		$responce->rows[$i]['cod_banc']=$cod_banc;
		$responce->rows[$i]['agencia']=$agencia;
		$responce->rows[$i]['conta']=$conta;
		$responce->rows[$i]['descricao']=$descricao;
		$i++;
	}
	
	echo json_encode($responce);
?>