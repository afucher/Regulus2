<?php
include './php/db.php';

$page = $_REQUEST['page']; // get the requested page
$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
//$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
//$sord = $_REQUEST['sord']; // get the direction
//if(!$sidx) $sidx =1;

//$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows']: false;
//if($totalrows) {$limit = $totalrows;}
 
	$stmt = $mysql_con->prepare("SELECT COUNT(*) AS count FROM titulos WHERE dat_baix IS NULL");
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
	
	$stmt = $mysql_con->prepare("SELECT num_tit,num_par,val_tit,raz_social,dat_venc,dat_emis FROM titulos AS tit,  fornecedores as forn where tit.ID_Forn = forn.id_forn AND dat_baix IS NULL");
	$stmt->execute();
	$stmt->bind_result($num_tit,$num_par,$val_tit,$raz_social,$dat_venc,$dat_emis);
	while($stmt->fetch()){
		$responce->rows[$i]['num_tit']=$num_tit;
		$responce->rows[$i]['num_par']=$num_par;
		$responce->rows[$i]['fornecedor']=$raz_social;
		$responce->rows[$i]['val_tit']=$val_tit;
		$responce->rows[$i]['dat_venc']=$dat_venc;
		$responce->rows[$i]['dat_emis']=$dat_emis;
		$i++;
	}
	
	echo json_encode($responce);
?>