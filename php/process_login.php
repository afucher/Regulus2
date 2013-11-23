<?php
include 'db.php';
include 'basic.php';
sec_session_start(); // Our custom secure way of starting a php session. 
if (mysqli_connect_errno()) {
   // printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if(isset($_POST['username'], $_POST['password'])) { 
   $email = $_POST['username'];
   $password = $_POST['password']; // The hashed password.
   if(login($email, $password, $mysql_con) == true) {
      $url = isset($_POST['url']) ? $_POST['url'] : false;
      // Login success
      //echo 'Success: You have been logged in!';
	  //$con->close();
      //echo $url;
      if ($url){

         header('Location: ../' . $url);
         exit();
      }else{
         header('Location: ../index.php');
         exit();
      }
	  exit();
   } else {
      // Login failed
	  
      header('Location: ../index.html?error=1');
	  exit();
   }
} else { 
   // The correct POST variables were not sent to this page.
   echo 'Invalid Request';
}
?>