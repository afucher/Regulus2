<?php
include 'db.php';
include 'basic.php';
sec_session_start(); // Our custom secure way of starting a php session. 
if (mysqli_connect_errno()) {
   // printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if(isset($_POST['username'], $_POST['old_pass'],$_POST['new_pass'])) { 
   $username = $_POST['username'];
   $old_pass = $_POST['old_pass']; // The hashed password.
   $new_pass = $_POST['new_pass'];

   if(chgPass($username,$old_pass, $new_pass, $mysql_con) == true) {
      header('Location: ../index.html');
      exit();
   } else {
      // Login failed
	  
      header('Location: ../chgPass.html?error=1');
	  exit();
   }
} else { 
   // The correct POST variables were not sent to this page.
   echo 'Invalid Request';
}
?>