<?php
include "./php/basic.php";
include "./php/basicRel.php";
include './php/db.php';
sec_session_start();
$report = isset($_REQUEST['report']) ? $_REQUEST['report']: false;
if(login_check($mysql_con) == true && $report) : ?>

<!DOCTYPE html>
<head>
    <!-- Basics -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>REGULUS</title>
    <!-- CSS -->
    <link rel="stylesheet" href="estilo2.css">
    <link rel="stylesheet" href="animate.css">
	<link rel="stylesheet" href="titulo.css">
	<link rel="stylesheet" href="css/menu.css">
	<link href="css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.10.3/ui/jquery-ui.js" type="text/javascript"></script>		
	<script src="js/utils.js" type="text/javascript"></script>
</head>

<h1>Escola Regulus</h1>

<body>
<?php
	menu();
?>

<div style="margin: auto; width :50%">
	<h3>Parâmetros</h3>
	<form action="./php/<?php echo $report; ?>.php" target="_blank">
		<fieldset>
		<legend>Período</legend>
		<p>
			<label for="data_ini">Data Inicial: </label>
			<input type="date" id="data_ini" name="data_ini"/>
		</p>
		<p>
			<label for="data_fim">Data Final: </label>
			<input type="date" id="data_fim" name="data_fim"/>
		</p>
		</fieldset>
		
		<p>
			<fieldset>
			<legend>Outros</legend>
			<label>Fornecedor: </label>
				<select name="id_forn" id="id_forn">
				<?php
					$stmt = null;
					$stmt = $mysql_con->prepare("SELECT id_forn, raz_social FROM fornecedores");
					$stmt->execute();
					$stmt->bind_result($id,$descricao);
					echo '<option value="*">Todos...</option>';
					while($stmt->fetch()){
						echo '<option value="' . $id . '">' . $descricao . '</option>';
					}
				?>
				</select>
			</fieldset>
		</p>
		
		
		<input type="submit" value="Gerar"/>
	</form>
</div>
</body>

<script>
//$("#data_ini").datepicker();
</script>

<?php else :
   //echo 'You are not authorized to access this page, please login. <br/>';
	redirLogin('REGCAPR011');
   endif;
?>