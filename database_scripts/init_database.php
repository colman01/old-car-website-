<?php
/*
 * Include (require) this file to ensures that the database is present and
 * initialized. If the database is not present, it will be created by this file.
 * If that doesn't work and in the end, the database wasn't present and couldn't
 * be created, this script dies (stops execution).
 * This file expects that a variable $conn is present which represents an open
 * connection to the database server.
 */


$tableCreatingStatements = Array(
 'CREATE TABLE accounts ('.
    'account_id     INT           NOT NULL AUTO_INCREMENT, '.
    'email          VARCHAR(100)  NOT NULL, '.
    'isEmailPublic   BOOL         NOT NULL, '.
    'password       VARCHAR( 50)  NOT NULL, '.
    'firstname      VARCHAR(200)  NOT NULL, '.
    'lastname       VARCHAR(200)  NOT NULL, '.
    'address        VARCHAR(200)  NOT NULL, '.
    'city           VARCHAR(200)  NOT NULL, '.
    'phone          VARCHAR(200)  NOT NULL, '.
    'PRIMARY KEY(account_id)'.
 ')',
 'CREATE TABLE carads ('.
    'carad_id       INT           NOT NULL AUTO_INCREMENT, '.
    'account_id     INT           NOT NULL, '.
    'make           VARCHAR(100)  NOT NULL, '.
    'model          VARCHAR(200)  NOT NULL, '.
    'type           VARCHAR(200)  NOT NULL, '.
    'colour         VARCHAR( 20)  NOT NULL, '.
    'caption        VARCHAR(100)  NOT NULL, '.
    'description    TEXT          NOT NULL, '.
    'year           INT           NOT NULL, '.
    'engine         FLOAT         NOT NULL, '.
    'doors          INT           NOT NULL, '.
    'fuel           VARCHAR( 50)  NOT NULL, '.
    'transm         VARCHAR( 50)  NOT NULL, '.
    'price          FLOAT         NOT NULL, '.
    'seats          INT           NOT NULL, '.
    'mileage        INT           NOT NULL, '.
    'power          INT           NOT NULL, '.
    'timestamp      INT           NOT NULL, '.
    'attendsThisMmm BOOL          NOT NULL, '.
    'attendsNextMmm BOOL          NOT NULL, '.
    'PRIMARY KEY(carad_id)'.
 ')',
 'CREATE TABLE carad_pics ('.
    'filename       VARCHAR(100)  NOT NULL, '.
    'carad_id       INT           NOT NULL, '.
    'PRIMARY KEY(filename)'.
 ')',
 'CREATE TABLE makes ('.
    'make_id        INT           NOT NULL AUTO_INCREMENT, '.
    'name           VARCHAR(100)  NOT NULL, '.
    'PRIMARY KEY(make_id)'.
 ')',
 'CREATE TABLE models ('.
    'name           VARCHAR(200)  NOT NULL, '.
    'make_id        INT           NOT NULL, '.
    'PRIMARY KEY(name, make_id)'.
 ')',
 'CREATE TABLE types ('.
    'name           VARCHAR(200)  NOT NULL, '.
    'PRIMARY KEY(name)'.
 ')',
 'CREATE TABLE colours ('.
    'name          VARCHAR(200)   NOT NULL, '.
    'PRIMARY KEY(name)'.
 ')',
 'CREATE TABLE fuels ('.
    'name          VARCHAR(50)    NOT NULL, '.
    'PRIMARY KEY(name)'.
 ')'
);


$success = mysql_query("CREATE DATABASE $db_name", $conn);

if (! $success) {
    if (mysql_errno($conn) != 1007) //if we can't create and it doesn't exist
        die ("couldn't create database: ".mysql_error($conn));
}

//if this line is reached, the database exists
//select the database
$success = mysql_select_db($db_name, $conn);

if (! $success) //we should be able to select it
    die ("couldn't select database for initialization: ".
     mysql_error($conn));

//if this line is reached, the database was selected successfully
//create tables
foreach ($tableCreatingStatements as $statement) {
    $success = mysql_query($statement, $conn);

    if ($success)
        continue;

    if (mysql_errno($conn) == 1050)  //if table already exists
        continue;

    die (
     "couldn't create table with statement:<br />\n".
     $statement."<br />\n".
     "error: ".mysql_error($conn)."<br />\n"
    );
}



