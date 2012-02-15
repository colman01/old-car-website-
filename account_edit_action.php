<?php
header('Pragma: no-cache');

require_once('session_check.php');
if (! $SID) require('errorpages/not_logged_in.php');


$paramList = array(
 'firstname'       => 'string',
 'lastname'        => 'string',
 'email'           => 'string',
 'isEmailPublic'   => 'bool'  ,
 'curPassword'     => 'string',
 'newPassword'     => 'string',
 'newPassword_rep' => 'string',
 'address'         => 'string',
 'city'            => 'string',
 'phone'           => 'string'
);


//extract parameters to be global variables
foreach ($paramList as $paramName => $paramType)
    $GLOBALS[$paramName] = $_POST[$paramName];


//validity checks for input data

//email
if (! preg_match("/^[A-Za-z0-9._%-]+@[A-Za-z0-9._%-]+\.[A-Za-z]{2,4}$/", $email)) {
    $inputError = TRUE;
    $emailMsg = "Please fill in a valid, working email address.";
}

//isEmailPublic
if ($isEmailPublic != 'yes' && $isEmailPublic != 'no') {
    $inputError = TRUE;
    $emailMsg = "This may either be yes or no.";
}

//newPassword
if (strlen($newPassword) < 4 && $newPassword != "") {
    $inputError = TRUE;
    $newPasswordMsg = "The password must have at least 4 characters.";
}

//newPassword_rep
if ($newPassword_rep != $password) {
    $inputError = TRUE;
    $newPassword_repMsg = "The new password and the repeated new password must be equal.";
}

//firstname
if (strlen($firstname) == 0) {
    $inputError = TRUE;
    $firstnameMsg = "Please fill in your first name.";
}

//lastname
if (strlen($lastname) == 0) {
    $inputError = TRUE;
    $lastnameMsg = "Please fill in your last name.";
}

//address, city, and phone remain unchecked

if ($inputError) {
    require('account_edit_form.php');
    exit;
}


require_once('database_scripts/standard_queries.php');
$account = getAccount($_SESSION['account_id']);


//check current password for correctness
if ($curPassword != $account['password']) {
    $curPasswordMsg = "Wrong password. Please try again.";
    require('account_edit_form.php');
    exit;
}


//mysqlify parameters
if ($isEmailPublic != 'yes')
    unset($isEmailPublic);

foreach ($paramList as $paramName => $paramType) {
    if ($paramType == 'string')
        $GLOBALS[$paramName.'Sql'] = "'".mysql_real_escape_string($GLOBALS[$paramName])."'";
    else if ($paramType == 'bool')
        $GLOBALS[$paramName.'Sql'] = isset($GLOBALS[$paramName]) ? 1 : 0;
    else
        eval("\$$paramName"."Sql = ($paramType)(\$$paramName);");
}

$passwordSql      = ($newPassword != "") ? $newPasswordSql : $curPasswordSql;
$account_idSql    = $_SESSION['account_id'];

//update account
$query = "REPLACE INTO accounts SET ".
 "account_id    = $account_idSql   , ".
 "firstname     = $firstnameSql    , ".
 "lastname      = $lastnameSql     , ".
 "email         = $emailSql        , ".
 "isEmailPublic = $isEmailPublicSql, ".
 "password      = $passwordSql     , ".
 "address       = $addressSql      , ".
 "city          = $citySql         , ".
 "phone         = $phoneSql          ".
"";

$result = mysql_query($query, $conn);
if (! $result)
	die ("database error. couldn't save account details: ".mysql_error());


header("HTTP/1.1 302 Moved Temporarily");
header("Location: account_details_view.php?$SID");
?>
