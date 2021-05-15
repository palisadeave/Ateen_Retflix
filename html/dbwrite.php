<?php
	//connect to mysql
	include 'check_login.php';	
	$conn = mysqli_connect(
	"localhost",
	"root",
	"ateen",
	"retflix"
	) or die ("DB FAILED");
	
	//Load the variables from the previous page(review.php)
	$star = $_POST["star_php"];
	$review = mysqli_real_escape_string($conn, $_POST["review_php"]);
	$title = mysqli_real_escape_string($conn, $_POST["title_php"]);
	$username =  mysqli_real_escape_string($conn, $_POST["userid_php"]);
	$netflixid = mysqli_real_escape_string($conn, $_POST["netid_php"]);

	
	//use sql query to find user_id
	$sql = "SELECT user_id FROM user_web where username = '$username';";
	$ret = mysqli_query($conn, $sql);
	if(!$ret)
	{
		echo "failed ".mysqli_error($conn);
		mysqli_close($conn);
		exit;
	}
	$row = mysqli_fetch_array($ret);
	$userid = $row['user_id'];

	
	//use sql query to get review_id that would be assigned to this review
	$sql1 = "SELECT MAX(review_id) as max from reviews;";
	$ret1 = mysqli_query($conn, $sql1);
	if(!$ret1)
	{
		echo "failed ".mysqli_error($conn);
		mysqli_close($conn);
		exit;
	}
	$resultarr = mysqli_fetch_array($ret1);
	$review_id = $resultarr['max'] + 1; //The review id increases with the latest, it is max+1

	
	//sql query to find the movie DB
	$sql = "SELECT id from movie where id=".$netflixid.";";
	$ret = mysqli_query($conn, $sql);
	if(!$ret)
	{
		echo "failed ".mysqli_error($conn);
		mysqli_close($conn);
		exit;
	}
	$row = mysqli_fetch_array($ret);
	if($row['id'] == null){ //It is the first time to be writed a review of this movie
		//Insert datas about the movie into the table "movie".
		$sql = "INSERT INTO movie VALUES (".$netflixid.", '$title', ".$star.", 'nul', 'nul', 1990);";
		$ret = mysqli_query($conn, $sql);
		if(!$ret){
			echo "failed to insert movie".mysqli_error($conn);
			mysqli_close($conn);
			exit;
		}
	}

	//Insert datas about the review into the table "reviews".
	$sql = "INSERT INTO reviews VALUES (".$review_id.", ".$userid.", ".$netflixid.", ".$star.", '$review', 0, 0);";
		//updates the average rating of the movie
		$updatesql = "UPDATE movie SET movie.avg_rating = (SELECT avg(stars) from reviews where reviews.id = movie.id group by id);";
	$ret = mysqli_query($conn, $sql);
	if(!$ret)
	{
		echo "failed".mysqli_error($conn);
		mysqli_close($conn);
		exit;
	}
	$ret2 = mysqli_query($conn, $updatesql);
	if(!$ret2)
	{
		echo "failed".mysqli_error($conn);
		mysqli_close($conn);
		exit;
	}
	mysqli_close($conn); //close connection
	echo ("<script> alert(\"The review has been saved\"); </script>");
	echo ("<script> location.replace('review.php');</script>");
?>
