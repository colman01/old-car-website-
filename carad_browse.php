<?php
require_once('session_check.php');

$title = "CarLand - Browse Used Cars";
require('layout/pagebegin.php');
require('layout/showCaradShort.php');

$RESULTS_PER_PAGE = 5;


$page = $_GET['page'];
$page = (int)$page;
if (! $page)
    $page = 1;


require_once('database_scripts/standard_queries.php');


//check range of $page
//get total number of search results (not just current page)
$query = "SELECT count(*) as number FROM carads";
$result = mysql_query($query, $conn);
if (! $result)
    die ("couldn't retrieve number of carads with query '$query': ".mysql_error());

$searchResultCount = mysql_fetch_row($result);
$searchResultCount = $searchResultCount[0];
mysql_free_result($result);

if ($searchResultCount > 0) {
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

    $query = "SELECT * FROM carads ORDER BY $sort LIMIT $limitStart, $limitEnd";
    $result = mysql_query($query, $conn);
    if (! $result)
        die ("couldn't retrieve carads from database: ".mysql_error());

    $caradList = Array();
    while ($row = mysql_fetch_assoc($result)) {
        array_push($caradList, $row);
    }
    mysql_free_result($result);
}


//list of pictures for every carad
for ($i = 0; $i < count($caradList); $i++) {
     $caradList[$i]['picList'] =
      getPicturesOfCarad($caradList[$i]['carad_id']);
}
?>


<table width="100%"><tr>
<?php
if ($page > "1") {
?>
    <td align="left">
     <a href="carad_browse.php?page=<?=($page-1)?>&sort=<?=$sort?>">
     &lt;&lt;&lt;&lt;&lt;&lt; LESS</a>
    </td>
<?php
}
if ($page < $maxPage) {
?>
    <td align="right">
     <a href="carad_browse.php?page=<?=($page+1)?>&sort=<?=$sort?>">
     MORE &gt;&gt;&gt;&gt;&gt;&gt;</a>
    </td>
<?php
}
?>
</tr></table>


<?php foreach ($caradList as $carad) { showCaradShort($carad); } ?>


<?php require('layout/pageend.php'); ?>
