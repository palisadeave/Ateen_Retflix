<?php
	include 'check_login.php';

    //get user input from searchWin.php and make URL for restAPI
	$searchString = $_POST["movie_php"];

	if ((strpos($searchString, ';') === false) && (strpos($searchString, '`') === false)) {
	} else {
                echo '<script>alert("Entered search keyword contains invalid string")</script>';
		echo ("<script>location.href='searchWin.php';</script>");
                exit;
		
        }



	$query = shell_exec("./api_req \"$searchString\"");


	echo "query is \n";
	print_r($query);

    //start cURL request to restAPI
	$curl = curl_init();

	curl_setopt_array($curl, [
        CURLOPT_URL => $query,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: unogsng.p.rapidapi.com",
            "x-rapidapi-key: c84d0d4f12mshfd3aef6215c4f30p1db145jsn5312b6966b63"
        ],
	]);
    
    //send request
	$response = curl_exec($curl);
	$err = curl_error($curl);

	if ($err) {
		$curl_data = NULL;
		echo "cURL Error #:".$err;
		curl_close($curl);
	} else {
		$curl_data = $response;
		curl_close($curl);

        //start to write json data to file
		$filename = "searchResult.json";
		$fp = fopen($filename, "w") or die("Unable to open file!");
		$arr_data = json_decode($curl_data, true);
		$json_data = json_encode($arr_data);
		$bytes = file_put_contents($filename, $json_data);

		echo $bytes;
		echo "done";

        //move to next web page
		echo ("<script>location.href='searchResult.php';</script>");  
	}
?>
