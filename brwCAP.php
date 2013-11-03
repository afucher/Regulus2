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
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="animate.css">
	<link rel="stylesheet" href="titulo.css">
	<link rel="stylesheet" href="css\menu.css">

		<link href="css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
			<!--<link rel="stylesheet" type="text/css" media="screen" href="themes/redmond/jquery-ui-1.8.2.custom.css">-->
		<link rel="stylesheet" type="text/css" media="screen" href="themes/ui.jqgrid.css">
		<link rel="stylesheet" type="text/css" media="screen" href="themes/ui.multiselect.css">
		<!--<script src="js/jquery.min.js" type="text/javascript"></script>
		<script src="js/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>-->
		<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
		<script src="js/jquery-ui-1.10.3/ui/jquery-ui.js" type="text/javascript"></script>
		<script src="js/utils.js" type="text/javascript"></script>
		<script src="js/jquery.layout.js" type="text/javascript"></script>
		<script src="js/i18n/grid.locale-en.js" type="text/javascript"></script>
		<script type="text/javascript">
			$.jgrid.no_legacy_api = true;
			$.jgrid.useJSON = true;
		</script>
		<script src="js/jqgrid/jquery.jqGrid.min.js" type="text/javascript"></script>
		<script src="js/jquery.tablednd.js" type="text/javascript"></script>
		<script src="js/jquery.contextmenu.js" type="text/javascript"></script>
		<script src="js/ui.multiselect.js" type="text/javascript"></script>
		<script src="js/jquery.maskMoney.js" type="text/javascript"></script>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#browse").jqGrid({
					jsonReader : { repeatitems: false },
					url:'adoCAP.php',
					datatype: "json",
					colNames:['No. Título','Parcela','Fornecedor','Valor','Dat. Vencimento'],
					colModel:[
						{name:'num_tit',index:'num_tit',sortable:false, width:70, align:"center", hidden:false},
						{name:'num_par',index:'num_par',sortable:false, align:"right",width:60},
						{name:'fornecedor',index:'fornecedor',sortable:false, width:200, align:"right", formatter:cnpjFormatter},
						{name:'val_tit',index:'val_tit',sortable:false, width:150, align:"right"},
						{name:'dat_venc',index:'dat_venc',sortable:false, width:150, align:"right"},
					],
					rowNum:10,
					rowList:[10,20,30],
					pager: '#pager2',
					hidegrid: false,
					autowidth: true,
					//sortname: 'id',
					viewrecords: true,
					//sortorder: "desc",
					caption:"Títulos a Pagar"
				});
				jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});
			});
			function cnpjFormatter (cellvalue, options, rowObject)
			{
				//Coloca ponto entre o segundo e o terceiro dígitos
				cellvalue=cellvalue.replace(/^(\d{2})(\d)/,"$1.$2")
		 
				//Coloca ponto entre o quinto e o sexto dígitos
				cellvalue=cellvalue.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
		 
				//Coloca uma barra entre o oitavo e o nono dígitos
				cellvalue=cellvalue.replace(/\.(\d{3})(\d)/,".$1/$2")
		 
				//Coloca um hífen depois do bloco de quatro dígitos
				cellvalue=cellvalue.replace(/(\d{4})(\d)/,"$1-$2")
				// do something here
				return cellvalue;
			}
		</script>
		<script>
		var num_tit;
		function delTit(titulo){
			num_tit = titulo;
			var text = "Deletar todas as parcelas referentes ao título " + titulo + " ?";
			$( "#dialog" ).html(text).dialog( "open" );
		}
		$(function() {
			$( "#dialog" ).dialog({
			autoOpen: false,
			modal: true,
			buttons: {
				"Todas": function() {
				  $( this ).dialog( "close" );
				  delPHP(num_tit,true);
				},
				"Apenas selecionada": function() {
				  $( this ).dialog( "close" );
				  delPHP(num_tit,false);
				}
			  }
			});
		  });
		$(function() {
			$( "#dialog_baixa" ).dialog({
			autoOpen: false,
			modal: true,
			width: 500,
			buttons: {
				"Baixar": function() {
				  $( this ).dialog( "close" );
				  var param = {"dt_baixa":$("#dt_baixa").val(),"val_pago":$("#val_pago").val(),"titulo":getSelTitulo(),"parcela":getSelParcela(),"val_desc":$("#val_desc").val(),"val_multa":$("#val_multa").val(),"id_banc":$("#conta_banc").val()};
				  $.post( "php/baixaCAP.php", param)
					.done(function( data ) {
					 	//alert(data);
						location.reload();
					});
				},
				"Cancelar": function() {
				  $( this ).dialog( "close" );
				}
			  }
			});
		  });
		  
		function delPHP(titulo,todas){
			var param;
			if(todas){
				param = {"titulo":titulo}
			}else{
				var myGrid = jQuery("#browse");
				var colSel = myGrid.jqGrid('getGridParam','selrow');
				var parcela = myGrid.jqGrid('getCell',colSel,'num_par')
				param = {"titulo":titulo,"parcela":parcela}
			}
			$.post( "php/delCAP.php", param)
			.done(function( data ) {
			  location.reload();
			});
		}
		</script>
	
