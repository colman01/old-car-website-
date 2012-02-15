<?php
header('Pragma: no-cache');

require_once('session_check.php');
if ($SID) require('errorpages/already_logged_in.php');


$paramList = array(
 'email'   ,
 'password'
);


//extract parameters to be global variables
foreach ($paramList as $param)
    $GLOBALS[$param] = $_POST[$param];


//validity checks for input data

//email
if (! preg_match("/^[A-Za-z0-9._%-]+@[A-Za-z0-9._%-]+\.[A-Za-z]{2,4}$/", $email)) {
    $inputError = TRUE;
    $emailMsg = "Please fill in the email address you used to register an ".
                "account at this website.";
}

//password
if (strlen($password) < 4) {
    $inputError = TRUE;
    $passwordMsg = "The password must have at least 4 characters.";
}

if ($inputError) {
    require('account_login_form.php');
    exit;
}


require_once('database_scripts/autoopen_database.php');


//mysqlify parameters
foreach ($paramList as $param)
    $GLOBALS[$param.'Sql'] = mysql_real_escape_string($GLOBALS[$param]);


$query = "SELECT * FROM accounts WHERE email='$emailSql'";
$result = mysql_query($query, $conn);
if (! $result)
    die("couldn't query database to authenticate you: ".mysql_error());

$row = mysql_fetch_assoc($result);
mysql_free_result($result);


if (! $row) {
    $emailMsg = "The email address $email isn't registered at this website.";
    require('account_login_form.php');
    exit;
}


if ($row['password'] != $password) {
    $passwordMsg = "Wrong password. Please try again.";
    require('account_login_form.php');
    exit;
}


startAccountSession($row['account_id']);


header("HTTP/1.1 302 Moved Temporarily");
header("Location: account_home.php?$SID");
?>
