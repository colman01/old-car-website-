<?php
header("Pragma: no-cache");

require_once('session_check.php');
if (! $SID) require('errorpages/need_to_register.php');

require_once('database_scripts/standard_queries.php');

$carad_id = (int)($_POST['carad_id']);
$carad = getCarad($carad_id);


$paramList = array(
 'make'           => 'string',
 'model'          => 'string',
 'type'           => 'string',
 'colour'         => 'string',
 'caption'        => 'string',
 'description'    => 'string',
 'year'           => 'int',
 'nct_year'       => 'int',
 'nct_month'      => 'int',
 'engine'         => 'float',
 'doors'          => 'int',
 'fuel'           => 'string',
 'transm'         => 'string',
 'price'          => 'float',
 'seats'          => 'int',
 'mileage'        => 'int',
 'attendsThisMmm' => 'bool',
 'attendsNextMmm' => 'bool',

 'otherMakeCheck'  => 'bool',
 'otherModelCheck' => 'bool',
 'otherTypeCheck'  => 'bool',
 'otherMake'       => 'string',
 'otherModel'      => 'string',
 'otherType'       => 'string'
);

//extract parameters to be global variables
foreach ($paramList as $paramName => $paramType) {
    $value = strlen($_POST[$paramName]) ? $_POST[$paramName] : $carad[$paramName];
    eval("\$$paramName = \$value;");
}


$makeList  = getNameList('makes');

if (! $make) $make = $makeList[0];
$modelList = getModelNameList($make);

if (! $model || ! in_array($model, $modelList))
    $model = $modelList[0];

$typeList  = getNameList('types');
$fuelList  = getNameList('fuels');


require_once('mmm_datafiles.php');
$date_thism = getFileContent($FILENAME_THIS_MONTH_DATE);
$date_nextm = getFileContent($FILENAME_NEXT_MONTH_DATE);


$title = "CarLand - Edit Car Ad";
require('layout/pagebegin.php');
?>


<script language="JavaScript"><!--

    function updateDropdownMenus() {
        document.forms[0].action = "<?=$_SERVER['SCRIPT_NAME']?>";
        document.forms[0].submit();
    }

--></script>


