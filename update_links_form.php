<?php
require_once('session_check.php');
require_once('mmm_datafiles.php');


$this_month_glink = getFileContent($FILENAME_THIS_MONTH_GLINK);
$this_month_date  = getFileContent($FILENAME_THIS_MONTH_DATE );
$next_month_glink = getFileContent($FILENAME_NEXT_MONTH_GLINK);
$next_month_date  = getFileContent($FILENAME_NEXT_MONTH_DATE );
$contact_email    = getFileContent($FILENAME_CONTACT_EMAIL   );
$welcome          = getFileContent($FILENAME_WELCOME);
$directions       = getFileContent($FILENAME_DIRECTIONS);


$title = "CarLand - Template";
require('layout/pagebegin.php');
?>


<form action="update_links_action.php" method="post">
<table>
  <tr>
    <td align="right" width="0">New Location Link for THIS month:</td>
    <td><input name="glink_thism" type="text" value="<?=$this_month_glink?>" /></td>
  </tr>

  <tr>
    <td align="right" width="0">Enter Date of THIS months market:</td>
    <td><input name="this_month" type="text" value="<?=$this_month_date?>" /></td>
  </tr>

  <tr>
    <td align="right" width="0">New Location Link for NEXT month:</td>
    <td><input name="glink_nextm" type="text" value="<?=$next_month_glink?>" /></td>
  </tr>

  <tr>
    <td align="right" width="0">Enter Date of NEXT months market:</td>
    <td><input name="next_month" type="text" value="<?=$next_month_date?>" /></td>
  </tr>
 <tr>
    <td align="right" width="0">CarLand eMail update:</td>
    <td><input name="clemail" type="text" value="<?=$contact_email?>" /></td>
  </tr>

 <tr>
    <td align="right" width="0">Welcome Note:</td>
    <td><input name="welcome" type="text" value="<?=$welcome?>" /></td>
  </tr>

  <tr>
      <td align="right">Directions where to go to find Motor Market:</td>
        <td align="left" >
          <textarea  align="right" name="directions" rows=8 cols=60><?=$directions?></textarea>
        </td>
  </tr>

  <tr>
    <td colspan="2" align="center">
      <input name="Update" type="submit" value="Update" />
    </td>
  </tr>


</table>
</form>


<?php require('layout/pageend.php'); ?>
