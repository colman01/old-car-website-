<?php
//error files are included by other php-files which do the session check before

$title = "CarLand - You're not logged in";
require('layout/pagebegin.php');
?>


<font size="3"><b>You're Not Logged In</b></font>

<p>
You tried to do something for which you need to be logged in, but you aren't
logged in.
</p>
<p>
If you already have an account, <a href="account_login_form.php">
go to the login-page</a> to login. Otherwise, you can
<a href="account_register_form.php">register a new account</a>.
</p>


<?php require('layout/pageend.php');
exit;
?>
