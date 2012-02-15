<?php
header('Pragma: no-cache');

require_once('session_check.php');
if ($SID) require('errorpages/already_registered.php');


$paramList = array(
 'firstname'       => 'string',
 'lastname'        => 'string',
 'email'           => 'string',
 'isEmailPublic'   => 'bool'  ,
 'password'        => 'string',
 'password_rep'    => 'string',
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

//password
if (strlen($password) < 4) {
    $inputError = TRUE;
    $passwordMsg = "The password must have at least 4 characters.";
}

//password_rep
if ($password_rep != $password) {
    $inputError = TRUE;
    $password_repMsg = "The password and the repeated password must be equal.";
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
    require('account_register_form.php');
    exit;
}


require_once('database_scripts/autoopen_database.php');


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


//check if email is already present
//query = "SELECT count(*) as occurences FROM accounts WHERE email='$emailSql'";
$query = "SELECT * FROM accounts WHERE email=$emailSql";
$result = mysql_query($query, $conn);
if (! $result)
    die ("couldn't check if email address already present:\n".mysql_error());

$row = mysql_fetch_row($result);
mysql_free_result($result);
$present = $row[0];


if ($present) {
    $emailMsg = "The email address $email is already registered. Please ".
                "choose another one.";

    unset($email);
    require('account_register_form.php');
    exit;
} 


//add new account
$query = "INSERT INTO accounts (".
 "account_id   , ".
 "firstname    , ".
 "lastname     , ".
 "email        , ".
 "isEmailPublic, ".
 "password     , ".
 "address      , ".
 "city         , ".
 "phone       ".
") VALUES (".
 "NULL, ".
 "$firstnameSql, ".
 "$lastnameSql, ".
 "$emailSql, ".
 "$isEmailPublicSql, ".
 "$passwordSql, ".
 "$addressSql, ".
 "$citySql, ".
 "$phoneSql".
")";


$result = mysql_query($query, $conn);
if (! $result)
	die ("sorry, couldn't register you due to a database error: ".mysql_error());

$account_id = mysql_insert_id($conn); //get the id which was assigned to the user
if (! $account_id)
	die ("unknwown problem with database: ".mysql_error());


startAccountSession($account_id);


header("HTTP/1.1 302 Moved Temporarily");
header("Location: account_home.php?$SID");
?>
