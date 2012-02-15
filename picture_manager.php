<?php

header('Pragma: no-cache');

require_once('session_check.php');
if (! $SID) require('errorpages/not_logged_in.php');

$carad_id = (int)($_GET['carad_id']);

require_once('database_scripts/standard_queries.php');
$carad = getCarad($carad_id);
$picList = $carad['picList'];

//if user tries to modify the pictures of a carad which is not his own
if ($carad['account_id'] != $_SESSION['account_id'])
    require('errorpages/denied.php');

//htmlify data (make it ready to be put into an html page)
$htmlConvItems_carad = array(
 'make',
 'model',
 'type',
 'colour',
 'caption',
 'description',
 'fuel',
 'transm'
);

foreach ($htmlConvItems_carad as $item) {
    eval("\$carad['$item'] = htmlentities(\$carad['$item']);");
}


$title = "CarLand - Manage Pictures";
require('layout/pagebegin.php');
?>


<font size="3">Manage Pictures for Car Ad</font><br />
&nbsp;<br />

<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr>
<td width="100%" valign="top">

<?php
for ($i = 0; $i < count($picList); $i++) { $picture = $picList[$i]; ?>
    <form action="picture_remove_action.php" method="post">
      <a href="carad_view.php?<?=$SID?>&carad_id=<?=$carad_id?>&pic=<?=$i?>#pics">
        <img src="carad_pics/<?=$picture?>_thumb.jpg" width="140" height="105" border="0" align="middle" /></a>
      &nbsp;&nbsp;&nbsp;
      <input type="hidden" name="<?=session_name()?>" value="<?=session_id()?>"/>
      <input type="hidden" name="carad_id" value="<?=$carad_id?>"/>
      <input type="hidden" name="picture" value="<?=$picture?>"/>
      <input type="submit" value="remove" />
    </form>
    &nbsp;<br />
    &nbsp;<br />
<?php } ?>

Upload Picture:<br />
<form enctype="multipart/form-data" action="picture_upload_action.php" method="post">
  <input type="hidden" name="<?=session_name()?>" value="<?=session_id()?>"/>
  <input type="hidden" name="carad_id" value="<?=$carad_id?>"/>
  <input type="hidden" name="MAX_FILE_SIZE" value="52428800" />
  <input type="file" name="pictureFile" /><br />
  <input type="submit" value="upload" />
</form>

</td>
<td valign="top" nowrap>
  <b>Make:</b> <?=$carad['make']?><br />
  <b>Model:</b> <?=$carad['model']?><br />
  <b>Type:</b> <?=$carad['type']?><br />
  <b>Colour:</b> <?=$carad['colour']?><br />
  <b>Fuel Type:</b> <?=$carad['fuel']?><br />
  <b>Transmission:</b> <?=$carad['transm']?><br />
</td>
</tr></table>

<br /><center>
<form  action="carad_view.php" method="get">
  <input type="hidden" name="<?=session_name()?>" value="<?=session_id()?>"/>
  <input type="hidden" name="carad_id" value="<?=$carad_id?>"/>
  <input type="submit" value="Finish" />
</form>
</center>


<?php require('layout/pageend.php'); ?>
