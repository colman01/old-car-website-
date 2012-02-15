<?php
require_once('session_check.php');
require_once('layout/showCaradShort.php');


$title = "CarLand - Template";
require('layout/pagebegin.php');

$RESULTS_PER_PAGE = 10;


require_once('database_scripts/standard_queries.php');


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


//mysqlify parameters
foreach ($paramList as $paramName => $paramType) {
    if ($paramType == 'string')
        $GLOBALS[$paramName.'Sql'] = "'".mysql_real_escape_string($GLOBALS[$paramName])."'";
    else
        eval("\$$paramName"."Sql = ($paramType)(\$$paramName);");
}

if ($make            == '') $make            = 'any';
if ($model           == '') $model           = 'any';
if ($type            == '') $type            = 'any';
if ($colour          == '') $colour          = 'any';
if ($engine          == '') $engine          = 'any';
if ($doors           ==  0) $doors           = 'any';
if ($fuel            == '') $fuel            = 'any';
if ($yearRangeStart  ==  0) $yearRangeStart  = 'any';
if ($yearRangeEnd    ==  0) $yearRangeEnd    = 'any';
if ($priceRangeStart ==  0) $priceRangeStart = 'any';
if ($priceRangeEnd   ==  0) $priceRangeEnd   = 'any';

//create WHERE part of the SQL statement
$searchFields = Array();
if ($make            != 'any') array_push($searchFields, "make='$make'");
if ($model           != 'any') array_push($searchFields, "model='$model'");
if ($type            != 'any') array_push($searchFields, "type='$type'");
if ($colour          != 'any') array_push($searchFields, "colour='$colour'");
if ($engine          != 'any') array_push($searchFields, "engine='$engine'");
if ($doors           != 'any') array_push($searchFields, "doors='$doors'");
if ($fuel            != 'any') array_push($searchFields, "fuel='$fuel'");
if ($yearRangeStart  != 'any') array_push($searchFields, "year>=$yearRangeStart");
if ($yearRangeEnd    != 'any') array_push($searchFields, "year<=$yearRangeEnd");
if ($priceRangeStart != 'any') array_push($searchFields, "price>=$priceRangeStart");
if ($priceRangeEnd   != 'any') array_push($searchFields, "price<=$priceRangeEnd");


$wherePart = "";
for ($i = 0; $i < count($searchFields) - 1; $i++) {
	$wherePart .= $searchFields[$i]." AND ";
}

if      (count($searchFields) == 0)
    $wherePart = "";
else if (count($searchFields) == 1)
    $wherePart = 'WHERE '.$searchFields[0];
else
    $wherePart = "WHERE $wherePart".$searchFields[count($searchFields) - 1];

//number of the search results page that we're going to show, first page is 1
$page = $_GET['page'];
$page = (int)$page;
if (! $page)
    $page = 1;

//check range of $page
//get total number of search results (not just current page)
$query = "SELECT count(*) as number FROM carads $wherePart";
$result = mysql_query($query, $conn);
if (! $result)
    die ("couldn't retrieve number of found carads with query '$query': ".mysql_error());

$searchResultCount = mysql_fetch_row($result);
$searchResultCount = $searchResultCount[0];
mysql_free_result($result);

$maxPage = ceil($searchResultCount / $RESULTS_PER_PAGE);

if      ($page < 1)        $page = 1;
else if ($page > $maxPage) $page = $maxPage;


//create real search query
//SELECT * FROM `carads` LIMIT 20, 10 //selects 21st through 30th, both inclusive
$limitStart = ($page - 1) * $RESULTS_PER_PAGE;
$limitEnd   =               $RESULTS_PER_PAGE;

$sort = $_GET['sort'];

if      ($sort == "make" ) $byMake  = 1;
else if ($sort == "model") $byModel = 1;
else if ($sort == "type" ) $byType  = 1;
else if ($sort == "year" ) $byYear  = 1;
else if ($sort == "date" ) $byDate  = 1;
else {
    $sort = "make";
    $byMake = 1;
}

if ($searchResultCount > 0) {
    $query = "SELECT * FROM carads $wherePart ORDER BY $sort LIMIT $limitStart, $limitEnd";
    $result = mysql_query($query, $conn);
    if (! $result)
        die ("couldn't retrieve carads from database: ".mysql_error());

    $caradList = array();
    while ($row = mysql_fetch_assoc($result)) {
        array_push($caradList, $row);
    }
    mysql_free_result($result);

    //list of pictures for every carad
    for ($i = 0; $i < count($caradList); $i++) {
         $caradList[$i]['picList'] =
          getPicturesOfCarad($caradList[$i]['carad_id']);
    }
}

?>


<span class="copy">


<table width="100%"><tr>
<?php
if ($page > "1") {
?>
    <td align="left">
     <a href="carad_search_action.php?page=<?=($page-1)?>&sort=<?=$sort?>">
     &lt;&lt;&lt;&lt;&lt;&lt; LESS</a>
    </td>
<?php
}
if ($page < $maxPage) {
?>
    <td align="right">
     <a href="carad_search_action.php?page=<?=($page+1)?>&sort=<?=$sort?>">
     MORE &gt;&gt;&gt;&gt;&gt;&gt;</a>
    </td>
<?php
}
?>
</tr></table>


<?php foreach ($caradList as $carad) { showCaradShort($carad); } ?>


<?php if ($searchResultCount == 0) { ?>
 <div align="center" class="copy">Sorry, no results found.</div>
<?php } ?>


<?php require('layout/pageend.php'); ?>
