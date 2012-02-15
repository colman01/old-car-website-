<?php
/*
 * This script provides some functions for frequently used database queries.
 */


require_once('autoopen_database.php');


/*
 * Deletes the specified carad. The carad must be in the same format as returned
 * by the gerCarad(...) function.
 */
function deleteCarad($carad) {
    global $conn;

    //delete all pictures
    $query = "DELETE FROM carad_pics WHERE carad_id=".$carad['carad_id'];
    $result = mysql_query($query, $conn);
    if (! $result)
        die ("database error. couldn't remove pictures from database: ".mysql_error());

    foreach ($carad['picList'] as $picture) {
        $filename = "$CARAD_PICS/$picture.jpg";
        if (! file_exists($filename))
            continue;
        if (! unlink($filename))
            die ("couldn't remove the picture file '$picture'.");

        $filename = "$CARAD_PICS/{$picture}_thumb.jpg";
        if (! file_exists($filename))
            continue;
        if (! unlink($filename))
            die ("couldn't remove the picture file '$picture'.");
    }

    //delete car ad entry
    $query = "DELETE FROM carads WHERE carad_id=".$carad['carad_id'];
    $result = mysql_query($query, $conn);
    if (! $result)
        die ("database error. couldn't remove carad from database: ".mysql_error());
}


/**
 * Returns the result set of the specified query, or FALSE on failure. In the
 * latter case, you can use mysql_errno() and mysql_error() to examine the
 * occurred error.
 */
function getResultSet($query) {
    global $conn;

    $result = mysql_query($query, $conn);
    if (! $result)
        return FALSE;

    $rowList = array();
    while ($row = mysql_fetch_assoc($result))
        array_push($rowList, $row);

    mysql_free_result($result);

    return $rowList;
}


/*
 * Returns the account information for the specified account_id.
 */
function getAccount($account_id) {
    global $conn;

    $query = "SELECT * FROM accounts WHERE account_id=$account_id";
    $result = mysql_query($query, $conn);
    if (! $result)
        die("database error. couldn't retrieve account information: ".
            mysql_error());

    $data = mysql_fetch_assoc($result);
    mysql_free_result($result);

    if (! $data)
        die("couldn't find account info in database for account_id ".
            "$account_id.");

    return $data;
}


/*
 * Returns the car ad information for the specified carad_id, including the list
 * of pictures.
 */
function getCarad($carad_id) {
    global $conn;

    $query = "SELECT * FROM carads WHERE carad_id=$carad_id";

    $result = mysql_query($query, $conn);

    if (! $result)
        die("database error. couldn't retrieve carad information: ".
            mysql_error());

    $data = mysql_fetch_assoc($result);
    mysql_free_result($result);

    if (! $data)
        die("couldn't find carad info in database for carad_id ".
            "$carad_id.");

    //list of pictures
    $data['picList'] = getPicturesOfCarad($carad_id);

    return $data;
}


/*
 * Returns the number of carads that are in the account with the specified
 * account id.
 */
function getCaradCountOfAccount($account_id) {
    global $conn;

    $query = "SELECT count(*) FROM carads WHERE account_id=".$_SESSION['account_id'];

    $result = mysql_query($query, $conn);

    if (! $result)
        die("database error. couldn't retrieve number of your carads: ".mysql_error());

    $row = mysql_fetch_row($result);
    mysql_free_result($result);

    return $row[0];
}


/*
 * Returns the list of carads which were registered through the account with the
 * specified account_id. The carads include the pictures.
 */
function getCaradsOfAccount($account_id) {
    global $conn;

    $query = "SELECT * FROM carads WHERE account_id=".$_SESSION['account_id'];

    $result = mysql_query($query, $conn);

    if (! $result)
        die("database error. couldn't retrieve list of your carads: ".mysql_error());

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

    return $caradList;
}


/*
 * Returns the list of pictures associated with the carad of the specifed id.
 */
function getPicturesOfCarad($carad_id) {
    global $conn;
    $query = "SELECT filename FROM carad_pics WHERE carad_id=$carad_id";

    $result = mysql_query($query, $conn);

    if (! $result)
        die ("database error. couldn't retrieve list of pictures for carad ".
             "with id $carad_id: ".mysql_error());

    $picList = array();
    while ($row = mysql_fetch_row($result)) {
        array_push($picList, $row[0]);
    }

    mysql_free_result($result);

    return $picList;
}


/*
 * Returns the corresponding make id for the given make name. If the model can't
 * be found, -1 is returned.
 */
function getMakeId($makeName) {
    global $conn;

    $makeName = mysql_real_escape_string($makeName);

    $query = "SELECT make_id FROM makes WHERE name='$makeName'";

    $result = mysql_query($query, $conn);
    if (! $result)
    	die("database error. couldn't retrieve make id for ".
            "make name $makeName: ".mysql_error());

    $row = mysql_fetch_row($result);
    mysql_free_result($result);

    return $row[0] ? $row[0] : -1;
}


/*
 * Retrieves all the names of models for the given make name.
 */
function getModelNameList($makeName) {
    global $conn;

    $makeId = getMakeId($makeName);
    if ($makeId == -1)
        die ("no make id available. can't find make name '$makeName'.");

    $query = "SELECT name FROM models WHERE make_id=$makeId";

    $result = mysql_query($query, $conn);
    if (! $result)
    	die("database error. couldn't retrieve model names for ".
            "make id $makeId: ".mysql_error());

    $resultList = Array();
    while ($row = mysql_fetch_row($result)) {
    	array_push($resultList, $row[0]);
    }

    mysql_free_result($result);

    return $resultList;
}


/*
 * Retrieves all the names found in the specified mysql table. This is for list
 * of makes, colours, etc..
 */
function getNameList($tableName) {
    global $conn;

    $query = "SELECT name FROM $tableName";

    $result = mysql_query($query, $conn);
    if (! $result)
    	die ("couldn't retrieve names from table $tableName: ".mysql_error());

    $resultList = Array();

    while ($resultRow = mysql_fetch_row($result)) {
    	array_push($resultList, $resultRow[0]);
    }

    mysql_free_result($result);

    return $resultList;
}


/*
 * Returns a string of JavaScript code ready to be put in to an html page
 * for hiding the provided email addres from bad bots.
 */
function getJavaScriptEmailHiding($email) {
    $len = strlen($email);
    $part1 = '"'.substr($email,        0, $len / 2).'"';
    $part2 = '"'.substr($email, $len / 2, $len    ).'"';

    return
     "<script language=\"JavaScript\"><!--\n".
     "var r = $part1 + $part2;\n".
     'document.write("<a href=\\"mailto:" + r + "\\">" + r + "</a>");'."\n".
     "--></script>\n";
}


/*
 * Converts an epoch time to a time/date string, ready for being put into html.
 */
function getTimeDateString($epochSecs) {
    $monthDay     = date('F j', $epochSecs);
    $dayExtension = date('S', $epochSecs);
    $yearEntered  = date('Y', $epochSecs);
    return "$monthDay<sup>$dayExtension</sup> $yearEntered";
}

?>
