<?php

header('Pragma: no-cache');


require_once('session_check.php');
require_once('layout/showCaradShort.php');
if (! $SID) require('errorpages/not_logged_in.php');


require_once('database_scripts/standard_queries.php');

$account   = getAccount($_SESSION['account_id']);
$caradList = getCaradsOfAccount($account['account_id']);

$title = "CarLand - My CarLand, the market place for used cars";
require('layout/pagebegin.php');
?>

Hello <?=$account['firstname']?> <?=$account['lastname']?>!<br/>

<p>
To submit a new car ad, click on <a href="carad_submit_form.php?<?=$SID?>">
Advertise Car Online</a>. You can also find this link in the upper left menu.
</p>


<?php foreach ($caradList as $carad) { showCaradShort($carad); } ?>


<?php require('layout/pageend.php'); ?>
