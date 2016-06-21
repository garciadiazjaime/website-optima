<?php
$msg = "";
$dest = "jaime@mintitmedia.com"; //info@jt.com";
$from = isset($_POST['email']) ? $_POST['email'] : 'noreply@optima.com';
$subject = 'Contacto Optima';
$headers = 	
	'MIME-Version: 1.0' . "\r\n".
	'Content-type: text/html; charset=iso-8859-1' . "\r\n".
	'From: '.$from." \r\n" .
	'Reply-To: '. $from . "\r\n" .
	'X-Mailer: PHP/' . phpversion();
if(strpos($_SERVER[HTTP_REFERER],'contact') !== FALSE){
	foreach($_POST as $key => $row){
		$msg .= $key.": ".$row."<br />";
	}
	if( mail($dest, $subject, $msg, $headers) )
    	echo 'TRUE';
    else
    	echo 'FALSE';
}
?>


