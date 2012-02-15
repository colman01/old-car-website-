<?php

$DATAFILES_DIR = 'mmm_datafiles';

$FILENAME_THIS_MONTH_GLINK = "$DATAFILES_DIR/this_month_glink.txt";
$FILENAME_THIS_MONTH_DATE  = "$DATAFILES_DIR/this_month_date.txt";
$FILENAME_NEXT_MONTH_GLINK = "$DATAFILES_DIR/next_month_glink.txt";
$FILENAME_NEXT_MONTH_DATE  = "$DATAFILES_DIR/next_month_date.txt";
$FILENAME_CONTACT_EMAIL    = "$DATAFILES_DIR/contact_email.txt";
$FILENAME_DIRECTIONS       = "$DATAFILES_DIR/directions.txt";
$FILENAME_WELCOME          = "$DATAFILES_DIR/welcome.txt";


/*
 * Reads in and returns the content of the specified file. If not possible,
 * FALSE is returned.
 */
function getFileContent($filename) {
    $fh = fopen($filename, "r");

    if (! $fh)
        return FALSE;

    $content = fread($fh, filesize($filename));
    fclose($fh);

    return $content;
}


/*
 * Overwrites the specified file with the specified content. Returns TRUE on
 * success and FALSE on failure.
 */
function setFileContent($filename, $content) {
    $fh = fopen($filename, 'w');
    if (! $fh)
        return FALSE;

    $writeResult = fwrite($fh, $content);
    if ($writeResult === FALSE || $writeResult != strlen($content))
        return FALSE;

    fclose($fh);

    return TRUE;
}

?>
