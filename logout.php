
<?php
session_start();

function __autoload($class_name) {
    include 'classes/'.$class_name . '.php';
}

$config = require_once 'config.php';
$dbase = new Db($config);
$auth = new Auth($dbase);    
    
$auth->logout();

?>

