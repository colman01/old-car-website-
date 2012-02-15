<?php
//error files are included by other php-files which do the session check before

$title = "CarLand - Picture Upload Failed";
require('layout/pagebegin.php');
?>


<font size="3"><b>Picture Upload Failed</b></font>

<p>
The picture could be completely received. Please try again.
</p>


<?php require('layout/pageend.php');
exit;
?>
