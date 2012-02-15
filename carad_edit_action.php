<?php

require_once('session_check.php');
if (! $SID) require('errorpages/not_logged_in.php');

require_once('database_scripts/standard_queries.php');

$carad_id = (int)($_POST['carad_id']);
$carad = getCarad($carad_id);


//if user tries to modify a carad which is not his own
if ($carad['account_id'] != $_SESSION['account_id'])
    require('errorpages/denied.php');


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
    $modelList = getModelList($make);

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


$query = "REPLACE INTO carads SET ".
 "carad_id       = $carad_id, ".
 "account_id     = $account_idSql, ".
 "make           = $makeSql, ".
 "model          = $modelSql, ".
 "type           = $typeSql, ".
 "colour         = $colourSql, ".
 "caption        = $captionSql, ".
 "description    = $descriptionSql, ".
 "nct_year       = $yearSql, ".
 "nct_month      = $yearSql, ".
 "year           = $yearSql, ".
 "engine         = $engineSql, ".
 "doors          = $doorsSql, ".
 "fuel           = $fuelSql, ".
 "transm         = $transmSql, ".
 "price          = $priceSql, ".
 "seats          = $seatsSql, ".
 "mileage        = $mileageSqlm ".
 "timestamp      = $timestampSql, ".
 "attendsThisMmm = $attendsThisMmmSql, ".
 "attendsNextMmm = $attendsNextMmmSql ".
"";

$result = mysql_query($query, $conn);
if (! $result)
	die ("problem with database. couldn't insert carad: ".mysql_error());


header("HTTP/1.1 302 Moved Temporarily");
header("Location: carad_view.php?$SID&carad_id=$carad_id");
?>
