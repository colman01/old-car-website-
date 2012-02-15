<?php
//error files are included by other php-files which do the session check before

$title = "CarLand - Need to Register";
require('layout/pagebegin.php');
?>


<font size="3"><b>Need to Register</b></font>

<p>
Putting your car ad to this website is easy and straight forward, but before you
can do this, you need to <a href="account_register_form.php">register an account</a>.
This is free and takes just a minute.
</p>

<p>
If you already have an account, you should <a href="account_login_form.php">login to
your account</a> in order to put up the ad.
</p>


<?php require('layout/pageend.php');
exit;
?>
