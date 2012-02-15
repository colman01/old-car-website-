<?php
//image processing sometimes needs a bit more memory
ini_set("memory_limit", "256M");


$RANDOM_NAME_LENGTH = 16;
$UPLOAD_DIR         = 'carad_pics';

$PICTURE_WIDTH      = 640;
$PICTURE_HEIGHT     = 480;
$THUMB_WIDTH        = 140;
$THUMB_HEIGHT       = 105;


header('Pragma: no-cache');


require_once('IMT_imageToolkit.php');
require_once('session_check.php');
if (! $SID) require('errorpages/not_logged_in.php');

$carad_id = (int)($_POST['carad_id']);


$errCode = $_FILES['pictureFile']['error'];
if      ($errCode == UPLOAD_ERR_OK) {}
else if ($errCode == UPLOAD_ERR_INI_SIZE || $errCode == UPLOAD_ERR_FORM_SIZE)
    require('errorpages/picturefile_too_big.php');
else if ($errCode == UPLOAD_ERR_PARTIAL)
    require('errorpages/picturefile_upload_failed.php');
else if ($errCode == UPLOAD_ERR_NO_FILE)
    require('errorpages/picturefile_missing.php');


require_once('database_scripts/standard_queries.php');
$carad = getCarad($carad_id);


//if user tries to modify the pictures of a carad which is not his own
if ($carad['account_id'] != $_SESSION['account_id'])
    require('errorpages/denied.php');


//check filetype
$extension = IMT_getFileExtension($_FILES['pictureFile']['name']);
if (! in_array($extension, array('png', 'jpg', 'gif', 'jpeg')))
    require('errorpages/picturetype_not_allowed.php');

//create random name
$randomName = '';
for ($i = 0; $i < $RANDOM_NAME_LENGTH; $i++) {
    $rnd = rand(0, 61);
    if ($rnd < 26)
        $randomName .= chr(ord('A') + $rnd);
    else if ($rnd < 52)
        $randomName .= chr(ord('a') + $rnd - 26);
    else
        $randomName .= chr(ord('0') + $rnd - 52);
}


//convert picture file and create thumbnail
$targetFilename = "$UPLOAD_DIR/$randomName.jpg";
$thumbFilename  = "$UPLOAD_DIR/{$randomName}_thumb.jpg";
$tmpFilename    = $_FILES['pictureFile']['tmp_name'];

//put to usual size
$im = IMT_loadImage($tmpFilename);
$targetIm = IMT_getImageFitToSize($im, $PICTURE_WIDTH, $PICTURE_HEIGHT);
imagedestroy($im);

IMT_saveImage($targetIm, $targetFilename);

//create thumbnail out of resized version - so we don't have to resample
//veeery big stuff twice
$thumbIm  = IMT_getImageCutToSize($targetIm, $THUMB_WIDTH  , $THUMB_HEIGHT  );
IMT_saveImage($thumbIm, $thumbFilename);

imagedestroy($targetIm);
imagedestroy($thumbIm);



$query = "INSERT INTO carad_pics (filename, carad_id) VALUES ('$randomName', $carad_id)";
$result = mysql_query($query, $conn);
if (! $result)
    die("database error. couldn't insert picture into database: ".mysql_error());


header("HTTP/1.1 302 Moved Temporarily");
header("Location: picture_manager.php?$SID&carad_id=$carad_id");
?>
