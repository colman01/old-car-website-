<?php
require_once('mmm_datafiles.php');
$email  = getFileContent($FILENAME_CONTACT_EMAIL );

$paramList = array(
 'firstname'  ,
 'lastname'   ,
 'email'      ,
 'phone'      ,
 'description'
);




//extract parameters to be global variables
foreach ($paramList as $param)
    $GLOBALS[$param] = $_POST[$param];


$to      = "$email";
$subject = 'New Car entry';
$message =
 "$email\n".
 "$firstname\n".
 "$lastname\n".
 "$description\n" 
;
$headers = 'From: carLand' . "\r\n" .
   'Reply-To: mrneilbrady@hotmail.com' . "\r\n" .
   'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);


$title = "CarLand - Template";
require('layout/pagebegin.php');
?> 

Your Details have been submitted.

<?php require('layout/pageend.php'); ?>
