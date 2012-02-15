<?php
$CARAD_PICS = 'carad_pics';

require_once('session_check.php');
if (! $SID) require('errorpages/not_logged_in.php');

$carad_id = (int)($_POST['carad_id']);
$picture  =       $_POST['picture' ] ;


require_once('database_scripts/standard_queries.php');


$pictureSql = mysql_real_escape_string($picture);

$carad = getCarad($carad_id);

//if user tries to modify the pictures of a carad which is not his own
if ($carad['account_id'] != $_SESSION['account_id'])
    require('errorpages/denied.php');

$query = "DELETE FROM carad_pics WHERE carad_id=$carad_id AND filename='$pictureSql'";
$result = mysql_query($query, $conn);
if (! $result)
    die ("database error. couldn't remove picture '$picture': ".mysql_error());

if (! mysql_affected_rows($conn))
    die ("couldn't find picture '$picture' in the database.");

$picFilename   = "$CARAD_PICS/$picture.jpg";
$thumbFilename = "$CARAD_PICS/{$picture}_thumb.jpg";

if (! unlink($picFilename))
    $troubleUnlinkingFile = TRUE;

if (! unlink($thumbFilename))
    $troubleUnlinkingFile = TRUE;

if ($troubleUnlinkingFile)
    die ("couldn't remove one or more files of picture '$picture'.");


header("HTTP/1.1 302 Moved Temporarily");
header("Location: picture_manager.php?$SID&carad_id=$carad_id");
?>
