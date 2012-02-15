<?php
//error files are included by other php-files which do the session check before

$title = "CarLand - page template";
require('layout/pagebegin.php');
?>


<font size="3"><b>Already Logged In</b></font>

<p>
You're already logged in and you can't login with two accounts at the same time.
</p>

<p>
You can go to your <a href="account_home.php?<?=$SID?>">Account Area</a> and use the
current account, or you can <a href="account_logout_action.php?<?=$SID?>">click here to
logout now</a> and then login with another account.
</p>


<?php require('layout/pageend.php');
exit;
?>
