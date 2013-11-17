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
	<link rel="stylesheet" href="css\thur.jqgrid.custom.css">
	<link href="css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" media="screen" href="themes/ui.jqgrid.css">
	<link rel="stylesheet" type="text/css" media="screen" href="themes/ui.multiselect.css">

	<!-- JS -->
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
					url:'brwUserADO.php',
					datatype: "json",
					colNames:['ID','UserName','Nome','Ativo'],
					colModel:[
						{name:'id',index:'id',sortable:false, width:20, align:"center"},
						{name:'username',index:'username',sortable:false, width:60},
						{name:'name',index:'name',sortable:false, width:200},
						{name:'ativo',index:'ativo',sortable:false, width:10, align:"right", hidden:true},
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
					caption:"Usuários"
				});
				jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});
			});
		</script>

</head>

<h1>Escola Regulus</h1>

<body>
<?php
	menu();
?>
<h2>Usuários</h2>
<div id="brw_container">
	<input type="button" id="insert" value="Incluir"/>
	<input type="button" id="edit" value="Alterar"/>
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
	function getUserID(){
		return getField('id');
	}
	function alterar(id){
		window.location.replace("./cadUser.php?id=" + id);
	}
	function incluir(){
		window.location.replace("./cadUser.php");	
	}

	//-------------------------------------------------------
	jQuery("#edit").click( function() {
		var id = getUserID();
		if(id==null){
			alert('Selecione um usuário...');
		}else{
			alterar(id);
		}
	});

	jQuery("#insert").click(function(){
		incluir();
	});

</script>

<?php else :
   //echo 'You are not authorized to access this page, please login. <br/>';
   redirLogin('brwUser');
   endif;
?>