<center>
<form action="carad_edit_action.php" method="post">
  <input type="hidden" name="<?=session_name()?>" value="<?=session_id()?>" />
  <input type="hidden" name="carad_id" value="<?=$carad_id?>" />

  <table border="0" class="copy">
 

    <tr>
      <td align="right">Make:</td>
      <td align="left" ><select name="make" onchange="updateDropdownMenus();">
        <?php foreach ($makeList as $item) { ?>
            <option <?= ($item == $make) ? 'selected' : ''?>><?=$item?></option>
        <?php } ?>
      </select></td>

      <td align="left">other
        <input name="otherMakeCheck" type="checkbox" <?=$otherMakeCheck ? 'checked' : ''?> onchange="document.getElementById( 'otherMake' ).disabled = ! this.checked;"/>
        <input name="otherMake" id="otherMake" type="text" value="<?=$otherMake?>" <?=$otherMakeCheck ? '' : 'disabled="disabled"'?>/>
      </td>
    </tr>

    <tr>
      <td align="right">Model:</td>
      <td align="left"><select name="model">
        <?php foreach ($modelList as $item) { ?>
            <option <?= ($item == $model) ? 'selected' : ''?>><?=$item?></option>
        <?php } ?>
      </select></td>

      <td align="left">other
        <input name="otherModelCheck" type="checkbox" <?=$otherModelCheck ? 'checked' : ''?> onchange="document.getElementById( 'otherModel' ).disabled = ! this.checked;"/>
        <input name="otherModel" id="otherModel" type="text" value="<?=$otherModel?>" <?=$otherModelCheck ? '' : 'disabled="disabled"'?>/>
      </td>
    </tr>

    <tr>
      <td align="right">Type:</td>
      <td align="left"><select name="type">
        <?php foreach ($typeList as $item) { ?>
            <option <?= ($item == $type) ? 'selected' : ''?>><?=$item?></option>
        <?php } ?>
      </select></td>

      <td align="left">other
        <input name="otherTypeCheck" type="checkbox" <?=$otherTypeCheck ? 'checked' : ''?> onchange="document.getElementById( 'otherType' ).disabled = ! this.checked;"/>
        <input name="otherType" id="otherType" type="text" value="<?=$otherType?>" <?=$otherTypeCheck ? '' : 'disabled="disabled"'?>/>
      </td>
    </tr>

    <tr>
      <td align="right">Year:</td>
      <td align="left"><select name="year">
        <?php
        $curYear = date('Y');
        for ($i = $curYear; $i >= 1900; $i--) { ?>
            <option <?= ($i == $year) ? 'selected' : ''?>><?=$i?></option>
        <?php } ?>
      </select></td>
    </tr>

   <tr>
      <td align="right">Nct: Year</td>
      <td align="left"><select name="nct_year" value="<?=$nct_year?>">
        <?php
        $curYear = date('Y');
        for ($i = $curYear+3; $i >=$curYear ; $i--) { ?>
            <option <?= ($i == $nct_year) ? 'selected' : ''?>><?=$i?></option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
     <td align="right">Nct Month:</td>
     <td align="left"><select name="nct_month" value="<?=$nct_month?>">
            <?php
        $curMonth = date('M');
        for ($i = $curMonth+12; $i >=$curMonth+1 ; $i--) { ?>
            <option <?= ($i == $nct_month) ? 'selected' : ''?>><?=$i?></option>
        <?php } ?>
      </select></td>
     </td>
    </tr>

    <tr>
      <td align="right">Price:&nbsp;</td>
      <td align="left" ><input name="price" type="text" value="<?=$price?>" /></td>
    </tr>

    <tr>
      <td align="right">Seats:&nbsp;</td>
      <td align="left" ><input name="seats" type="text" value="<?=$seats?>" /></td>
    </tr>

    <tr>
      <td align="right">Colour:&nbsp;</td>
      <td align="left" ><input name="colour" type="text" value="<?=$colour?>" /></td>
    </tr>

    <tr>
      <td align="right">Caption:&nbsp;</td>
      <td align="left" ><input name="caption" type="text" value="<?=$caption?>" /></td>
    </tr>

    <tr>
      <td align="right">Engine Size:&nbsp;</td>
      <td align="left" ><select  name="engine">
        <?php for ($i = 0.1 ; $i <= 4; $i += 0.1) { ?>
            <option <?= "$i" == $engine ? 'selected' : ''?>><?=$i?></option>
        <?php } ?>
        <option <?= 'more' == $engine ? 'selected' : ''?>>more</option>
      </select></td>
    </tr>

    <tr>
      <td align="right">Doors:</td>
      <td align="left" ><select  name="doors">
        <?php for ($i = 1; $i <= 5; $i++){ ?>
            <option <?= $i == $doors ? 'selected' : ''?>><?=$i?></option>
        <?php } ?>
        <option <?= 'more' == $doors ? 'selected' : ''?>>more</option>
      </select></td>
    </tr>

    <tr>
      <td align="right">Fuel Type:</td>
      <td align="left" ><select name="fuel">
        <?php foreach ($fuelList as $fuel){ ?>
            <option <?= $fuel == $fuel ? 'selected' : ''?>><?=$fuel?></option>
        <?php } ?>
        <option>other</option>
      </select></td>
    </tr>

    <tr>
      <td align="right">Transmission:</td>
      <td align="left" ><select name="transm"> 
        <option <?= 'automatic' == $transm ? 'selected' : ''?>>automatic</option>
        <option <?= 'manual'    == $transm ? 'selected' : ''?>>manual</option>
      </select></td>
    </tr>

    <tr>
      <td align="right">Mileage:</td>
      <td align="left" ><input name="mileage" type="text" value="<?=$mileage?>" /></td>
    </tr>


    <tr>
     <td align="right">Description:</td>
    <td align="left" colspan="2">
      <textarea  align="right" name="description" rows=8 cols=60>
Please enter a description of your car and any additional information here.</textarea>
    </td>
  </tr>

<!-- /****************** -->


&nbsp;<br />

<tr>
<td align="left" colspan="3">
THIS Month's motor market takes place <?= $date_thism ?> and will
be held <a href="<?= $this_month_glink ?>">here</a>.<br />
</td>
</tr>

<tr>
    <td align="left" colspan="3">
        NEXT Month's motor market takes place <?= $date_nextm ?> and will
        be held <a href="<?= $next_month_glink ?>">here</a>.<br />
    </td>
</tr>
    <tr>
        <td colspan="3">
	Take Part in Motor Market <?= $date_thism ?>
        <input name="attendsThisMmm" type="checkbox" <?=$attendsThisMmm ? 'checked' : ''?>/>
      </td>
    </tr>
    <tr>
      <td align="left" colspan="3">
	Take Part in Motor Market <?= $date_nextm ?>
        <input name="attendsNextMmm" type="checkbox" <?=$attendsNextMmm ? 'checked' : ''?>/>
      </td>
    </tr>

    <tr>
      <td colspan="3" align="center">
        <input type="submit" value="Enter Advert" />
      </td>
    </tr>
</table>
</form>
</center>


<?php require('layout/pageend.php'); /**/ ?>
