<?php
	include 'check_login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="search.css" rel="stylesheet"/>
	<title>Retflix</title>  
</head>
<body>
   <div id="root">
        <span class="logo" onclick="location.href='searchWin.php'" style="cursor:pointer">
            Retflix
        </span>
	<span >
            <a href="signout.php" style="cursor:pointer">Sign out</a>
        </span>
        <div id="search-container">
            <span>
				<form method = "Post" action="search.php">
                	<input type="text" class="search-field" name="movie_php" id="searchString" style="padding-left: 15px">
                	<button class="search-button" type="submit" id="searchButton" style="cursor:pointer">Search</button>
            	</form>
			</span>            
        </div>
        <div id="result-container">
	</div>  
    </div>
</body>
</html>
