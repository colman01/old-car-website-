<?php
require_once('session_check.php');

require_once('database_scripts/standard_queries.php');

$carad_id = (int)($_GET['carad_id']);
$pic      = (int)($_GET['pic'     ]);

$carad   = getCarad($carad_id);
$picList = $carad['picList'];
$account = getAccount($carad['account_id']);

$isOwnCarad = $SID ? $_SESSION['account_id'] == $carad['account_id'] : FALSE;

$account['email']     = getJavaScriptEmailHiding($account['email']);
$carad  ['timestamp'] = getTimeDateString       ($carad  ['timestamp']);

//htmlify data (make it ready to be put into an html page)
$htmlConvItems_carad = array(
 'make',
 'model',
 'colour',
 'caption',
 'description',
 'fuel',
 'transm'
);

$htmlConvItems_account = array(
 'firstname',
 'lastname',
 'city',
 'phone'
);

foreach ($htmlConvItems_carad as $item)
    $carad[$item] = htmlentities($carad[$item]);

foreach ($htmlConvItems_account as $item)
    $account[$item] = htmlentities($account[$item]);

$title = "CarLand - A Car Ad";
require('layout/pagebegin.php');
?>


<font size="3"><?=$carad['caption']?></font><br />
&nbsp;<br />

<table border="0"><tr>
<td valign="top">
  <b>Make:</b> <?=$carad['make']?><br />
  <b>Model:</b> <?=$carad['model']?><br />
  <b>Price:</b> <span class="head">&euro;<?=$carad['price']?></span><br />
  <b>Type:</b> <?=$carad['type']?><br />
  <b>Colour:</b> <?=$carad['colour']?><br />
  <b>Year:</b> <?=$carad['year']?><br />
  <b>Nct:</b> Year: <?=$carad['nct_year']?>&nbsp; Month:<?=$carad['nct_month']?><br />
  <b>Engine:</b> <?=$carad['engine']?><br />
  <b>Doors:</b> <?=$carad['doors']?><br />
  <b>Fuel Type:</b> <?=$carad['fuel']?><br />
  <b>Transmission:</b> <?=$carad['transm']?><br />
  <b>Seats:</b> <?=$carad['seats']?><br />
  <b>Mileage:</b> <?=$carad['mileage']?><br />
  <b>Power:</b> <?=$carad['power']?><br />
  <b>Date Entered:</b> <?=$carad['timestamp']?><br />
  <?php if ($account['city']) { ?> <b>Location:</b> <?=$account['city']?><br /> <?php } ?>
</td>
<td valign="top">&nbsp;</td>
<td valign="top">
  <b>Contact:</b><br />
  <?php if ($account['phone']) { ?> Phone: <?=$account['phone']?><br /> <?php } ?>
  <?php if ($account['isEmailPublic']) echo "Email: ".$account['email']; ?><br />
</td>
<td>
<?php if ($isOwnCarad) { ?>
      <form method="get" action="picture_manager.php" style="margin: 0;">
        <input type="hidden" name="<?=session_name()?>" value="<?=session_id()?>" />
        <input type="hidden" name="carad_id" value="<?=$carad_id?>" />
        <input type="submit" value="Upload Pictures" />
      </form>
      <form method="post" action="carad_edit_form.php" style="margin: 0;">
        <input type="hidden" name="<?=session_name()?>" value="<?=session_id()?>" />
        <input type="hidden" name="carad_id" value="<?=$carad_id?>" />
        <input type="submit" value="Edit Details" />
      </form>
      <form method="get" action="carad_remove_form.php" style="margin: 0;">
        <input type="hidden" name="<?=session_name()?>" value="<?=session_id()?>" />
        <input type="hidden" name="carad_id" value="<?=$carad_id?>" />
        <input type="submit" value="Remove" />
      </form>
<?php } ?>
</td>
</tr></table>
<?=$carad['description']?>
<a name="pics"></a>
&nbsp;<br />

<?php
for ($i = 0; $i < count($picList); $i++) { $picture = $picList[$i]; ?>
    <a href="carad_view.php?<?=$SID?>&carad_id=<?=$carad_id?>&pic=<?=$i?>#pics">
      <img src="carad_pics/<?=$picture?>_thumb.jpg" width="100" height="75" border="0" align="middle" /></a>
<?php } ?>

<br />
&nbsp;<br />

<?php if (count($carad['picList']) > 0) { ?>
  <img name="bigpic" src="carad_pics/<?=$carad['picList'][$pic]?>.jpg" alt="" /><br />
<?php } ?>
&nbsp;<br />




<?php require('layout/pageend.php'); ?>
