<?php
require_once('mmm_datafiles.php');


$this_month_glink = $_POST["glink_thism"];
$this_month_date  = $_POST["this_month"];
$next_month_glink = $_POST["glink_nextm"];
$next_month_date  = $_POST["next_month"];
$contact_email    = $_POST["clemail"];
$welcome          = $_POST["welcome"];
$directions      = $_POST["directions"];


writeContentToFile($this_month_glink, $FILENAME_THIS_MONTH_GLINK);
writeContentToFile($this_month_date,  $FILENAME_THIS_MONTH_DATE );
writeContentToFile($next_month_glink, $FILENAME_NEXT_MONTH_GLINK);
writeContentToFile($next_month_date,  $FILENAME_NEXT_MONTH_DATE );
writeContentToFile($contact_email,    $FILENAME_CONTACT_EMAIL   );
writeContentToFile($welcome         , $FILENAME_WELCOME         );
writeContentToFile($directions     ,  $FILENAME_DIRECTIONS      );


function writeContentToFile($content, $filename) {
    $result = setFileContent($filename, $content);

    if ($result)
        echo "Success, wrote '$content' to file '$filename'";
    else
        echo "Couldn't write to file '$filename'.";

    echo "<br />\n";
}
?>
