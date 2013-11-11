<?php
function sec_session_start() {
        $session_name = 'regulus_aldebaran_fucher'; // Set a custom session name
        $secure = false; // Set to true if using https.
        $httponly = true; // This stops javascript being able to access the session id. 
 
        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name); // Sets the session name to the one set above.
        session_start(); // Start the php session
        session_regenerate_id(true); // regenerated the session, delete the old one.     
}


function login($login, $password, $mysql_con) {
   // Using prepared Statements means that SQL injection is not possible. 
   if ($stmt = $mysql_con->prepare("SELECT id, name, password FROM reg_user WHERE username = ? LIMIT 1")) { 
      $stmt->bind_param("s", $login); // Bind "$email" to parameter.
      $stmt->execute(); // Execute the prepared query.
      $stmt->store_result();
      $stmt->bind_result($user_id, $name, $db_password); // get variables from result.
      $stmt->fetch();
      //$password = hash('sha512', $password.$salt); // hash the password with the unique salt.
      if($stmt->num_rows == 1) { // If the user exists
         // We check if the account is locked from too many login attempts
         /*if(checkbrute($user_id, $mongo_con) == true) { 
            // Account is locked
            // Send an email to user saying their account is locked
            return false;
         } else {*/
         if($db_password == $password) { // Check if the password in the database matches the password the user submitted. 
            // Password is correct!
 
 
               $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
 
               $user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
               $_SESSION['user_id'] = $user_id; 
               $name = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $name); // XSS protection as we might print this value
               $_SESSION['username'] = $name;
               $_SESSION['login_string'] = hash('sha512', $password.$user_browser);
               // Login successful.
               return true;    
         } else {
            // Password is not correct
            // We record this attempt in the database
            $now = time();
            //$mongo_con->query("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
            return false;
         }
      //}
      } else {
         // No user exists. 
         return false;
      }
      } else{
      //echo "teste";
//      echo mysqli_error($mysql_con);
      echo mysql_errno($mysql_con) . ": " . mysql_error($mysql_con). "\n";
   }

function checkbrute($user_id, $mysql_con) {
   // Get timestamp of current time
   $now = time();
   // All login attempts are counted from the past 2 hours. 
   $valid_attempts = $now - (2 * 60 * 60); 
 
   if ($stmt = $mysql_con->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) { 
      $stmt->bind_param('i', $user_id); 
      // Execute the prepared query.
      $stmt->execute();
      $stmt->store_result();
      // If there has been more than 5 failed logins
      if($stmt->num_rows > 5) {
         return true;
      } else {
         return false;
      }
   }
}

}

function login_check($mysql_con) {
   // Check if all session variables are set
   if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
     $user_id = $_SESSION['user_id'];
     $login_string = $_SESSION['login_string'];
     $username = $_SESSION['username'];
 
     $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
 
 if ($stmt = $mysql_con->prepare("SELECT password FROM reg_user WHERE id = ? LIMIT 1")) { 
      $stmt->bind_param("i", $user_id ); // Bind "$email" to parameter.
      $stmt->execute(); // Execute the prepared query.
      $stmt->store_result();

	if($stmt->num_rows == 1) {  // If the user exists
	   $stmt->bind_result($password); // get variables from result.
	   $stmt->fetch();
	   $login_check = hash('sha512', $password.$user_browser);
	   //$login_check = $user_browser;
	   if($login_check == $login_string) {
		  // Logged In!!!!
		  return true;
	   } else {
		  // Not logged in
		  return false;
	   }
	} else {
		// Not logged in
		return false;
	}

   } else {
     // Not logged in
     return false;
   }
 }
}

function logout(){
  sec_session_start();
  // Unset all session values
  $_SESSION = array();
  // get session parameters 
  $params = session_get_cookie_params();
  // Delete the actual cookie.
  setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
  // Destroy session
  session_destroy();
  header('Location: ./index.html');
}

function redirLogin($page){
  header('Location: ./index.html?redir=' . $page);
}

function menu(){
echo '	<nav>';
echo '		<ul>';
echo '			<li>';
echo '        <a href=".\index.php">Home</a>';
echo '        <ul>';
echo '          <li><a href="logout.php">Logout</a></li>';
echo '        </ul>';
echo '      </li>';
echo '			<li>';
echo '				<a>Cadastro</a>';
echo '				<ul>';
echo '					<li>';
echo '						<a href="brwForn.php"> Fornecedor </a>';
echo '						<ul>';
echo '							<li>';
echo '								<a href="cadForn.php">Inclusão</a>';
echo '								<a href="brwForn.php">Manutenção</a>';
echo '							</li>';
echo '						</ul>';
echo '         </li>';
echo '         <li>';
echo '            <a href="brwBanc.php"> Dados Bancarios </a>';
echo '            <ul>';
echo '              <li>';
echo '                <a href="cadBanc.php">Inclusão</a>';
echo '                <a href="brwBanc.php">Manutenção</a>';
echo '              </li>';
echo '            </ul>';
echo '					</li>';
echo '				</ul>';
echo '			</li>';
echo '			<li>';
echo '				<a>Contas a Pagar</a>';
echo '				<ul>';
echo '					<li>';
echo '						<a href="REGCAP001.php">Inclusão</a>';
echo '						<a href="brwCAP.php">Manutenção</a>';
echo '					</li>';
echo '				</ul>';
echo '			</li>';
echo '			<li>';
echo '				<a>Relatórios</a>';
echo '				<ul>';
echo '					<li>';
//echo '						<a href="javascript:abreRel(';
//echo "'./php/REGCAPR002.php'";
echo '						<a href="REGCAPR011.php?report=REGCAPR002">Contas a Pagar</a>';
//echo ')";> Contas a Pagar </a>';
echo '						<a href="javascript:abreRel(';
echo "'./php/REGCAPR003.php'";
echo ')"; taget="new"> Contas vencidas </a>';
echo '						<a href="javascript:abreRel(';
echo "'./php/REGCAPR001.php'";
echo ')"; taget="new"> Contas pagas </a>';
echo '					</li>';
echo '				</ul>';
echo '			</li>';
echo '		</ul>';
echo '	</nav>';

return true;
}




?>