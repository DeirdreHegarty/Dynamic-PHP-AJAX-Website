<?php
echo '<!DOCTYPE>
<html>
<head>
	<title>Deirdre Hegarty</title>
	<meta charset="UTF-8">
	<!--  NOTE TO SELF: jQuery needs to be before Bootstrap -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	

	<link rel="stylesheet" type="text/css" href="personal-website.css">
	<script type="text/javascript" src="personal-website.js"></script>
</head>
<body id="body">
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<!-- <div class="navbar-header"> -->
			<a class="navbar-brand" href="Personal-Website.html">
				<img id="logo" alt="DH" src="logo/DH2.png">
			</a>
			<!-- </div> -->

			<div class="navbar-form navbar-right dropdown" style="margin-right:5%;" autocomplete="off">
				<!-- <form> -->
				<div class="form-group" data-toggle="dropdown">
					<input type="text" class="form-control" placeholder="Search" id="inbox" onkeyup="suggestImages()" style="width:300px;float:left" autocomplete="off">
				</div>
				
				<button id="b1" type="submit" form="hiddenform" class="btn btn-default" style="height:50px;margin-top:10px;padding-left:20px; padding-right:20px">Submit</button><br/>
				<div style="width:420px; padding-left:10px;"class="dropdown-menu"id="testdiv">...<div>
				<!-- </form> -->
				
			</div>
		</div>
		<div id="imagediv"></div>
		<form style="display:none;" id="hiddenform" name="hiddenform" action="viewgallery.php" method="post">
			<input id="hiddeninput" name="hiddeninput">
		</form>
	</nav>

	<div id="container-one"class="container-fluid">
		<div class="row">';


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
	$temp ='';
	if(is_numeric($toSearch)){

		$sql = "SELECT * FROM webimages WHERE id = $toSearch";
		$temp ='';
		$result = $conn->query($sql);


		//while there are rows in the database table
		if ($result->num_rows > 0) {
		     // output data of each row

		     while($row = $result->fetch_assoc()) {

				 echo "<div class='col-md-6'><img class='col-md-offset-2 col-md-10 mainImage' src='".$row["address"]."'></div>";
				 $temp = $row["genre"];
				 echo "<div class='col-md-6'>";
				 echo "<h3>".$row["name"]."</h3>";
				 echo "<p>PROJECT: ".$row["project"]."</p>";
				 echo "<p>CATEGORY: ".$row["genre"]."</p>";
				 echo "<p>".$row["description"]."</p>";
				 echo "</div>";
				 echo '</div>'; //end of row

		     }
		} 

		//now that have info about searched image
		//not that have the image searched, get all relating to same genre

		$sql = "SELECT * FROM webimages WHERE genre = '$temp' AND id != $toSearch";
		$result = $conn->query($sql);
		// echo $sql;
		
		//while there are rows in the database table
		if ($result->num_rows > 0) {
		     // output data of each row
			echo "<div id='previewImageContainer' style='height:350px;overflow:auto'class='row'>";
		     while($row = $result->fetch_assoc()) {
				 echo "<img class='galleryimages' src='".$row["address"]."'>";
		     }
		     echo "</div>";
		 }
		 echo '</div></div></body>';
	}else{


		$sql = "SELECT * FROM webimages WHERE name LIKE '%$toSearch%'";

		$result = $conn->query($sql);


		//while there are rows in the database table
		if ($result->num_rows > 0) {
		     // output data of each row

		     while($row = $result->fetch_assoc()) {
		     	 $temp = $row["genre"];
			     echo "<div class='row'><div class='col-md-12'>";
				 echo "<div class='col-md-6'><img class='col-md-offset-2 col-md-10 mainImage' src='".$row["address"]."'></div>";
				 echo "<div class='col-md-6'>";
				 echo "<h3>".$row["name"]."</h3>";
				 echo "<p>PROJECT: ".$row["project"]."</p>";
				 echo "<p>CATEGORY: ".$row["genre"]."</p>";
				 echo "<p>".$row["description"]."</p>";
				 echo '</div>';
				 echo '</div></div>';


		     }
		} 

	//now that have info about searched image
		//not that have the image searched, get all relating to same genre

		$sql = "SELECT * FROM webimages WHERE genre = '$temp'";
		$result = $conn->query($sql);
		// echo $sql;
		
		//while there are rows in the database table
		if ($result->num_rows > 0) {
		     // output data of each row
			echo "<div id='previewImageContainer' style='height:350px;overflow:auto'class='row'>";
		     while($row = $result->fetch_assoc()) {
				 echo "<img class='galleryimages' src='".$row["address"]."'>";
		     }
		     echo "</div>";
		 }
		 echo '</div></div></body>';

	}
?>



