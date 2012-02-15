<?php
//error files are included by other php-files which do the session check before

$title = "CarLand - Picture Too Big";
require('layout/pagebegin.php');
?>


<font size="3"><b>Picture Too Big</b></font>

<p>
The picture you tried to upload is too big to be handled. Please try uploading a
smaller picture.
</p>


<?php require('layout/pageend.php');
exit;
?>
