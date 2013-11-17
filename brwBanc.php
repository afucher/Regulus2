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
		<script src="js/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
		<script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>-->
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
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#browse").jqGrid({
					jsonReader : { repeatitems: false },
					url:'brwBancADO.php',
					datatype: "json",
					colNames:['id','Descrição','Cod.Bancario','Agencia','Conta'],
					colModel:[
						{name:'id',index:'id',sortable:false, width:70, align:'center', hidden:false},
						{name:'descricao',index:'descricao',sortable:false, align:'center', width:150},
						{name:'cod_banc',index:'cod_banc',sortable:false, align:'center', width:150},
						{name:'agencia',index:'agencia',sortable:false, align:'center', width:200},
						{name:'conta',index:'conta',sortable:false, align:'center', width:150},							
					],
					rowNum:10,
					rowList:[10,20,30],
					pager: '#pager2',
					hidegrid: false,
					autowidth: true,
					//sortname: 'id',
					viewrecords: true,
					//sortorder: "desc",
					caption:"Dados Bancários"
				});
				jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});
			});
		</script>
		<script type="text/javascript">
			function alterar(id){
				window.location.replace("./cadBanc.php?id=" + id);
			}
			function deletar(id){
				if(confirm("Deseja mesmo deletar o item " + id)){
					var param;
					param = {"id":id,"del":true}
					$.post( "php/canDelBanc.php", param)
					.done(function( data ) {
						if(data){
							$.post( "php/bancADO.php", param)
							.done(function( data ) {
								location.reload();
							});
						}else{
							alert("Esta conta já possui títulos associados, não é possível deletar!");
						}
					});
				}
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
<h2>Dados Bancários</h2>
<div id="brw_container">
	<input type="button" id="edit" value="Alterar"/>
	<input type="button" id="del" value="Deletar"/>
	<table id="browse"/>
	<div id="pager2">
</div>

</body>
</html>

<!-- Ações dos botões-->
<script>
	jQuery("#edit").click( function() {
		var id = getID();
		if(id==null){
			alert('Selecione um título...');
		}else{
			alterar(id);
		}
	});

	jQuery("#del").click( function() {
		var id = getID();
		if(id==null){
			alert('Selecione um título...');
		}else{
			deletar(id);
		}
	});
</script>



<?php else :
   //echo 'You are not authorized to access this page, please login. <br/>';
	redirLogin('brwBanc');
   endif;
?>