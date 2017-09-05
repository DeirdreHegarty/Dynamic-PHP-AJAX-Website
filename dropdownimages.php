
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

	//search according to genre

	$sql = "SELECT * FROM webimages WHERE genre LIKE '%$toSearch%' LIMIT 6";
		
	$result = $conn->query($sql);

	//while there are rows in the database table
	if ($result->num_rows > 0) {
	     // output data of each row
	     while($row = $result->fetch_assoc()) {


			 echo '<div class="col-md-4 col-sm-4">
						<img class="previewimages" src="' .$row['thumbs']. '">
						<h1>hello</h1>
					</div>';
			 	
	     }
	} 

?>