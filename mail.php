

<?php
// get contents of a file into a string
$filename = "/www.goodcarmarket.com/mmm_datafiles/contact_email.txt";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
echo $contents;
fclose($handle);
?> 