<?php

   session_start(); //start login session
   //connect to mysql   
   $conn = mysqli_connect(
      "localhost",
      "root",
      "ateen",
      "retflix"
   ) or die ("DB FAILED");
   //connect to mysql

   //Get user input (username, pw) from the previous page(login)
   $LoginPw = mysqli_real_escape_string($conn, $_POST["userLoginPw"]);
   $LoginName = mysqli_real_escape_string($conn, $_POST["userLoginId"]);
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
   $returnValue = shell_exec('./signin/signin '.$LoginPw.' \''.$row["pw"].'\'');
   
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
