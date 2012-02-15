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

//extract account fields to be global variables
foreach ($paramList as $param)
    $GLOBALS[$param] = $account[$param];

$title = "CarLand - Account Details";
require('layout/pagebegin.php');
?>


<font size="3"><b>Your Accout Details</b></font>

&nbsp;<br />
&nbsp;<br />


<table cellspacing="3" cellpadding="0">

  <tr>
    <td align="right">Email:&nbsp;</td>
    <td align="left" ><?=$email?></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td rowspan="9">
      <form action="account_edit_form.php" method="get">
        <input type="hidden" name="<?=session_name()?>" value="<?=session_id()?>" />
        <input type="submit" value="Change Details" />
      </form>
      <form action="account_remove_form.php" method="get">
        <input type="hidden" name="<?=session_name()?>" value="<?=session_id()?>" />
        <input type="submit" value="Delete Account" />
      </form>
    </td>
  </tr>
  <tr>
    <td align="right">Show Email on Car Ads:&nbsp;</td>
    <td align="left" ><?=$isEmailPublic ? 'yes' : 'no' ?></td>
  </tr>

  <tr><td>&nbsp;</td></tr>

  <tr>
    <td align="right">Firstname:&nbsp;</td>
    <td align="left" ><?=$firstname?></td>
  </tr>
  <tr>
    <td align="right">Lastname:&nbsp;</td>
    <td align="left" ><?=$lastname?></td>
  </tr>
  <tr><td>&nbsp;</td></tr>

  <tr>
    <td align="right">Address:&nbsp;</td>
    <td align="left" ><?=$address?></td>
  </tr>
  <tr>
    <td align="right">City:&nbsp;</td>
    <td align="left" ><?=$city?></td>
  </tr>
  <tr>
    <td align="right">Phone:&nbsp;</td>
    <td align="left" ><?=$phone?></td>
  </tr>

</table>


<?php require('layout/pageend.php'); ?>
