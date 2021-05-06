<?php
	session_start();
	if(!isset($_SESSION["login"])) {
		echo ("Not an authorized user.");
		#echo ($_SESSION["login"]);
		exit;
	}
?>
