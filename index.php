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
	<script src="js/utils.js" type="text/javascript"></script>
</head>

<h1>Escola Regulus</h1>

<body>
<?php
	menu();
?>
    <h2> Seja bem-vindo </h2>	
</body>
</html>

<?php else :
   //echo 'You are not authorized to access this page, please login. <br/>';
   redirLogin('index');
   endif;
?>