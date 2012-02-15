<?php
header('Pragma: no-cache');

$tableName = $_GET['table'] ? $_GET['table'] : "SHOW TABLES";

if      ($tableName == 'carads')
    $orderByPart = 'ORDER BY carad_id';
else if ($tableName == 'accounts')
    $orderByPart = 'ORDER BY account_id';
else if ($tableName == 'carad_pics')
    $orderByPart = 'ORDER BY carad_id';
?>

<html>
<head>
<title><?=$tableName?></title>

<style type="text/css"><!--
body { font-size:12pt; font-family: verdana, arial, sans-serif; }
<?php if ($tableName == "SHOW TABLES") { ?>
th,td { font-size:12pt; }
<?php } else { ?>
th,td { font-size:10pt; }
<?php } ?>
--></style>

</head>

<body>
<b><?=$tableName?></b><br />
&nbsp;<br />

<table cellspacing="0" cellpadding="3" border="1">


<?php
require_once('database_scripts/autoopen_database.php');


if ($tableName == "SHOW TABLES")
    $query = "SHOW TABLES";
else
    $query = "SELECT * FROM $tableName $orderByPart";

$result = mysql_query($query, $conn);
if (! $result)
    die ("database error. couldn't retrieve table '$tableName': ".mysql_error());

$row = mysql_fetch_assoc($result);

//table header
echo "<tr>\n";
foreach ($row as $colName => $field) {
    echo "  <th align=\"left\">$colName</th>\n";
}
echo "</tr>\n";

//table content
do {
    echo "<tr>\n";

    foreach ($row as $colName => $field) {
        if ($tableName == "SHOW TABLES")
            echo '  <td><a href="'.$_SERVER['SCRIPT_NAME']."?table=$field\">$field</a></td>\n";
        else
            echo "  <td align=\"left\" nowrap>$field&nbsp;</td>\n";
    }

    echo "</tr>\n";
} while ($row = mysql_fetch_assoc($result));

mysql_free_result($result);


?>


</table>
</body>
</html>
