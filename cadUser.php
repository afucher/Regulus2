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
</head>

<body>

	<div id="container">
		<form>
			<p>
				<label>Nome: </label>
				<input type="text" id="name"></input>
			</p>
			<p>
				
			</p>

		</form>
	</div>

</body>

<?php else :
   //echo 'You are not authorized to access this page, please login. <br/>';
	redirLogin('cadUser');
   endif;
?>