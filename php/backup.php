 <?php
 include "./basic.php";
 include './db.php';
 $file_backup	=	backup_database_tables(HOST, USER, PASSWORD, DATABASE, 'reg_user,tipos,fornecedores,dados_banc,titulos');

 //header("Location: $file_backup");
	//exit();

// backup the db function
  function backup_database_tables($host,$user,$pass,$name,$tables)
 {

 $link = mysql_connect($host,$user,$pass);
 mysql_select_db($name,$link);
 $drops = "";

//get all of the tables
 if($tables == '*')
 {
 $tables = array();
 $result = mysql_query('SHOW TABLES');
 while($row = mysql_fetch_row($result))
 {
 $tables[] = $row[0];
 }
 }
 else
 {
 $tables = is_array($tables) ? $tables : explode(',',$tables);
 }

//cycle through each table and format the data
 foreach($tables as $table)
 {
 $result = mysql_query('SELECT * FROM '.$table);
 $num_fields = mysql_num_fields($result);

$drops = 'DROP TABLE IF EXISTS '.$table.";\n" . $drops;
 $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
 $return.= "\n\n".$row2[1].";\n\n";

for ($i = 0; $i < $num_fields; $i++)
 {
 while($row = mysql_fetch_row($result))
 {
 $return.= 'INSERT INTO '.$table.' VALUES(';
 for($j=0; $j<$num_fields; $j++)
 {
 $row[$j] = addslashes($row[$j]);
 $row[$j] = ereg_replace("\n","\\n",$row[$j]);
 
 if (isset($row[$j])) { 
 	if(empty($row[$j])  && !is_numeric($row[$j])){
 		$return.= 'DEFAULT' ; 
 	}else{
 		//$return.= '"'. utf8_encode($row[$j]) .'"' ; 
 		$return.= '"'. $row[$j] .'"' ; 
 	}
 	
 } else { 
 	$return.= 'null';
  }


 if ($j<($num_fields-1)) { $return.= ','; }
 }
 $return.= ");\n";
 }
 }
 $return.="\n\n\n";
 }
//echo $return;
//save the file

$return = $drops . $return;

//$file_backup = '../backup/db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql';
$file_backup = '../backup/db-backup-' . date("Y-m-d") . '-' .time() . '.sql';

$fp = fopen($file_backup,"wb");
if( $fp == false ){
    print_r(error_get_last());
}else{
	fwrite($fp,$return);
	fclose($fp);
}

return $file_backup;

 //$handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
 //fwrite($handle,$return);
 //fclose($handle);
 }
 ?>
