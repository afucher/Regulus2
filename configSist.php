<?php

include "./php/basic.php";
include './php/db.php';

sec_session_start();
if(login_check($mysql_con) == true) : ?> 

<!DOCTYPE html>
<html>
<head>
	<title>Configuração Sistema</title>

	 <!-- Basics -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>REGULUS</title>
    <!-- CSS 
	<link href="css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet">-->
	<link rel="stylesheet" href="estilo2.css"/>
	<link rel="stylesheet" href="css\menu.css"/>
	<link rel="stylesheet" href="css\rotation.css"/>
	<link rel="stylesheet" href="titulo.css"/>


	<!-- JS q-->
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>

</head>
<body>
	<h1>Escola Regulus</h1>
	<?php
		Menu();
	?>

	<div>
		<form id="form_bkp" method="post" action="php\applyBkp.php" style="max-width:800px; padding-left:5px;">
			<p>
				<label>Arquivos de Backup:</label>
				<select name="bkp_file" id="bkp_file">
				<?php
					$directory = ".\backup\\";
					$phpfiles = glob($directory . "*.sql");
					foreach($phpfiles as $phpfiles)
					{
						echo '<option value="' . $phpfiles . '">' . basename($phpfiles) . '</option>';
					}
				?>
				</select>
			</p>
			<input type="button" value="Restaurar Backup" onclick="rest_bkp()" />
			<input type="button" value="Fazer Backup" onclick="make_bkp()">
		</form>
	</div>

<div id='loader' class="hidden">
  <div class='dot'></div>
  <div class='dot'></div>
  <div class='dot'></div>
  <div class='dot'></div>
  <div class='dot'></div>
  <div class='dot'></div>
  <div class='dot'></div>
  <div class='dot'></div>
  <div class='dot'></div>
  <div class='dot'></div>
  <div class='dot'></div>
  <div class='dot'></div>
</div>


	<script type="text/javascript">
		function make_bkp(){
			$.post( "php/backup.php")
				.done(function( data ) {
				 	alert("Backup efetuado!");
					location.reload();
				})
				.fail(function() {
    				alert( "error" );
  				});
		}
		function rest_bkp(){
			var param = {"bkp_file":$("#bkp_file").val()};
			var spin = $("#loader").removeClass("hidden");
			$.post( "php/applyBkp.php" ,param)
				.done(function( data ) {
					spin.addClass("hidden");
					alert("Backup restaurado!");
				 	//alert(data);
					//location.reload();
				})
				.fail(function() {
    				alert( "error" );
  				});
		}
	</script>

</body>
</html>


<?php else :
   //echo 'You are not authorized to access this page, please login. <br/>';
	redirLogin('configSist');
   endif;
?>