<?php

include "./php/basic.php";
include './php/db.php';

sec_session_start();
if(login_check($mysql_con) == true) : ?> 

<!doctype html>
<head>
    <!-- Basics -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>REGULUS</title>
    <!-- CSS -->
	<link rel="stylesheet" href="titulo.css">
	<link rel="stylesheet" href="css\menu.css">
	<link href="css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	    <link rel="stylesheet" href="estilo2.css">
	<!-- JS -->
	<script src="js/jquery-1.9.1.js"></script>
	<script src="js/jquery-ui-1.10.3.custom.js"></script>
    <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
	<script src="js/utils.js" type="text/javascript"></script>
		<script>
	  $(function() {
			$( "#tabs" ).tabs();
		});
	  $.urlParam = function(name){
 		   var results = new RegExp('[\\?&amp;]' + name + '=([^&amp;#]*)').exec(window.location.href);
    		return results[1] || null;
		}
		$( document ).ready(function() {
			var id = decodeURIComponent($.urlParam('id'));
			var obj_banc;
	  		if(id != null){
	  			$.get( "php/getBanc.php?id=" + id, function( data ) {
					  obj_banc = jQuery.parseJSON (data );
					  $("#cod_banc").val(obj_banc.cod_banc);
					  $("#agencia").val(obj_banc.agencia);
					  $("#conta").val(obj_banc.conta);
					  $("#id").val(obj_banc.id);
					});

	  		}
		});
		
	</script>


	
</head>

<h1>Escola Regulus</h1>
<?php
	menu();
?>
<h2>Cadastro de Dados Bancários</h2>

<form id="banc_form" action="php\bancADO.php" style="max-width:800px; padding-left:5px;" >
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Dados</a></li>
	</ul>
	<div id="tabs-1">
		<div>
			<label for="cod_banc">Cod. Bancario:<input name="cod_banc" type="text" maxlength="3" id="cod_banc"	placeholder="Cod. Banc." required	/></label>
			<label for="agencia">Agencia:<input name="agencia" type="text" maxlength="6" id="agencia"	placeholder="Agencia..." required	/></label>
			<label for="conta">Conta:<input name="conta" type="text" maxlength="12" id="conta"	placeholder="Conta..." required	/></label>
		</div>
	</div>
		<input type="hidden" name="id" id="id"/>
		<input type="submit" value="Salvar" onclick="my_submit()"/>
</div>
	
</form>

<!-- Mascaras de campo -->
	<script type="text/javascript">
		$(document).ready(function(){
			$("#cod_banc").mask("999",{placeholder:" "})		
		});
		
		$(document).ready(function(){
			$("#agencia").mask("?999999",{placeholder:" "})		
		});

		$(document).ready(function(){
			$("#conta").mask("?999999999999",{placeholder:" "})		
		});
	</script>


<?php else :
   echo 'You are not authorized to access this page, please login. <br/>';
   endif;
?>