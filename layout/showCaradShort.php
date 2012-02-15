<?php

/*
 * Outputs the html code for a list of carads.
 */
function showCaradList($caradList) {
    if (! is_array($caradList))
        die("\$caradList must be an array.");

    for ($i = 0; $i < count($caradList); $i++) {
        showCaradShort($caradList[$i]);
    }
}


/*
 * Outputs the html code for a list item version of a single carad.
 */
function showCaradShort($carad) {
    global $SID;
    $carad_id = $carad['carad_id'];

    $isOwnCarad = $SID ? $_SESSION['account_id'] == $carad['account_id'] : FALSE;

    ?>

<div class="car"><div class="padd">
<table>
  <tr>
    <td valign="top">
      <?php if (count($carad['picList']) > 0) { ?>
        <a href="carad_view.php?<?=$SID?>&carad_id=<?=$carad_id?>">
          <img src="carad_pics/<?=$carad['picList'][0]?>_thumb.jpg" width="140" height="105" alt="" />
        </a>
      <?php } else { ?>
        <div class="nopic"><div style="margin-top: 45px;">
          <?php if ($SID && $carad['account_id'] == $_SESSION['account_id']) { //if own carad ?>
            <a href="picture_manager.php?<?=$SID?>&carad_id=<?=$carad_id?>">
              Add Picture Now
            </a>
          <?php } else { //if not own carad ?>
              no picture
          <?php } ?>
        </div></div>
      <?php } ?>
    </td>
    <td width="20"></td>
    <td valign="middle">
      <b>Make:</b> <?=$carad['make']?><br />
      <b>Model:</b> <?=$carad['model']?><br />
      <b>Price:</b> <span class="head">&euro; <?=$carad['price']?></span><br />
      <a href="carad_view.php?<?=$SID?>&carad_id=<?=$carad_id?>">See full description</a>
    </td>
    <td width="20"></td>
    <td valign="top">
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
<?php } else { ?>
      &nbsp;
<?php } ?>
    </td>
  </tr>
</table>
</div></div>
    <?php
}

?>
