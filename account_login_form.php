<?php

require_once('session_check.php');
if ($SID) require('errorpages/already_logged_in.php');


$title = "CarLand - Login To Your Account";
require('layout/pagebegin.php');
?>


<font size="3"><b>Login to Your Account</b></font>

<br />&nbsp;

<p>
<form action="account_login_action.php" method="post" >
<table>
  <tr>
    <td align="right" width="0">Email:</td>
    <td><input name="email" type="text" value="<?=$email?>" /></td>
    <td><font color="red"><?=$emailMsg?></font></td>
  </tr>

  <tr>
    <td align="right">Password:</td>
    <td><input name="password" type="password" /></td>
    <td><font color="red"><?=$passwordMsg?></font></td>
  </tr>

  <tr>
    <td colspan="2" align="center">
      <input name="Login" type="submit" value="Login" />
    </td>
  </tr>
</table>
</form>
</p>


<?php require('layout/pageend.php'); ?>
