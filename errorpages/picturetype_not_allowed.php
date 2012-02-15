<?php
//error files are included by other php-files which do the session check before

$title = "CarLand - Picture Upload Failed";
require('layout/pagebegin.php');
?>


<font size="3"><b>Picture Upload Failed</b></font>

<p>
The type of file you tried to upload is not recognized as picture file type.
Please only upload files in one of the formats JPG, JPEG, PNG and GIF.
</p>


<?php require('layout/pageend.php');
exit;
?>
