<?php

/*
 * This script provides the configuration for the database connection and the
 * opening and selection of the database.
 */


//determine if script is running on production site or development site
$productionSiteList = array(
 'goodcarmarket.com',
 'carland.ie'
);

$isProdSite = FALSE;
$serverName = $_SERVER['SERVER_NAME'];
foreach ($productionSiteList as $site) {
    if (strpos($serverName, $site) !== FALSE) {
        $isProdSite = TRUE;
        break;
    }
}

$db_server = $isProdSite ? 'sql5.hosting365.ie' : 'localhost';
$db_user   = 'colman0_carland';
$db_pass   = 'Faxpaper01';
$db_name   = 'colman0_carland';


/*
 * Opens the connection to the database server, if not already open. If the
 * connection can't be opened, this function dies. The connection is stored in
 * the global variabel $conn.
 */
function open_database_connection() {
    global $conn, $db_server, $db_user, $db_pass, $db_name;

    if ($conn)
        return;

    $conn = @mysql_connect($db_server, $db_user, $db_pass);

    if (! $conn)
        die ("couldn't connect to database server: ".mysql_error()."\n");
}

/*
 * Selects the database. If the database doesn't exist, this function tries to
 * create the database and then select it. If in the end the database couldn't
 * be selected, the function dies.
 * The connection to the database is opened automatically if not already open.
 */
function select_database($autocreate = FALSE) {
    global $conn, $db_name;

    open_database_connection();

    $success = mysql_select_db($db_name, $conn);

    if ($success)
        return;

    if (mysql_errno($conn) == 1049) {   //if database doesn't exist
        require('init_database.php');

        $success = mysql_select_db($db_name, $conn);

        if ($success)
            return;
    }

    //else:
    die ("couldn't select database: ".mysql_error($conn));
}

?>
