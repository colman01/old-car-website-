<?php
//error files are included by other php-files which do the session check before

$title = "CarLand - Picture Missing";
require('layout/pagebegin.php');
?>


<font size="3"><b>Picture Missing</b></font>

<p>
Please go back an put in the name of the picture that you want to upload. You
can click the button next to the line of where to enter the picture name to
browse for a picture on your computer.
</p>


<?php require('layout/pageend.php');
exit;
?>
