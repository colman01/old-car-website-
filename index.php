<?php
require_once('session_check.php');
require_once('layout/showCaradShort.php');
require_once('database_scripts/standard_queries.php');
require_once('mmm_datafiles.php');

$welcome          = getFileContent($FILENAME_WELCOME);

//get 5 newest car ads
$query = "SELECT * FROM carads ORDER BY timestamp DESC LIMIT 0, 5";
$result = mysql_query($query, $conn);
if (! $result)
    die ("couldn't retrieve most recent carads from database: ".mysql_error());

$caradList = Array();
while ($row = mysql_fetch_assoc($result)) {
    array_push($caradList, $row);
}
mysql_free_result($result);

//list of pictures for every carad
for ($i = 0; $i < count($caradList); $i++) {
     $caradList[$i]['picList'] =
      getPicturesOfCarad($caradList[$i]['carad_id']);
}


//model and make list, if required
$paramList = array(
 'make'            => 'string',
 'model'           => 'string',
 'priceRangeStart' => 'int',
 'priceRangeEnd'   => 'int'
);

//extract parameters to be global variables
foreach ($paramList as $paramName => $paramType)
    $GLOBALS[$paramName] = $_POST[$paramName];

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


$title = "CarLand - the best place for cars in town";
require('layout/pagebegin.php');
?>
<!-- from search -->
<script language="JavaScript"><!--

    function updateDropdownMenus() {
        document.forms[0].action = "<?=$_SERVER['SCRIPT_NAME']?>";
        document.forms[0].submit();
    }

--></script>

<?=$welcome?><br /><br />

<div class="box"><div class="padd">
  <img src="layout/images/arrow.gif" alt="" />&nbsp;
  <b>SEARCH FOR YOUR CAR</b><br /><br />

<form action="carad_search_action.php" method="post">
<input type="hidden" name="<?=session_name()?>" value="<?=session_id()?>" />
<table width="100%" border="0"><tr><td align="center">

<table border="0">
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
    <td align="right">Start Price:&nbsp;</td>
    <td align="left" >
      <input name="priceRangeStart" type="text" /></td>
  </tr>
  <tr>
    <td align="right">Highest Price:&nbsp;</td>
    <td align="left" ><input name="priceRangeEnd" type="text" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
     <input type="submit" value="search"/>
    </td>
  </tr>
  </tr>
  <tr>
    <td colspan="2" align="center">
     <a href="carad_search_form.php">Advanced Search</a>
    </td>
  </tr>
</table>
 
</table>

</form>
</div></div>

<img src="layout/images/arrow.gif" alt="" />&nbsp; <b>LATEST CAR POSTS</b><br /><br />


<?php foreach ($caradList as $carad) { showCaradShort($carad); } ?>


<?php require('layout/pageend.php'); ?>
