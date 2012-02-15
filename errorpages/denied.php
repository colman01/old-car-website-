<?php
//error files are included by other php-files which do the session check before

$title = "CarLand - Denied";
require('layout/pagebegin.php');
?>


<font size="3"><b>Denied</b></font>

<p>
The action you tried to take was denied.
</p>
<p>
The reason might be that you are not logged in to the right account.
</p>


<?php require('layout/pageend.php');
exit;
?>
