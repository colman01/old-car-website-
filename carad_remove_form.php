<?php
require_once('session_check.php');
require_once('layout/showCaradShort.php');

$carad_id = (int)($_GET['carad_id']);

require_once('database_scripts/standard_queries.php');
$carad    = getCarad($carad_id);

$title = "CarLand - Confirm Carad Removal";
require('layout/pagebegin.php');
?>


<?php showCaradShort($carad); ?>

&nbsp;<br />

<center>
<font size="3">Are you sure you want to remove this ad?</font><br />
&nbsp;<br />

<form method="get" action="account_home.php" style="display: inline;">
  <input type="hidden" name="<?=session_name()?>" value="<?=session_id()?>" />
  <input type="submit" value="No" />
</form>
&nbsp;
&nbsp;
&nbsp;
<form method="get" action="carad_remove_action.php" style="display: inline;">
  <input type="hidden" name="<?=session_name()?>" value="<?=session_id()?>" />
  <input type="hidden" name="carad_id" value="<?=$carad_id?>" />
  <input type="submit" value="Yes" />
</form>
</center>

&nbsp;<br />
&nbsp;<br />
&nbsp;<br />

<?php require('layout/pageend.php'); ?>
