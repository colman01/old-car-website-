<?php
$CARAD_PICS = 'carad_pics';

require_once('session_check.php');
if (! $SID) require('errorpages/not_logged_in.php');

require_once('database_scripts/standard_queries.php');


$carad_id = (int)($_GET['carad_id']);
$carad = getCarad($carad_id);

//if user tries to delete a carad which is not his own
if ($carad['account_id'] != $_SESSION['account_id'])
    require('errorpages/denied.php');


deleteCarad($carad);


header("HTTP/1.1 302 Moved Temporarily");
header("Location: account_home.php?$SID");
?>
