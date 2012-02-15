<?php
header("Pragma: no-cache");

require_once('session_check.php');

$title = "CarLand - Template";
require('layout/pagebegin.php');

$paramList = array(
 'make'            => 'string',
 'model'           => 'string',
 'type'            => 'string',
 'colour'          => 'string',
 'engine'          => 'float',
 'doors'           => 'int',
 'fuel'            => 'string',
 'yearRangeStart'  => 'int',
 'yearRangeEnd'    => 'int',
 'priceRangeStart' => 'int',
 'priceRangeEnd'   => 'int'
);

//extract parameters to be global variables
foreach ($paramList as $paramName => $paramType)
    $GLOBALS[$paramName] = $_POST[$paramName];


require_once('database_scripts/standard_queries.php');
$makeList  = getNameList('makes');

if (! $make ) $make  = 'any';
if (! $model) $model = 'any';

if ($make != 'any') {
    $modelList = getModelNameList($make);

    if ($model != 'any' && ! in_array($model, $modelList))
        $model = $modelList[0];
}
else
    $model = 'any';

$typeList   = getNameList('types');
$fuelList   = getNameList('fuels');
$colourList = getNameList('colours');
?>


<script language="JavaScript"><!--

    function updateDropdownMenus() {
        document.forms[0].action = "<?=$_SERVER['SCRIPT_NAME']?>";
        document.forms[0].submit();
    }

--></script>


<center>
<form action="carad_search_action.php" method="post">
  <input type="hidden" name="<?=session_name()?>" value="<?=session_id()?>" />

<table border="0" class="copy">
  <tr>
    <td align="right">Make:&nbsp;</td>
    <td align="left" >
      <select name="make" onchange="updateDropdownMenus();">
        <?php foreach ($makeList as $item) { ?>
            <option <?= ($item == $make) ? 'selected' : ''?>><?=$item?></option>
        <?php } ?>
        <option <?= ('any' == $make) ? 'selected' : ''?>>any</option>
       </select>
    </td>
  </tr>

  <tr>
    <td align="right">Model:&nbsp;</td>
    <td align="left">
      <select name="model">
        <?php foreach ($modelList as $item) { ?>
            <option <?= ($item == $model) ? 'selected' : ''?>><?=$item?></option>
        <?php } ?>
        <option <?= ('any' == $model) ? 'selected' : ''?>>any</option>
	  </select>
    </td>
  </tr>

  <tr>
    <td align="right">Type:&nbsp;</td>
    <td align="left" >
      <select name="type">
        <?php foreach ($typeList as $item) { ?>
            <option <?= ($item == $type) ? 'selected' : ''?>><?=$item?></option>
        <?php } ?>
        <option <?= ('any' == $type) ? 'selected' : ''?>>any</option>
	  </select>
    </td>
  </tr>

  <tr>
    <td align="right">Colour:&nbsp;</td>
    <td align="left" >
      <select name="colour">
        <?php foreach ($colourList as $item) { ?>
            <option <?= ($item == $type) ? 'selected' : ''?>><?=$item?></option>
        <?php } ?>
        <option <?= ('any' == $colour) ? 'selected' : ''?>>any</option>
	  </select>
    </td>
  </tr>

  <tr>
    <td align="right">Doors:&nbsp;</td>
    <td align="left" >
      <select  name="doors">
        <?php for ($i = 1; $i <= 5; $i++) { ?>
            <option <?= ($i == $doors) ? 'selected' : ''?>><?=$i?></option>
        <?php } ?>
        <option <?= ('more' == $doors) ? 'selected' : ''?>>more</option>
        <option <?= ('any'  == $doors) ? 'selected' : ''?>>any</option>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right">Fuel Type:&nbsp;</td>
    <td align="left" >
      <select name="fuel">
        <?php foreach ($fuelList as $item) { ?>
            <option <?= ($item == $fuel) ? 'selected' : ''?>><?=$item?></option>
        <?php } ?>
        <option <?= ('any' == $fuel) ? 'selected' : ''?>>any</option>
	  </select>
    </td>
  </tr>

  <tr>
    <td align="right">Transmission:&nbsp;</td>
    <td align="left" >
      <select name="transm">
        <option <?= ('any'       == $transm) ? 'selected' : ''?>>any</option>
        <option <?= ('manual'    == $transm) ? 'selected' : ''?>>manual</option>
        <option <?= ('automatic' == $transm) ? 'selected' : ''?>>automatic</option>
	  </select>
    </td>
  </tr>

  <tr>
    <td align="right">Engine Size:&nbsp;</td>
    <td align="left" >
     <select name="engine">
        <?php for ($i = 0.1; $i <= 6; $i = $i + 0.1) { ?>
            <option <?= ("$i" == $engine) ? 'selected' : ''?>><?=$i?></option>
        <?php } ?>
        <option <?= ('any' == $engine) ? 'selected' : '' ?>>any</option>
	  </select>
    </td>
  </tr>

  <tr>
    <td align="right">Registered after:&nbsp;</td>
    <td align="left" >
      <select name="yearRangeStart">
        <option <?= ('no age limit'  == $yearRangeStart) ? 'selected' : ''?>>no age limit</option>
        <?php
        $curYear = date('Y');
        for ($i = 1900; $i <= $curYear; $i++) { ?>
            <option <?= ($i == $yearRangeStart) ? 'selected' : ''?>><?=$i?></option>
        <?php } ?>
	  </select>
    </td>
  </tr>

  <tr>
    <td align="right">Registered Before:&nbsp;</td>
    <td align="left" >
      <select name="yearRangeEnd">
        <option <?= 'no minimum age' == $yearRangeEnd ? 'selected' : ''?>>no minimum age</option>
        <?php
        $curYear = date('Y');
        for ($i = 1900; $i <= $curYear; $i++) { ?>
            <option <?= ($i == $yearRangeEnd) ? 'selected' : ''?>><?=$i?></option>
        <?php } ?>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right">Start Price:&nbsp;</td>
    <td align="left" >
      <input name="priceRangeStart" type="text" value="<?=$priceRangeStart?>" />
    </td>
  </tr>

  <tr>
    <td align="right">Highest Price:&nbsp;</td>
    <td align="left" >
      <input name="priceRangeEnd" type="text" value="<?=$priceRangeEnd?>" />
    </td>
  </tr>

  <tr>
    <td colspan="2" align="center">
     <input type="submit" value="Search" />
    </td>
  </tr>
</table>

</form>
</center>


<?php require('layout/pageend.php'); ?>
