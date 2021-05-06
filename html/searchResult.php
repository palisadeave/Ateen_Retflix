<?php
	include 'check_login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="search.css">    
	<title>Retflix</title>
</head>
<body>
    <div id="root">
        <span class="logo" onclick="location.href='searchWin.php'" style="cursor:pointer">
            Retflix
        </span>
        <span >
            <a href="signout.php">Sign out</a> 
        </span>
        <div id="search-container">
            <label id="search-result"></label>
        </div>
        <div id="result-container" style="cursor:pointer"></div>
    </div>
    <script type="text/javascript">
        var stringToSearch;
        var searchResult = {};
        var count = 0;
        var title = "";
        var netflixid = "";
        var resultContainer = document.getElementById("result-container");
        var searchButton = document.getElementById("searchButton");
        var searchInput = document.getElementById("searchString");
        var searchContainer = document.getElementById("search-container");

        //when this page is loaded, parse the json data
        window.onload = function() {
            //console.log("This is search()");
            searchContainer.style.top = '55px';
            fetch("./SEARCH")
                    .then(response => response.json())
                    .then(json => {
                        //console.log("This is fetch(). and ");
                        var jsonString = JSON.stringify(json);
                        searchResult = JSON.parse(jsonString);
                        //console.log(searchResult);
                        showResults();
                    })
        }

        //this function create and show the list of movie based on the parsed data
        function showResults() {
            //console.log("This is showResults()");
            count = searchResult.total-1;
            while (count >= 0) {
                //console.log("This is while(). count = " + count);
                
                var resultDiv = document.createElement("div");
                var textSpan = document.createElement("span");
                resultDiv.setAttribute("class", "result");

                var imageSpan = document.createElement("span");
                var titleImage = new Image(54, 80);
                titleImage.src = searchResult.results[count].img;
                imageSpan.appendChild(titleImage);
                imageSpan.style.display = "inline-block";
                resultDiv.appendChild(imageSpan);
                
                var titleDiv = document.createElement("div");
                title = searchResult.results[count].title;
                netflixid = searchResult.results[count].nfid;
                titleDiv.innerHTML = title  + " (" + searchResult.results[count].year + ")";
     			//console.log(title);
      			//console.log(netflixid);
                
                titleDiv.setAttribute("id", "result-title");
                resultDiv["title"] = title;
                resultDiv["netflixid"] = netflixid;
                
                textSpan.appendChild(titleDiv);

                var synopsisDiv = document.createElement("div");
                synopsisDiv.innerHTML = searchResult.results[count].synopsis;
                synopsisDiv.setAttribute("id", "result-synopsis");
                textSpan.appendChild(synopsisDiv);

                resultDiv.appendChild(textSpan);
                resultContainer.insertBefore(resultDiv, resultContainer.firstChild);
                
                resultDiv.addEventListener("click", function(event) {
         
                    title = event.currentTarget.title;
                    netflixid = event.currentTarget.netflixid;
                    //alert(title);
                    //alert(netflixid);
                    localStorage.setItem("title", title);
                    localStorage.setItem("netflixid", netflixid);

                    window.location.href = "review.php";

                });
                title = "";
                count--;
            }
            
        }

    </script>
</body>
</html>
