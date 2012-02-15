<?php

header('Pragma: no-cache');


require_once('session_check.php');
if ($SID) require('errorpages/already_registered.php');


$title = "CarLand - Register Your New Account";
require('layout/pagebegin.php');
?>


<font size="3"><b>Enter your Details</b></font>

<p>
Here you can sign up for a new account. You can use your account to submit car
ads to this website. Signup is free and has no obligations.<br />
Your email address will be used to identify you when you login to your account
on this website. Please don't put in the password of your email address below.
Instead, choose a different password solely for logging in to your CarLand
account.
</p>
&nbsp;<br />


<form action="account_register_action.php" method="post">

<center>
<table cellspacing="3" cellpadding="0">

  <tr>
    <td align="right">Email:&nbsp;</td>
    <td align="left" ><input name="email" type="text" value="<?=$email?>" /></td>
    <td align="left" ><font color="red"><?=$emailMsg?></font></td>
  </tr>
  <tr>
    <td align="right">Show Email on Car Ads:&nbsp;</td>
    <td align="left" >
      <input name="isEmailPublic" type="radio" value="yes" <?= $isEmailPublic ? 'checked' : ''?> /> Yes<br />
      <input name="isEmailPublic" type="radio" value="no"  <?=!$isEmailPublic ? 'checked' : ''?> /> No
    </td>
    <td align="left" ><font color="red"><?=$isEmailPublicMsg?></font></td>
  </tr>
  <tr>
    <td align="right">Password:&nbsp;</td>
    <td align="left" ><input name="password" type="password" /></td>
    <td align="left" ><font color="red"><?=$passwordMsg?></font></td>
  </tr>
  <tr>
    <td align="right">Repeat Password:&nbsp;</td>
    <td align="left" ><input name="password_rep" type="password" /></td>
    <td align="left" ><font color="red"><?=$password_repMsg?></font></td>
  </tr>
  <tr><td>&nbsp;</td></tr>

  <tr>
    <td align="right">Firstname:&nbsp;</td>
    <td align="left" ><input name="firstname" type="text" value="<?=$firstname?>" /></td>
    <td align="left" ><font color="red"><?=$firstnameMsg?></font></td>
  </tr>
  <tr>
    <td align="right">Lastname:&nbsp;</td>
    <td align="left" ><input name="lastname" type="text" value="<?=$lastname?>" /></td>
    <td align="left" ><font color="red"><?=$lastnameMsg?></font></td>
  </tr>
  <tr><td>&nbsp;</td></tr>

  <tr>
    <td align="right">Address:&nbsp;</td>
    <td align="left" ><input name="address" type="text" value="<?=$address?>" /></td>
    <td align="left" ><font color="red"><?=$addressMsg?></font></td>
  </tr>
  <tr>
    <td align="right">City:&nbsp;</td>
    <td align="left" ><input name="city" type="text" value="<?=$city?>" /></td>
    <td align="left" ><font color="red"><?=$cityMsg?></font></td>
  </tr>
  <tr>
    <td align="right">Phone:&nbsp;</td>
    <td align="left" ><input name="phone" type="text" value="<?=$phone?>" /></td>
    <td align="left" ><font color="red"><?=$phoneMsg?></font></td>
  </tr>
  <tr><td>&nbsp;</td></tr>

  <tr>
    <td colspan="3" align="center">
      <input name="Sign Up" type="submit" VALUE="Sign Up" />
    </td>
  </tr>

</table>
</center>

</form>


<?php require('layout/pageend.php'); ?>
