<?php
$servername = "localhost";
$username = "bob";
$password = "bobspassword";
$dbname = "personal-website";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$q = json_decode($_POST['data']); 	//decode JSON
	$toSearch = $q -> {'data'}; 		//extract the string 
	$toSearch = strtolower($toSearch);	//all to lowercase
	$toSearch = ucfirst($toSearch);		//first letter uppercase

	//first search according to genre
	if($toSearch == 'Painting' || $toSearch == 'Sculpture' || $toSearch == 'Photography' || $toSearch == 'Film'){
	 	$sql = "SELECT * FROM webimages WHERE genre LIKE '%$toSearch%' LIMIT 5";
	}
	//then search by name 
	else{
		$sql = "SELECT * FROM webimages WHERE name LIKE '%$toSearch%' LIMIT 5";
		$result = $conn->query($sql);

	//if not name results then search by project
		if ($result->num_rows == 0) {
			$sql = "SELECT * FROM webimages WHERE project LIKE '%$toSearch%' LIMIT 5";
		}
	}	
	$result = $conn->query($sql);

	//while there are rows in the database table
	if ($result->num_rows > 0) {
	     // output data of each row
	     while($row = $result->fetch_assoc()) {

			 echo "<p id='".$row['id']."'style='text-align:left; padding-left:10px;padding-right:1;cursor:pointer' onclick='getImageSearched(this)'>".$row["name"]."</p>";
			 	
	     }
	} 

?>