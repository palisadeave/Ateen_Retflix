<?php 
	session_start(); 
	session_unset();
        session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <link rel="stylesheet" href="login.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Retflix</title>
	</head>

	<body>
        <span class="logo" onclick="location.href='login.php'" style="cursor:pointer">
        	Retflix
        </span>
        <div class="login-body"> 
            <div class="login-form">
                <div class="login-form-main">
                    <h1 data-uia="login-page-title">LogIn</h1>
                    <form action="dblogin.php" method="Post">  
                        <div class="login-field-container">
                            <div class="nfInputPlacement">
                                <div class="nfInputControl">
                                    <input 
                                        type="text" 
                                        name="userLoginId" 
                                        class="nfTextField" 
                                        id="userLoginId" 
                                        placeholder="your id"
                                        minlength="4" 
                                        maxlength="25">
                                </div>
                            </div>
                        </div>
                        <div class="login-field-container">
                            <div class="nfInputPlacement">
                                <div class="nfInputControl">
                                    <input 
                                        type="password"
                                        name="userLoginPw" 
                                        class="nfTextField"
                                        id="userLoginPw" 
                                        placeholder="your password"
                                        minlength="4"
                                        maxlength="25">
                                </div>
                            </div>
                        </div>
                        <button class="login-button" type="submit">Log in</button>
                    </form>
                </div>
                <div class="login-form-other">
                    <button class="signup-button" onclick="location.href='join.html'; return false;">Sign up</button>
                </div>
            </div>
        </div>
	</body>  
</html>



