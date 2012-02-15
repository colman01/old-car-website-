<?php
header('Pragma: no-cache');


require_once('session_check.php');
if (! $SID) require('errorpages/not_logged_in.php');


require_once('database_scripts/standard_queries.php');
$account = getAccount($_SESSION['account_id']);

$paramList = array(
 'firstname'    ,
 'lastname'     ,
 'email'        ,
 'isEmailPublic',
 'address'      ,
 'city'         ,
 'phone'
);

//extract account details to be global variables if not yet set.
//they can be set by the action script, which includes this script
//when the user data validation failed.
foreach ($paramList as $param) {
    if (! array_key_exists($param, $GLOBALS))
        $GLOBALS[$param] = $account[$param];
}


$title = "CarLand - Edit Your Account Details";
require('layout/pagebegin.php');
?>


<font size="3"><b>Edit Your Accout Details</b></font>

<center>
<form action="account_edit_action.php" method="post">
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
    <td align="right">Current Password:&nbsp;</td>
    <td align="left" ><input name="curPassword" type="password" /></td>
    <td align="left" ><font color="red"><?=$curPasswordMsg?></font></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="2" align="left">
      &nbsp;<br />
      If you don't want to change the password,<br />
      leave the following two fields blank.
    </td>
  </tr>
  <tr>
    <td align="right">New Password:&nbsp;</td>
    <td align="left" ><input name="newPassword" type="password" /></td>
    <td align="left" ><font color="red"><?=$newPasswordMsg?></font></td>
  </tr>
  <tr>
    <td align="right">Repeat New Password:&nbsp;</td>
    <td align="left" ><input name="newPassword_rep" type="password" /></td>
    <td align="left" ><font color="red"><?=$newPassword_repMsg?></font></td>
  </tr>
  <tr><td>&nbsp;</td></tr>

  <tr>
    <td colspan="3" align="center">
      <input type="submit" value="Save" />
    </td>
  </tr>

</table>
</form>
</center>


<?php require('layout/pageend.php'); ?>
