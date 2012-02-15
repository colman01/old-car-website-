<?php
require_once('session_check.php');
if (! $SID) require('errorpages/not_logged_in.php');


require_once('database_scripts/standard_queries.php');

$account    = getAccount($_SESSION['account_id']);
$caradCount = getCaradCountOfAccount($account['account_id']);

$title = "CarLand - Confirm Account Removal";
require('layout/pagebegin.php');
?>


<p>
Account to be removed:<br />
Email: <?=$account['email']?><br />
Name: <?=$account['firstname']?> <?=$account['lastname']?><br />
</p>

<?php if ($caradCount > 0) { ?>
</p>
<font size="3">
There are <a href="account_home.php?<?=$SID?>"><?=$caradCount?> carad(s)</a> in
this account, which will also be removed if you click 'Yes'.
</font>
</p>
<?php } ?>

<p>
Are you sure you want to remove this account?<br />
You won't be able to log in afterwards with this username.
</p>

&nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;
<form method="get" action="account_details_view.php" style="display: inline;">
  <input type="hidden" name="<?=session_name()?>" value="<?=session_id()?>" />
  <input type="submit" value="No" />
</form>
&nbsp;
&nbsp;
&nbsp;
<form method="get" action="account_remove_action.php" style="display: inline;">
  <input type="hidden" name="<?=session_name()?>" value="<?=session_id()?>" />
  <input type="submit" value="Yes" />
</form>

&nbsp;<br />&nbsp;<br />&nbsp;<br />

<?php showCaradShort($carad); ?>

<?php require('layout/pageend.php'); ?>
