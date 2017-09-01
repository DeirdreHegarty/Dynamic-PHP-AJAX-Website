<?php
	//sending email from contact form
	$q = json_decode($_POST['data']);


	$to = "test@test.com";
	$subject = $q[0];
	$message = $q[2];
	$headers = 'From: '. $q[1] . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);

?>