</head>

<h1>Escola Regulus</h1>

<body>
<?php
	menu();
?>
<h2>Contas a Pagar</h2>
<div id="dialog" title="Deletar...">
</div>
<div id="dialog_baixa" title="Baixar título..." style="width:auto !important;">
	<form id="form_baixa" action="php/baixaCAP.php">
		<label>Data de Baixa: 
			<input id="dt_baixa" type="date" required/>
		</label>
		<label>Multa: 
			<input id="val_multa" type="text"/>
		</label>
		<label>Desconto: 
			<input id="val_desc" type="text"/>
		</label>
		<label>Conta:
				<select name="conta_banc" id="conta_banc" required>
					<?php
						$stmt = $mysql_con->prepare("SELECT id, descricao FROM dados_banc");
						$stmt->execute();
						$stmt->bind_result($id,$descricao);
						while($stmt->fetch()){
							echo '<option value="' . $id . '">' . $descricao . '</option>';
						}
					?>
					</select>
				</label>
		<label>Valor pago: 
			<input id="val_pago" type="text" required/>
		</label>
		<input type="hidden" id="num_tit"/>
		<input type="hidden" id="num_par"/>
		<input type="hidden" id="dat_venc"/>
	</form>
</div>
<div id="brw_container">
	<!--<input type="button" id="create" value="Incluir" onclick="window.location.href='REGCAP001.php'"/>-->
	<input type="button" id="edit" value="Deletar"/>
	<input type="button" id="baixar" value="Baixar"/>
	<table id="browse">
	</table>
	<div id="pager2">
	</div>
</div>
</body>
</html>

<script>
	function getField(field){
		var myGrid = jQuery("#browse");
		var colSel = myGrid.jqGrid('getGridParam','selrow');
		if (colSel==null)
		{
			return null;
		}else{
			return myGrid.jqGrid('getCell',colSel,field);
		}
	}
	//--------------------------------------
	//Retorna o numero do titulo selecionado
	//--------------------------------------
	function getSelTitulo(){
		return getField('num_tit');
	}

	//-------------------------------------
	//Retorna o valor da parcela selecionado
	//-------------------------------------
	function getSelParcela(){
		return getField('num_par');
	}
	//-------------------------------------
	//Retorna o valor do titulo selecionado
	//-------------------------------------
	function getSelValTit(){
		return getField('val_tit');
	}
	//-------------------------------------------------
	//Retorna o dt de vencimento do titulo selecionado
	//-------------------------------------------------
	function getSelDatVenc(){
		return getField('dat_venc');
	}

	function validDate(data){
		if (jsDate == new Date()){
			alert('igual');
		}
		if (jsDate < $.datepicker.formatDate('yy-mm-dd', new Date())){
			alert('venc menor');
		}
		if (jsDate > $.datepicker.formatDate('yy-mm-dd', new Date())){
			alert('venc maior');
		}
	}

	function getJSDate(myDate){
		var dateParts = myDate.split("-");
		var jsDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
		jsDate = $.datepicker.formatDate('yy-mm-dd', jsDate);
		return jsDate;
	}	

	//-------------------------------------------------------
	jQuery("#edit").click( function() {
		var myGrid = jQuery("#browse");
		var colSel = myGrid.jqGrid('getGridParam','selrow');
		if (colSel==null)
		{
			alert('Selecione um título...');
		}else{
			delTit(myGrid.jqGrid('getCell',colSel,'num_tit'));
		}
	});

	jQuery("#baixar").click( function() {
		var titulo = getSelTitulo();
		if (titulo==null){
			alert('Selecione um título...');
		}else{
			if(confirm("Deseja baixar o título: " + titulo + "?"))
			{
				$("#dt_baixa").val($.datepicker.formatDate('yy-mm-dd', new Date()));
				$("#val_pago").val(getSelValTit());
				$("#dat_venc").val(getJSDate(getSelDatVenc() ) );
				$( "#dialog_baixa" ).dialog( "open" );
				$("#val_pago").maskMoney('mask');
				$("#val_multa").maskMoney('mask');
				$("#val_desc").maskMoney('mask');
			}
		}
	});
	$("#val_pago").maskMoney({showSymbol:true, symbol:"R$", decimal:",", thousands:"."});
	$("#val_multa").maskMoney({showSymbol:true, symbol:"R$", decimal:",", thousands:"."});
	$("#val_desc").maskMoney({showSymbol:true, symbol:"R$", decimal:",", thousands:"."});
</script>

<?php else :
   //echo 'You are not authorized to access this page, please login. <br/>';
   redirLogin('brwCAP');
   endif;
?>