//create testdata
$statementList = Array(
 'INSERT INTO accounts ('.
    'account_id   , '.
    'email        , '.
    'isEmailPublic, '.
    'password     , '.
    'firstname    , '.
    'lastname     , '.
    'address      , '.
    'city         , '.
    'phone          '.
 ') VALUE ('.
    'NULL, '.
    "'a@a.com', ".
    "0,",
    "'hello', ".
    "'John', ".
    "'Smith', ".
    "'Carnegie Rd 15', ".
    "'Frogmoore', ".
    "'0407-12345678'".
 ')',
 'INSERT INTO carads ('.
    'carad_id   ,'.
    'account_id ,'.
    'make       ,'.
    'model      ,'.
    'type       ,'.
    'colour     ,'.
    'caption    ,'.
    'description,'.
    'year       ,'.
    'engine     ,'.
    'doors      ,'.
    'fuel   ,'.
    'transm     ,'.
    'price      ,'.
    'seats      ,'.
    'mileage    ,'.
    'power       '.
 ') VALUES ('.
    'NULL, '.
    '1, '.
    "'Toyota', ".
    "'Land Cruiser', ".
    "'Hatchback', ".
    "'olive brown', ".
    "'With this car, you can go anywhere!', ".
    "'I used this car for roughly 9 years now. It is absolutely reliable.', ".
    "1993, ".
    "4.0, ".
    "5, ".
    "'Diesel', ".
    "'Manual', ".
    "16000, ".
    "5, ".
    "327000, ".
    "'70kW' ".
 ')',
 'INSERT INTO carads ('.
    'carad_id   ,'.
    'account_id ,'.
    'make       ,'.
    'model      ,'.
    'type       ,'.
    'colour     ,'.
    'caption    ,'.
    'description,'.
    'year       ,'.
    'engine     ,'.
    'doors      ,'.
    'fuel   ,'.
    'transm     ,'.
    'price      ,'.
    'seats      ,'.
    'mileage    ,'.
    'power       '.
 ') VALUES ('.
    'NULL, '.
    '1, '.
    "'VW', ".
    "'Golf', ".
    "'Hatchback', ".
    "'black', ".
    "'A Used Car, From a Beginner for a Beginner', ".
    "'This is a placeholder for a real car description.', ".
    "1981, ".
    "1.9, ".
    "3, ".
    "'diesel', ".
    "'manual', ".
    "3000, ".
    "5, ".
    "229175, ".
    "'50kW' ".
 ')',
 'INSERT INTO carads ('.
    'carad_id   ,'.
    'account_id ,'.
    'make       ,'.
    'model      ,'.
    'type       ,'.
    'colour     ,'.
    'caption    ,'.
    'description,'.
    'year       ,'.
    'engine     ,'.
    'doors      ,'.
    'fuel   ,'.
    'transm     ,'.
    'price      ,'.
    'seats      ,'.
    'mileage    ,'.
    'power       '.
 ') VALUES ('.
    'NULL, '.
    '1, '.
    "'Porsche', ".
    "'Carrera GT 2', ".
    "'Cabriolet', ".
    "'light metallic grey', ".
    "'For the wealthy people...', ".
    "'This is a wonderful car for your leisure time.', ".
    "2006, ".
    "3.5, ".
    "3, ".
    "'petrol', ".
    "'automatic', ".
    "255000, ".
    "2, ".
    "11243, ".
    "'220Ps' ".
 ')',
 'INSERT INTO carads ('.
    'carad_id   ,'.
    'account_id ,'.
    'make       ,'.
    'model      ,'.
    'type       ,'.
    'colour     ,'.
    'caption    ,'.
    'description,'.
    'year       ,'.
    'engine     ,'.
    'doors      ,'.
    'fuel   ,'.
    'transm     ,'.
    'price      ,'.
    'seats      ,'.
    'mileage    ,'.
    'power       '.
 ') VALUES ('.
    'NULL, '.
    '1, '.
    "'Ferrari', ".
    "'360 Challenge', ".
    "'Sports Car', ".
    "'red', ".
    "'Fun Racing', ".
    "'Just have a look at it, what an attractive design. Unbeatable!!', ".
    "2005, ".
    "5.0, ".
    "2, ".
    "'petrol', ".
    "'automatic', ".
    "142340, ".
    "2, ".
    "77300, ".
    "'320kW' ".
 ')',

 "INSERT INTO carad_pics (filename, carad_id) VALUES ".
 "('toyota_land_cruiser'  , 1), ".
 "('porsche_carrera1'     , 3), ".
 "('porsche_carrera2'     , 3), ".
 "('porsche_carrera3'     , 3),  ".
 "('ferrari_360_challenge', 4)  ".
 "",

 "INSERT INTO makes (make_id, name) VALUES ".
 "(1, 'Toyota'  ), ".
 "(2, 'Mercedes'), ".
 "(3, 'BMW'     ), ".
 "(4, 'Porsche' ), ".
 "(5, 'Ford'    ), ".
 "(6, 'Ferrari' )  ".
 "",

 "INSERT INTO models (name, make_id) VALUES ".
 "('Corolla',      1), ".
 "('Avensis',      1), ".
 "('Land Cruiser', 1), ".
 "('A Class',      2), ".
 "('B Class',      2), ".
 "('C Class',      2), ".
 "('S Class',      2), ".
 "('X3'     ,      3), ".
 "('X5'     ,      3), ".
 "('Z3'     ,      3), ".
 "('Z4'     ,      3), ".
 "('Carrera',      4), ".
 "('Model T',      5), ".
 "('Glaxy'  ,      5), ".
 "('Mustang',      5), ".
 "('308',          6), ".
 "('328',          6), ".
 "('355',          6)  ".
 "",

 "INSERT INTO types     (name) VALUES ".
 "('Cabriolet' ), ".
 "('Coupe'     ), ".
 "('Estate'    ), ".
 "('Hatchback' ), ".
 "('Micro-Car' ), ".
 "('Mini MPV'  ), ".
 "('MPV'       ), ".
 "('Saloon'    ), ".
 "('SUV'       )  ".
 "",

 "INSERT INTO colours   (name) VALUES ".
 "('red'  ), ".
 "('green'), ".
 "('blue' )  ".
 "",

 "INSERT INTO fuels     (name) VALUES ".
 "('diesel'  ), ".
 "('petrol'  ), ".
 "('electric')  ".
 ""
);


foreach ($statementList as $statement) {
    $success = mysql_query($statement, $conn);

    if (! $success) {
        die (
         "couldn't insert testdata with statement:<br />\n".
         $statement."<br />\n".
         "error: ".mysql_error($conn)."<br />\n"
        );
    }
}


?>
