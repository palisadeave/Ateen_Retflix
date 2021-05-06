<?php
	include 'check_login.php';
	$usrid = $_SESSION["user_id"]; // Get user_id from the login session

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="review.css" rel="stylesheet"> 
    <script type="text/javascript" src="jquery-3.6.0.js"></script>
	<title>Retflix</title>
</head>
<body>
    <div id="root">
        <span class="logo" onclick="location.href='searchWin.php'" style="cursor:pointer">
            Retflix
        </span>
	<span>
            <a href="signout.php" style="cursor:pointer">Sign out</a>
        </span>	
        <div id="reviews-container">
			<th scope="row"></th>
			<td><div class="stars">
					<span class="star on">star1</span> <span class="star on">star2</span>
					<span class="star on">star3</span> <span class="star off">star4</span>
					<span class="star off">star5</span>
			</div></td>   
            <div id="newReview-container">
                <input type="text" id="review-field" placeholder="How did you like the movie?">                
				<form name = "Form" method = "Post" action="dbwrite.php"> <!--A form to post datas to dbwrite.php when the Post button is clicked-->
					<button id='post-button' type = "submit" onclick="postclicked()" style="cursor:pointer;">Post</button>
					<input type="hidden" id="star_php" name="star_php">
					<input type="hidden" id="review_php" name="review_php">
					<input type="hidden" id="title_php" name="title_php">
					<input type="hidden" id="netid_php" name="netid_php">
					<input type="hidden" id="userid_php" name="userid_php" value="<?php echo $usrid; ?>">
				</form>
				<form name = "Form2" method = "Post" action="dbread.php">  =<!--A form to post datas to dbwrite.php when the Post button is clicked-->
					<button id='read-button' style="cursor:pointer" type="submit" onclick="readclicked()">Read reviews</button>
					<input type="hidden" id="title_php_read" name="title_php_read">
					<input type="hidden" id="netid_php_read" name="netid_php_read">	
				</form>
            </div>
        </div>
    </div>
	
    <script>
		//get title, netflixid from the previous page(searchResult.php)
		var title = localStorage.getItem("title"); 
		var netflixid = localStorage.getItem("netflixid");
		//get title, netflixid from the previous page(searchResult.php)

		//rvStar : the number of stars / reviewText : the review that user wrote 
		var rvStar = document.createElement("input");
		var reviewText = document.getElementById("review-field");

		//calculate the number of stars that user gave
		rvStar.type = "hidden";
		rvStar.name = "rvStar";
		rvStar.value = $('.star.on').length;
		$('.stars span').click(function() {
			$(this).parent().children('span').removeClass('on');
			$(this).addClass('on').prevAll('span').addClass('on');
			rvStar.value = $('.star.on').length;
		});
		//calculate the number of stars that user gave

		//function that runs when "Post" button is clicked
		function postclicked(){
			//Assign variables to pass to dbwrite.php
			document.getElementById('star_php').value = rvStar.value;
			document.getElementById('review_php').value = reviewText.value;
			document.getElementById('title_php').value = title;
			document.getElementById('netid_php').value = netflixid;

		}
		//function that runs when "Read reviews" button is clicked
		function readclicked(){
			//Assign variables to pass to dbread.php
			document.getElementById('title_php_read').value = title;
			document.getElementById('netid_php_read').value = netflixid;
		}


		
    </script>

</body>
</html>
