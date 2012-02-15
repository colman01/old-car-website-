<?php
require_once('session_check.php');
if (! $SID) require('errorpages/not_logged_in.php');

require_once('database_scripts/standard_queries.php');
require_once('mmm_datafiles.php');
$this_month_date  = getFileContent($FILENAME_THIS_MONTH_DATE );
$next_month_date  = getFileContent($FILENAME_NEXT_MONTH_DATE );


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
 'power'          => 'int',
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
foreach ($paramList as $paramName => $paramType)
    eval("\$$paramName = \$_POST['$paramName'];");


//mysqlify parameters
foreach ($paramList as $paramName => $paramType) {
    if ($paramType == 'string')
        eval("\$$paramName"."Sql = \"'\".mysql_real_escape_string(\$$paramName).\"'\";");
    else if ($paramType == 'bool')
        eval("\$$paramName"."Sql = isset(\$$paramName) ? 1 : 0;");
    else
        eval("\$$paramName"."Sql = ($paramType)(\$$paramName);");
}


if ($otherMakeCheck ) {
    $make     = $otherMake ;
    $makeSql  = $otherMakeSql ;
}
if ($otherModelCheck) {
    $model    = $otherModel;
    $modelSql = $otherModelSql;
}
if ($otherTypeCheck ) {
    $type     = $otherType ;
    $typeSql  = $otherTypeSql ;
}


//update db with other make, model and type if specified
$makeId = getMakeId($make);

//make
if ($otherMakeCheck && $makeId == -1) {
    $isNewMake = TRUE;

    $query = "INSERT INTO makes (make_id, name) VALUES (NULL, $makeSql)";
    $result = mysql_query($query, $conn);
    if (! $result)
        die ("datebase error. couldn't insert make $make into ".
             "table of makes: ".mysql_error());

    $makeId = mysql_insert_id($conn);
}

//model
if ($otherModelCheck || $isNewMake) {
    $modelList = getModelNameList($make);

    if (in_array($otherModel, $modelList))
        break;

    $query = "INSERT INTO models (name, make_id) VALUES ($modelSql, $makeId)";

    $result = mysql_query($query, $conn);
    if (! $result) {
        die ("datebase error. couldn't insert model '$model' into ".
             "table of models: ".mysql_error());
    }
}

//type
if ($otherTypeCheck) {
    $typeList = getNameList('types');

    if (in_array($otherType, $typeList))
        break;

    $query = "INSERT INTO types (name) VALUES ($typeSql)";
    $result = mysql_query($query, $conn);

    if (! $result) {
        die ("datebase error. couldn't insert type '$type' into ".
             "table of types: ".mysql_error());
    }
}


$account_idSql = $_SESSION['account_id'];
$timestampSql  = time();


$query = "INSERT INTO carads (".
 'carad_id      , '.
 'account_id    , '.
 'make          , '.
 'model         , '.
 'type          , '.
 'colour        , '.
 'caption       , '.
 'description   , '.
 'year          , '.
 'nct_year      , '.
 'nct_month     , '.
 'engine        , '.
 'doors         , '.
 'fuel          , '.
 'transm        , '.
 'price         , '.
 'seats         , '.
 'mileage       , '. 
 'power         , '.
 'timestamp     , '.
 'attendsThisMmm,  '.
 'attendsNextMmm  '.
') VALUES ('.
 "NULL, ".
 "$account_idSql, ".
 "$makeSql, ".
 "$modelSql, ".
 "$typeSql, ".
 "$colourSql, ".
 "$captionSql, ".
 "$descriptionSql, ".
 "$yearSql, ".
 "$nct_yearSql, ".
 "$nct_monthSql, ".
 "$engineSql, ".
 "$doorsSql, ".
 "$fuelSql, ".
 "$transmSql, ".
 "$priceSql, ".
 "$seatsSql, ".
 "$mileageSql, ". 
 "$powerSql, ".
 "$timestampSql, ".
 "$attendsThisMmmSql, ".
 "$attendsNextMmmSql ".
")";

$result = mysql_query($query, $conn);
if (! $result)
	die ("problem with database. couldn't insert carad: ".mysql_error());

$carad_id = mysql_insert_id($conn); //get the id which was assigned to our carad
if (! $carad_id)
	die ("problem with database. couldn't locate new carad: ".mysql_error());


if ($attendsThisMmm || $attendsNextMmm) {
    $account = getAccount($_SESSION['account_id']);

    $caradLink = "http://{$_SERVER['SERVER_NAME']}/carad_view.php?carad_id=$carad_id";

    $to      = 'colman01@gmail.com, mrneilbrady@hotmail.com';
    $subject = 'New Car Entry';
    $message =
     "A new carad has been entered and the owner plans to visit the car\n".
     "markets at:\n".
     ($attendsThisMmm ? "$this_month_date\n" : "\n").
     ($attendsNextMmm ? "$next_month_date\n" : "\n").
     "\n".
     "Owner: {$account['firstname']} {$account['lastname']}\n".
     "View Car Ad:\n".
     "$caradLink\n".
     "\n".
     "$caption\n".
     "Make : $make\n".
     "Model: $model\n".
     "Description:\n".
     "$description\n"
    ;
    $headers = 'From: carLand' . "\r\n" .
       'Reply-To: mrneilbrady@hotmail.com, colman01@gmail.com' . "\r\n" .
       'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
}


header("HTTP/1.1 302 Moved Temporarily");
header("Location: carad_view.php?$SID&carad_id=$carad_id");
?>
