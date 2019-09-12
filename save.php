<?php
if($_POST) {
    define('DATABASE_NAME', 'my_database');
    define('DATABASE_USER', 'username');
    define('DATABASE_PASS', 'password');
    define('DATABASE_HOST', 'localhost');
    include_once('class.DBPDO.php');
    $DB = new DBPDO();
    $DB->execute("INSERT INTO items (`description`, `silver_cost`, `chapter`, `ip`) VALUES(?, ?, ?, ?)", array($_POST['item'], $_POST['silver'], $_COOKIE['chapter'], $_SERVER['REMOTE_ADDR']));
    return '1';
} else {
    die();
}
