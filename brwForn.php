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
    <link rel="stylesheet" href="css\thur.jqgrid.custom.css">
    <link rel="stylesheet" href="animate.css">
	<link rel="stylesheet" href="titulo.css">
	<link rel="stylesheet" href="css\menu.css">
		<link href="css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" media="screen" href="themes/ui.jqgrid.css">
		<link rel="stylesheet" type="text/css" media="screen" href="themes/ui.multiselect.css">
	
		<script src="js/jquery.min.js" type="text/javascript"></script>
		<script src="js/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
		<script src="js/utils.js" type="text/javascript"></script>
		<script src="js/jquery.layout.js" type="text/javascript"></script>
		<script src="js/i18n/grid.locale-en.js" type="text/javascript"></script>
		<script type="text/javascript">
			$.jgrid.no_legacy_api = true;
			$.jgrid.useJSON = true;
		</script>
		<script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>
		<script src="js/jquery.tablednd.js" type="text/javascript"></script>
		<script src="js/jquery.contextmenu.js" type="text/javascript"></script>
		<script src="js/ui.multiselect.js" type="text/javascript"></script>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#browse").jqGrid({
					jsonReader : { repeatitems: false },
					url:'server.php',
					datatype: "json",
					colNames:['id','Nome','CGC','Inscrição Estadual','Tipo de Fornecedor',"Ativo"],
					colModel:[
						{name:'id',index:'id',sortable:false, width:70, align:"center", hidden:false},
						{name:'name',index:'name',sortable:false, width:150},
						{name:'cnpj',index:'cnpj',sortable:false, width:200, align:"right", formatter:cnpjFormatter},
						{name:'ie',index:'ie',sortable:false, width:150, align:"right"},		
						{name:'tipo_forn',sortable:false, width:150, align:"right",hidden:true},
						{name:'ativo',sortable:false, width:150, align:"right",hidden:true},
					],
					afterInsertRow: function(id, data)
			        {
			            if(parseInt(data.ativo) == 0) {
			                $('tr#' + id).addClass('inactive');
			            }
			        },
					rowNum:10,
					rowList:[10,20,30],
					pager: '#pager2',
					hidegrid: false,
					autowidth: true,
					//sortname: 'id',
					viewrecords: true,
					//sortorder: "desc",
					caption:"Fornecedores"
				});
				jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});
			});
			function cnpjFormatter (cellvalue, options, rowObject)
			{
				
				//1 = Jurídico (CNPJ)
				//2 = Físico (CPF)
				if(rowObject.tipo_forn == 1){
					//Coloca ponto entre o segundo e o terceiro dígitos
					cellvalue=cellvalue.replace(/^(\d{2})(\d)/,"$1.$2")
					//Coloca ponto entre o quinto e o sexto dígitos
					cellvalue=cellvalue.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
					//Coloca uma barra entre o oitavo e o nono dígitos
					cellvalue=cellvalue.replace(/\.(\d{3})(\d)/,".$1/$2")
			 		//Coloca um hífen depois do bloco de quatro dígitos
					getCellvalue=cellvalue.replace(/(\d{4})(\d)/,"$1-$2")
				}else{
				    //Coloca um ponto entre o terceiro e o quarto dígitos
				    cellvalue = cellvalue.replace(/(\d{3})(\d)/, "$1.$2");
				    //Coloca um ponto entre o sexto e o setimo dígitos 
				    cellvalue = cellvalue.replace(/(\d{3})(\d)/, "$1.$2");
				     //Coloca um hífen entre o terceiro e o quarto dígitos
				    cellvalue = cellvalue.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
				}	
				return cellvalue;
			}
			function alterar(id){
				window.location.replace("./cadForn.php?id=" + id);
			}
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
			function getID(){
				return getField('id');
			}
		</script>
	
	
</head>

<h1>Escola Regulus</h1>

<body>
<?php
	menu();
?>
<h2>Fornecedores</h2>
<div id="brw_container">
	<input type="button" id="edit" value="Alterar"/>
	<table id="browse"/>
	<div id="pager2">
</div>

</body>


<script>
	jQuery("#edit").click( function() {
		var id = getID();
		if(id==null){
			alert('Selecione um fornecedor...');
		}else{
			alterar(id);
		}
	});
</script>

</html>

<?php else :
   //echo 'You are not authorized to access this page, please login. <br/>';
	redirLogin('brwForn');
   endif;
?>