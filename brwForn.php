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
					colNames:['id','Nome','CNPJ','Inscrição Estadual'],
					colModel:[
						{name:'id',index:'id',sortable:false, width:70, align:"center", hidden:false},
						{name:'name',index:'name',sortable:false, width:150},
						{name:'cnpj',index:'cnpj',sortable:false, width:200, align:"right", formatter:cnpjFormatter},
						{name:'ie',index:'ie',sortable:false, width:150, align:"right"},		
					],
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
	
	
</head>

<h1>Escola Regulus</h1>

<body>
<?php
	menu();
?>
<h2>Fornecedores</h2>
<div id="brw_container">
	<table id="browse"/>
	<div id="pager2">
</div>

</body>
</html>

<?php else :
   echo 'You are not authorized to access this page, please login. <br/>';
   endif;
?>