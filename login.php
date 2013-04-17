<?php
session_start();
ob_start();

function __autoload($class_name) {
    include 'classes/'.$class_name . '.php';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $config = require_once 'config.php';

    $dbase = new Db($config);
    $auth = new Auth($dbase);    
    
    if($auth->login($username, $password)===0){
        header( 'Location: index.php' );
        echo 'be vagy jele';
    }  
    
    
}else{
    
    $username = '';
    $password = '';
    $repassword = '';   
    
}

$toView = array(
    'username' => $username,
);
$view = new View('login',$toView);
echo $view;


?>