<?php

header('Pragma: no-cache');


require_once('session_check.php');

if ($SID) {
    destroySession();
    $wasLoggedIn = TRUE;
}


//output page begin
$title = "CarLand - Logged out";
require('layout/pagebegin.php');
?>



<?php if ($wasLoggedIn) { ?>

You've been logged out successfully.

<?php } else { ?>

You're not logged in anymore.
If you want to login now, go to the <a href="account_login_form.php">login-page</a>.

<?php } ?>


<?php require('layout/pageend.php'); ?>
