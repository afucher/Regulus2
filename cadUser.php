<?php

include "./php/basic.php";
include './php/db.php';

sec_session_start();
if(login_check($mysql_con) == true) : ?> 


<!DOCTYPE html>
<html>
<head>
	<!-- Basics -->
    <meta charset="utf-8">
	<title>Regulus</title>

	<!-- JS -->
	<script src="js/jquery-1.9.1.js"></script>
	<script src="js/jquery-ui-1.10.3.custom.js"></script>


	<!-- CSS -->
	<style type="text/css">
	.checkbox_label.ui-state-active{
		background: rgba(0, 255, 0, 0.4) !important;
	}
	.checkbox_label{
		background: rgba(255, 0, 0, 0.4) !important;
	}
	</style>
	<link href="css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet"/>
	<link rel="stylesheet" href="titulo.css">
	<link rel="stylesheet" href="estilo2.css">
	<link rel="stylesheet" href="css\menu.css">
	<link rel="stylesheet" href="css\slide_check.css">

	<script>
	  $(function() {
			$( "#tabs" ).tabs();
			$("#checks").buttonset();
		});
	</script>

	<script>
		$.urlParam = function(name){
 		   var results = new RegExp('[\\?&amp;]' + name + '=([^&amp;#]*)').exec(window.location.href);
 		   if (results == null){
 		   		return null;
 		   }else{
 		   	return results[1] || null;
 		   }
		}
	$( document ).ready(function() {
		var id = decodeURIComponent($.urlParam('id'));
		var obj_banc;
  		if(id != "null"){
  			$.get( "php/getUser.php?id=" + id, function( data ) {
				obj_banc = jQuery.parseJSON (data );
				$("#name").val(obj_banc.name);
				$("#username").val(obj_banc.username);
				$("#password").val(obj_banc.password);

				if(obj_banc.ativo == 0){
					$("#ativo").removeAttr('checked');
				} 
				if(obj_banc.cadastro == 0){
					$("#cadastro").removeAttr('checked');
				}
				if(obj_banc.relatorio == 0){
					$("#relatorio").removeAttr('checked');
				}				
				if(obj_banc.CAP == 0){
					$("#CAP").removeAttr('checked');
				}
				if(obj_banc.admin == 0){
					$("#admin").removeAttr('checked');
				}
				$("#id").val(obj_banc.id);
				$("#checks").buttonset("refresh");
			});

  		}
	});
	</script>


</head>

<body>

<h1>Escola Regulus</h1>
<?php
	menu();
?>
<h2>Cadastro de Usuário</h2>


<form action="php\userADO.php" style="max-width:800px; padding-left:5px;" >
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Cadastrais</a></li>
			<li><a href="#tabs-2">Acessos</a></li>
		</ul>
		<div id="tabs-1">
			<p>
				<label>Username:</label>
				<input id="username" name="username" type="text" maxlength="15" pattern="(^[a-zA-Z0-9_]*$)" title="Espaços e caracteres especiais não são aceitos." required="required"/>
			</p>
			<p>
				<label>Name:</label>
				<input id="name" name="name" type="text" maxlength="30" required="required"/>
			</p>
			<p>
				<label>Password:</label>
				<input id="password" name="password" type="password" pattern=".{6,}"  title="Mínimo de 6 caracteres" required="required">
			</p>
			<div class="slideThree">
				<input type="checkbox" value="1" id="ativo" name="ativo" checked="checked" />
				<label for="ativo"></label>
			</div>
		</div>
		<div id="tabs-2">
			<div id="checks">
				<p>
					<input type="checkbox" value="1" id="relatorio" name="relatorio" checked="checked"/>
					<label class="checkbox_label" for="relatorio">Relatorio</label>
				</p>
				<p>
					<input type="checkbox" value="1" id="cadastro" name="cadastro" checked="checked"/>
					<label class="checkbox_label" for="cadastro">Cadastro</label>
				</p>
				<p>
					<input type="checkbox" value="1" id="CAP" name="CAP" checked="checked"/>
					<label class="checkbox_label" for="CAP">Contas a Pagar</label>
				</p>
				<?php if(login_check($mysql_con) == true) : ?>
				<p>
					<input type="checkbox" value="1" id="admin" name="admin" checked="checked"/>
					<label class="checkbox_label" for="admin">Administrador</label>
				</p>
				<?php endif;?>
			</div>
		</div>
	</div>
	<input id="id" name="id" type="hidden"/>
	<input type="submit" value="Salvar"/>
</form>


</body>
</html>
<?php else :
   //echo 'You are not authorized to access this page, please login. <br/>';
	redirLogin('cadUser');
   endif;
?>