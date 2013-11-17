<?php
include './php/db.php';

$page = $_REQUEST['page']; // get the requested page
$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
//$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
//$sord = $_REQUEST['sord']; // get the direction
//if(!$sidx) $sidx =1;

$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows']: false;
//if($totalrows) {$limit = $totalrows;}
 
	$stmt = $mysql_con->prepare("SELECT COUNT(*) AS count FROM reg_user");
	$stmt->execute();
	$stmt->bind_result($count);
	$row = $stmt->fetch();
	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;

	// calculate the starting position of the rows 
	$start = $limit*$page - $limit;

	// if for some reasons start position is negative set it to 0 
	// typical case is that the user type 0 for the requested page 
	if($start <0) $start = 0; 

	$responce = new stdClass;
	$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	
	$stmt = null;
	
	$stmt = $mysql_con->prepare("SELECT id, username, name, ativo FROM reg_user LIMIT " . $start . ", " . $limit);
	$stmt->execute();
	$stmt->bind_result($id,$username,$name,$ativo);
	while($stmt->fetch()){
		$responce->rows[$i]['id']=$id;
		$responce->rows[$i]['username']=$username;
		$responce->rows[$i]['name']=$name;
		$responce->rows[$i]['ativo']=$ativo;
		$i++;
	}
	
	echo json_encode($responce);
?>