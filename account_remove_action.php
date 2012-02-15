<?php
$CARAD_PICS = 'carad_pics';

require_once('session_check.php');
if (! $SID) require('errorpages/not_logged_in.php');

require_once('database_scripts/standard_queries.php');
$account   = getAccount($_SESSION['account_id']);
$caradList = getCaradsOfAccount($account['account_id']);


foreach ($caradList as $carad) {
    deleteCarad($carad);
}


$query = "DELETE FROM accounts WHERE account_id=".$account['account_id'];
$result = mysql_query($query, $conn);
if (! $result)
    die ("database error. couldn't remove account from database: ".mysql_error());


destroySession();


$title = "CarLand - Account Removed";
require('layout/pagebegin.php');
?>

Your account has been removed.

<?php require('layout/pageend.php'); ?>
