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
    <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
	<script src="js/jquery.maskMoney.js" type="text/javascript"></script>
	<script src="js/utils.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.10.3.custom.js"></script>
	
	<script>
		$(function() {
			$( "#tabs" ).tabs();
		});
	</script>
	
</head>

<h1>Escola Regulus</h1>
<?php
	menu();
?>
<h2>Cadastro de Contas a Pagar</h2>


<form id="forn_form" action="php\capADO.php" style="padding-left:5px; padding-right:10px; min-width:600px; max-width:800px; ">
	<div id="tabs" >
		<ul>
			<li><a href="#tabs-1">Cadastrais</a></li>		
		</ul>
		<div id="tabs-1">
			<label for="titulo"> N.Titulo: <input name="titulo"	type="text" 	id="titulo" 	placeholder="Titulo..." 		required />	</label> 
			<label> Nota Fiscal: 	<input name="nf"		type="text" 	id="nf" 		placeholder="Nota Fiscal..."			 ></label> 
			<label> Descricao:    	<input name="desc"		type="text" 	id="desc" 		placeholder="Descricao..." 				 ></label> 
			<label> Num.Parcelas: 	<input name="numparc"	type="text" 	id="numparc"	placeholder="Num.Parcelas..."  maxlength="2" size="2" 	 ></label> 
				<label>Tipo de Conta:
					<select name="tipo_conta" id="tipo_conta">
					<?php
						$stmt = $mysql_con->prepare("SELECT id_tip, desc_tip FROM tipos");
						$stmt->execute();
						$stmt->bind_result($id,$descricao);
						while($stmt->fetch()){
							echo '<option value="' . $id . '">' . $descricao . '</option>';
						}
					?>
					</select>
				</label>
			<label>Fornecedor:
					<select name="id_forn" id="id_forn">
					<?php
						$stmt = null;
						$stmt = $mysql_con->prepare("SELECT id_forn, raz_social FROM fornecedores");
						$stmt->execute();
						$stmt->bind_result($id,$descricao);
						while($stmt->fetch()){
							echo '<option value="' . $id . '">' . $descricao . '</option>';
						}
					?>
					</select>
				</label>
			<label> Dt.Emissao:  	<input name="emissao"	type="date" 	id="emissao" 	placeholder="Dt.Emissao..."	required ></label> 
			<label> Vencimento:   	<input name="venc"		type="date" 	id="venc" 		placeholder="Vencimento..."		required ></label> 
			<label> Valor Desconto:  <input name="vlrdesc"	type="text" 	id="vlrdesc" 	placeholder="Valor Desconto..."  		 disabled></label> 
			<label> Valor Total:   <input name="vlrtot"	type="text" 	id="vlrtot" 	placeholder="Valor Total..." 	required > </label> 
		</div>
		<!--<div id="tabs-2">
			<label> Valor Multa: </label>    <input name="vlrmlt"	type="text" 	id="vlrmlt" 	placeholder="Valor Multa..." 	 		 >
		</div>-->
		
		<!-- Campos omitidos
		<label> Parcela: </label>     	<input name="parc"		type="text" 	id="parc" 		placeholder="Parcela..." 		required >
		<label> Dt.Baixa: </label>       <input name="baixa"		type="date" 	id="baixa" 		placeholder="Dt.Baixa..." 				 >
		<label> Valor pago: </label>     <input name="vlrpgt"	type="text" 	id="vlrpgt" 	placeholder="Valor pago..." 	 		 >
		<label> Valor Titulo: </label>	<input name="vlrtit"	type="text" 	id="vlrtit" 	placeholder="Valor Titulo...">
		-->
		
		<input type="submit" value="Salvar">
		<input name="limpar" type="reset" id="limpar" value="Limpar" />

	</div>
</form>

<!-- Scripts responsáveis pelas máscaras de campo-->
<script>
	$(document).ready(function(){
			$("#vlrtot").maskMoney({showSymbol:true, symbol:"R$", decimal:",", thousands:"."});
			$("#numparc").mask("99",{placeholder:" "});
	});
</script>

<?php else :
   //echo 'You are not authorized to access this page, please login. <br/>';
	redirLogin('REGCAP001');
   endif;
?>