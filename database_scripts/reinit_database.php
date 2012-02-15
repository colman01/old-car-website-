<?php
/*
 * Deletes the database and then recreates it from scratch.
 */


require_once("database.php");


open_database_connection();

dropTables();
//dropDatabase();

require('init_database.php');

echo "finished\n";



/*
 * Drops the current database.
 */
function dropDatabase() {
    global $conn, $db_name;

    $query = "DROP DATABASE $db_name";
    $success = mysql_query($query, $conn);

    //if error while dropping db and error is not "db doesn't exists"
    if (! $success && mysql_errno() != 1008)
        die ("couldn't drop database: ".mysql_error());
}


/*
 * Drops all of the table of the current database.
 */
function dropTables() {
    global $conn;

    select_database();

    //get list of tables
    $query = "SHOW TABLES";
    $result = mysql_query($query, $conn);

    if (! $result)
        die ("database error. couldn't get list of tables: ".mysql_error());

    $tableList = array();
    while ($row = mysql_fetch_row($result)) {
        array_push($tableList, $row[0]);
    }
    mysql_free_result($result);

    //drop every table
    foreach ($tableList as $table) {
        $query = "DROP TABLE $table";
        $success = mysql_query($query, $conn);

        ////if error while dropping table and error is not "table doesn't exists"
        //if error while dropping table
        if (! $success)
            die ("couldn't drop table $table ".
                 "(mysql error code: ".mysql_errno()."): ".mysql_error());
    }
}


?>
