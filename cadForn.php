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
		function my_submit(){
			$("#cgc_real").val($("#cgc").val().replace(/\D/g, ""));
			$("#cep_real").val($("#cep").val().replace(/-/g, ""));
			$("#tel_real").val($("#tel").val().replace(/\(|\)|-/g, ""));
			//$("#forn_form").submit();
		}
		function validateForm(){
			if (!validarCNPJ($("#cgc").val()))
				return false;
		}
		
	</script>


	
</head>

<h1>Escola Regulus</h1>
<?php
	menu();
?>
<h2>Cadastro de Fornecedor</h2>

<form id="forn_form" action="php\fornADO.php" onsubmit="return validateForm()"  style="max-width:800px; padding-left:5px;" >
<div id="tabs">
	  <ul>
		<li><a href="#tabs-1">Principal</a></li>
		<li><a href="#tabs-2">Secundário</a></li>
	</ul>
	<div id="tabs-1">
	<div>
	<label for="name"> Razao Social:</label>	<input name="name" 		type="text"	id="name" 	placeholder="Nome..." required	/>
	<label for="cgc"> CNPJ:</label><input name="cgc" 		type="text"	id="cgc"  onblur="valid(this)" required/>
	</div>
	<div>
	<label for="ie"> Inscr.Estad.:</label><input name="ie" 	type="text"	id="ie" size="9" maxlength="9"/>
	<label for="end">Endereco:<input name="end" 		type="text"	id="end" 	placeholder="Endereco..."/> </label>
	</div>
	</div>
	<div id="tabs-2">
	<label for="bairro">Bairro:<input name="bairro"	type="text"	id="bairro" placeholder="Bairro..." /></label>
	<label for="cidade">Cidade:<input name="cidade"	type="text"	id="cidade" placeholder="Cidade..." />  </label>
	<label for="est">Estado:<input name="estado" 	type="text"	id="est"    maxlength="2"	placeholder="Estado"/></label>
	<label for="munic">Municipio:<input name="municipio" 	type="text"	id="munic"  placeholder="Municipio..."/></label>
	<label for="cep">CEP:<input name="cep" 		type="text"	id="cep"  	placeholder="CEP..."/></label>
	<label for="tipo">Tipo:  
	<select name="tipo_forn" id="tipo" onchange="AlterTp(this.form);" disabled >
		<option value="1">Juridico</option>
		<option value="2">Fisico</option>
	</select>  </label>
	<label>Telefone:		<input name="telefone" 		type="tel"	id="tel"	placeholder="Telefone..." > </label> 
	<label>E-mail:			<input name="email"	 	type="text"	id="email"	placeholder="E-mail..."> </label>
	<label>Home-Page:		<input name="homepage" 		type="text"	id="home"	placeholder="HomePage..."> </label> 
	<label>Contato:		<input name="contato" 	type="text"	id="cont"	placeholder="Contato..."> </label>
	
	<!-- Mascaras de campo -->
	<script type="text/javascript">
		$(document).ready(function(){
			$("#tel").mask("(99)9999-9999")		
		});
		
		$(document).ready(function(){
			$("#cep").mask("99999-999")		
		});
		$(document).ready(function(){
			$("#cgc").mask("99.999.999/9999-99",{placeholder:" "});
		});
		$(document).ready(function(){
			$("#ie").mask("999999999",{placeholder:" "});
		});
	</script>
	</div>
		<input id="cgc_real" name="cgc_real" type="hidden"/>
		<input id="cep_real" name="cep_real" type="hidden"/>
		<input id="tel_real" name="tel_real" type="hidden"/>
		<input id="id_forn" name="id_forn" type="hidden"/>
		<input type="submit" value="Salvar" onclick="my_submit()">
	</div>
	
</form>

<script type="text/javascript">	
	function valid(input){
		if (validarCNPJ(input.value)){
			$(input).removeClass("invalid");
		}else{
			$(input).addClass("invalid");
		}
	}
</script>

<?php else :
   //echo 'You are not authorized to access this page, please login. <br/>';
	redirLogin('cadForn');
   endif;
?>