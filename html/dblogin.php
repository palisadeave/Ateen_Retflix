<?php

   session_start(); //start login session

   //check the user input
   $error = 0;
   $userLoginPw = $_POST["userLoginPw"];
   $userLoginId = $_POST["userLoginId"];

	// checks whether inputs are valid
   	if ((strpos($userLoginPw, ';') === false) && (strpos($userLoginPw, '`') === false) && (strpos($userLoginId, ';') === false) && (strpos($userLoginId, '`') === false) ) {
        } else {
		echo "Invalid input";
                echo '<script>alert("Input contains invalid string")</script>';
                echo ("<script>location.href='login.php';</script>");
                exit;

        }


   if (strlen($userLoginPw) > 25)
	$error = 1;
   else if (strlen($userLoginPw) < 4)
	$error = 2;
   else if (strlen($userLoginId) > 25)
	$error = 3;
   else if (strlen($userLoginId) < 4)
	$error = 4;

   if ($error != 0) {
	echo "Invalid length of input:error=" . $error;
	exit;
   }
   //check the user input
	
   //connect to mysql   
   $conn = mysqli_connect(
      "localhost",
      "root",
      "ateen",
      "retflix"
   ) or die ("DB FAILED");
   //connect to mysql

   //Get user input (username, pw) from the previous page(login)
   $LoginPw = mysqli_real_escape_string($conn, $userLoginPw);
   $LoginName = mysqli_real_escape_string($conn, $userLoginId);
   //Get user input (username, pw) from the previous page(login)
   
   //verify that username is a registered username by entering sql query
   $sql = "SELECT username FROM user_web WHERE username='$LoginName';";
   $ret = mysqli_query($conn, $sql);
   if(!$ret){
      echo "failed".mysqli_error($conn);
      mysqli_close($conn);
      echo "Please go back one page.";
      exit;
   }
   $row = mysqli_fetch_array($ret);
   if($row["username"] == null){
      echo $row["username"];
      echo "The username does not exist. ";
      echo "Please go back one page.";
      mysqli_close($conn);
      exit;
      #echo ("<script>location.replace('login.html');</script>");   
   }
   //verify that username is a registered username by entering sql query

   //Verify that the password of the user exists normally
   $sql = "SELECT pw FROM user_web WHERE username = '$LoginName';";
   $ret = mysqli_query($conn, $sql);
   $row = mysqli_fetch_array($ret);
   if($row["pw"] == null){
      #echo "The password does not match. ";
      #echo "Returning to the login page...";
      #echo "<form action='login.html' method='POST'>";
      #echo "<button type='submit' name='button'>return home</button>";
      #echo "Please go back one page.";
      //$_SESSION["login"] = False;
      echo "No stored password for this user.";
      mysqli_close($conn);
      exit;
      #echo ("<script>location.replace('login.html');</script>");
   }
   //Verify that the password of the user exists normally

   // initialize $returnValue
   $returnValue = -1;
   // give plain password from user input and one-way hashed password from DB as arguments and run signin. 
   // when command succeeds shell_exec() returns what is printed. when it fails null will be returned. However, null could also indicate that command was executed without failure but nothing was printed. 
   // arguments are plain password and hashed password

	// escape invalid strings that might have not been filtered out yet 
	$argInputPw = escapeshellarg($LoginPw);
	$escaped_command = escapeshellcmd('./signin/signin '.$argInputPw);
	if (strlen($escaped_command) != strlen('./signin/signin '.$argInputPw)) {
		echo '<script>alert("Input contains invalid string")</script>';
                echo ("<script>location.href='login.php';</script>");
                exit;
	
	}
	$returnValue = shell_exec($escaped_command.' \''.$row["pw"].'\'');
   // if 0 is returned from signin the password input matches the hashed value in DB. 
   if ($returnValue === '0') {
      // Login follows
      echo "login success";
      $_SESSION["user_id"] = $LoginName;
             #$_SESSION["user_pw"] = $LoginPw;
      $_SESSION["login"] = True;
           mysqli_close($conn);
           echo ("<script>location.replace('searchWin.php');</script>");

   } elseif ($returnValue == 1) { // return value 1 indicates that verifying has failed. in this case echoes error message, close connection, and exits
      echo "Password does NOT match. ";
      mysqli_close($conn);
      exit;
   } elseif ($returnValue == 2) { // return value 2 indicates that hashing function in executable has failed 
      echo "Hashing function has failed. ";
      mysqli_close($conn);
                exit;
   } elseif (is_null($returnValue)) { // null is returned when permission is denied
      echo "Permission denied";
      mysqli_close($conn);
                exit;
   } else { // anything other than the mentioned aboves mean failure in command
      echo "shell_exec() has failed";
      mysqli_close($conn);
      exit;
   }
?>
