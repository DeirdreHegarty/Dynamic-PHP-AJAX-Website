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
	$q = json_decode($_POST['hiddeninput']); 	//decode JSON
	$toSearch = $q -> {'data'}; 				//extract the string 
	$toSearch = strtolower($toSearch);			//all to lowercase
	$toSearch = ucfirst($toSearch);				//first letter uppercase

	
	$sql = "SELECT * FROM webimages WHERE id = $toSearch";
	$temp ='';
	$result = $conn->query($sql);

	//while there are rows in the database table
	if ($result->num_rows > 0) {
	     // output data of each row

	     while($row = $result->fetch_assoc()) {

			 echo "<img style='height:300px; overflow:hidden; object-fit: cover; margin-top:5%; border-radius:4px;' class='col-md-3' src='".$row["address"]."'>";
			 $temp = "<h1>".$row["genre"]."</h1>";
			 echo $temp;

	     }
	} 

	//now that have info about searcehd image

?>