<?php
	include 'check_login.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="dbread.css" rel="stylesheet">
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
	<div id="reviews_container">
		<article class="reviewArticle">
			<h3 style="font-size: 50px;">Reviews</h3>
			<table border = "1" width = "300">
				<thead>
				  <tr>
				    <th style="font-size : 15pt; width: 15%; word-wrap: break-word;" scope="col" class="user">USER</th>
            		<th style="font-size : 15pt; width : 50%;word-wrap: break-word;" scope="col" class="content">CONTENT</th>
					<th style="font-size : 15pt; width : 10%; word-wrap: break-word;" scope="col" class="stars">SCORE</th>
				  </tr>
				</thead>
				<tbody>
				<?php
					//connect to mysql
					$conn = mysqli_connect(
					"localhost",
					"root",
					"ateen",
					"retflix"
					) or die ("DB FAILED");
					
					//Get title/netflixid from the previous page(review.php)				
					$title = mysqli_real_escape_string($conn, $_POST["title_php_read"]);	
					$netflixid = mysqli_real_escape_string($conn, $_POST["netid_php_read"]);
					
					echo "<font size = 8pt>".htmlspecialchars($title)."<br></font>"; //Display the title of the movie
					
					//get average rating of the movie from DB table(movie)
					$sql = "select avg_rating from movie where id = ".$netflixid.";";
					$result = mysqli_query($conn, $sql);
					if(!$result){
						echo "failed ".mysqli_error($conn);
						mysqli_close($conn);
						exit;
					}
					$row = mysqli_fetch_assoc($result);

					
					//the select result is null. there's no existing reviews for this movie.					
					if($row['avg_rating'] == null){
						echo "There's no review yet. Write review and become the first review writer!";
					}					
					else{
						echo "Average rating : ".$row['avg_rating']; //Print average rating
					}

					//get review_id, review, user_id, stars from DB table(reviews)
					$sql = "select review_id, review, user_id, stars from reviews where id = ".$netflixid.";";
					$result = mysqli_query($conn, $sql);
					if(!$result){
						echo "failed ".mysqli_error($conn);
						mysqli_close($conn);
						exit;
					}
					
					//print review_id, review, user_id, stars on a table of the page
					while($row = mysqli_fetch_assoc($result)){
						//get username by searching user_id
						$sql2 = "select username as uname from user_web where user_id=".$row['user_id'].";";
						$result2 = mysqli_query($conn, $sql2);
						$row2 = mysqli_fetch_assoc($result2);
						$username = $row2['uname'];
						?>
					<tr>
						<td class="user"><?php echo htmlspecialchars($username)?></td>
						<td style="word-wrap:break-word" class="content"><?php echo htmlspecialchars($row['review'])?> </td>
						<td class = "stars">
						<?php 
							$i=0;
							while($i < $row['stars']){
								echo "★"; //print stars
							$i=$i+1;}?>
							</td>
                    
					</tr>

					<?php 
						}
							mysqli_close($conn); ?>

				</tbody>
			</table>
		</article>
	</div>
</div>
</body>
</html>
