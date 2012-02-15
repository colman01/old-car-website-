<?php
//error files are included by other php-files which do the session check before

$title = "CarLand - page template";
require('layout/pagebegin.php');
?>


<font size="3"><b>Already Registered</b></font>

<p>
You're already logged in with a registered account. You can't register a new
account while being logged in with another one.<br />
You can go to your <a href="account_home.php?<?=$SID?>">Account Area</a> and use the
current account, or you can <a href="account_logout_action.php?<?=$SID?>">click here to
logout now</a> and register a new account.
</p>


<?php require('layout/pageend.php');
exit;
?>
