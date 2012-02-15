<?php


require_once('session_check.php');
$title = "CarLand - Sell Service";
require('layout/pagebegin.php');

require_once('database_scripts/standard_queries.php');
require_once('session_check.php');
if ($SID) {
    $account_id = $_SESSION['account_id'];
    $account = getAccount($account_id);
}
?>


<form action="sell_service_action.php" method="post">
<table>
  <tr>
    <td align="right">Firstname:&nbsp;</td>
    <td align="left" width="100%"><input name="firstname" type="text" value="<?=$account['firstname']?>" /></td>
  </tr>
  <tr>
    <td align="right">Lastname:&nbsp;</td>
    <td align="left" ><input name="lastname" type="text" value="<?=$account['lastname']?>" /></td>
  </tr>
  <tr>
    <td align="right">Email:&nbsp;</td>
    <td align="left" ><input name="email" type="text" value="<?=$account['email']?>" /></td>
  </tr>
  <tr>
    <td align="right">Phone:&nbsp;</td>
    <td align="left" ><input name="phone" type="text" value="<?=$account['phone']?>" /></td>
  </tr>
  <tr>
    <td align="left" colspan=2>
      &nbsp;<br />
      Description:<br />
      <textarea name="description" rows=10 cols=80>
Please enter a description of your car and any additional information here.</textarea>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <input name="submit" type="submit" value="Send" />
    </td>
  </tr>
</table>
</form>


<?php require('layout/pageend.php'); ?>
