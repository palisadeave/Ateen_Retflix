<?php
	//connect to mysql
	$conn = mysqli_connect(
		"localhost",
		"root",
		"ateen",
		"retflix"
	) or die ("DB FAILED");
	
	//Get signupName/pw from the previous page(join.html).
	$SignupPw = $_POST["userSignupPw"];
	$SignupName = $_POST["userSignupId"];

	
		
	// search the name user entered from DB to know it's duplicated or not.
	$sql = "SELECT username from user_web where username='$SignupName';";
	$res = mysqli_multi_query($conn, $sql);
	$ret = mysqli_store_result($conn);
	if(!$ret){
		echo "failed".mysqli_error($conn);
		mysqli_close($conn);
		exit;
	}

	
	//Username Duplication check
	$row = mysqli_fetch_array($ret);
	mysqli_free_result($ret);
	if($row['username'] != null){
		echo "Duplicated ID! ";
		mysqli_close($conn);
		exit;
	}


	//Get max-user_id number to give user identification number.
	$sql1 = "SELECT MAX(user_id) as max from user_web;";
	$ret1 = mysqli_query($conn, $sql1);
	if(!$ret1){
		echo "failed ".mysqli_error($conn);
		mysqli_close($conn);
		exit;
	}	
	$maxarr = mysqli_fetch_array($ret1);
	$user_id = $maxarr['max'] + 1; //The user-id number increases as users join recently.

	
	// initialize $hashedPW. 
	// if return value of exec() is not properly stored in $hashedPW, $hashedPW will have this value.
	$hashedPW = "This is initial value";
	// execute register with user's plain password input($SignupPw) as an argument. 
		// return status is stored in $returnStat.
		// every line of output will be stored in array $hashedPW.
	exec('./register/register '.$SignupPw, $hashedPW, $returnStat);

	// if $returnStat is '0'command above has been successfully executed. 
	if ($returnStat === 0) {
		// bcrpyt returns hashed value of 60 char length 
		if (strlen($hashedPW[0]) == 60) {
			echo "Hashing completed";
		}

	} 
	else { // command returned error code
		// echo corresponding string for each exit code. only important 
		if ($returnStat === 139) {
			echo "Segmentation fault";
			
		} elseif ($returnStat === 134) {
			echo "Segmentation fault";
            
		} elseif ($returnStat === 136) {
			echo "Erroneous Arithmetic Operation";
			
		} elseif ($returnStat === 255) {
			echo "Program Timed Out";
		}
		mysqli_close($conn);
		exit;
			
	}

	// doublecheck hashed value is appropriate
	if (strlen($hashedPW[0]) < 60) {
		echo "Hashing has encountered an error and the password has not been fully hashed";
		mysqli_close($conn);
		exit;
	}

	$sql2 = "INSERT INTO user_web VALUES('$SignupName', '$hashedPW[0]', ".$user_id.");";
	$ret2 = mysqli_query($conn, $sql2);
	if(!$ret2){
		echo "failed ".mysqli_error($conn);
		mysqli_close($conn);
		exit;
	}
	echo "Sign-up Completed!";
	mysqli_close($conn);
	echo ("<script> location.replace('login.php');</script>");	
?>
