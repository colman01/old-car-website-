<?php
require_once('session_check.php');
require_once('database_scripts/standard_queries.php');
require_once('layout/showCaradShort.php');
require_once('mmm_datafiles.php');

$directions      = getFileContent($FILENAME_DIRECTIONS);

$query = "SELECT * FROM carads WHERE attendsThisMmm=1";
$caradListThisMmm = getResultSet($query);
if ($caradList === FALSE)
    die("database error. couldn't retrieve list of cars attending this ".
        "month's motor market: ".mysql_error());

$query = "SELECT * FROM carads WHERE attendsNextMmm=1";
$caradListNextMmm = getResultSet($query);
if ($caradList === FALSE)
    die("database error. couldn't retrieve list of cars attending next ".
        "month's motor market: ".mysql_error());

//list of pictures for every carad of this mmm
for ($i = 0; $i < count($caradListThisMmm); $i++) {
    $caradListThisMmm[$i]['picList'] =
     getPicturesOfCarad($caradListThisMmm[$i]['carad_id']);
}

//list of pictures for every carad of next mmm
for ($i = 0; $i < count($caradListNextMmm); $i++) {
    $caradListNextMmm[$i]['picList'] =
     getPicturesOfCarad($caradListNextMmm[$i]['carad_id']);
}


$title = "CarLand - Template";
require('layout/pagebegin.php');


$this_month_date  = getFileContent($FILENAME_THIS_MONTH_DATE );
$this_month_glink = getFileContent($FILENAME_THIS_MONTH_GLINK);
$next_month_date  = getFileContent($FILENAME_NEXT_MONTH_DATE );
$next_month_glink = getFileContent($FILENAME_NEXT_MONTH_GLINK);
?>


<font size="3"><b>Monthly Motor Market</b></font><br />
&nbsp;<br />

<?=str_replace("\n","<br />", $directions)?><br /><br />

<p>
THIS Months motor market takes place <?=$this_month_date?> and will be held
<a href="<?=$this_month_glink?>">here</a>.
</p>

<p>
NEXT Months motor market takes place <?=$next_month_date?> and will be held
<a href="<?=$next_month_glink?>">here</a>.
</p>

&nbsp;<br />
&nbsp;<br />
&nbsp;<br />

<p>
Cars at the coming up monthly motor market:<br />
<?php showCaradList($caradListThisMmm); ?>
</p>

&nbsp;<br />
&nbsp;<br />
&nbsp;<br />

<p>
Cars being shown at the next month's motor market:<br />
<?php showCaradList($caradListNextMmm); ?>
</p>


<?php require('layout/pageend.php'); ?>
