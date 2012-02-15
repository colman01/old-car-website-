<?php
//error files are included by other php-files which do the session check before

$title = "CarLand - Carad Not Found";
require('layout/pagebegin.php');
?>


<font size="3"><b>Carad Not Found</b></font>

<p>
It was impossible to find the car ad with ID <?=$carad_id?>. You can
<a href="carad_browse.php">browse the car ads</a> again and find the car you
want.
</p>


<?php require('layout/pageend.php');
exit;
?>
