<?php
session_start();
ob_start();

function __autoload($class_name) {
    include 'classes/'.$class_name . '.php';
}


if (!isset($_SESSION['user_id'])) {
    
    $_SESSION['user_id'];
    header( 'Location: login.php' );
        
} else {
    
    $config = require_once 'config.php';

    $dbase = new Db($config);
    $auth = new Auth($dbase);    

    $logged_in = $auth->checkUser();
	
    if(empty($logged_in)){

        $auth->logout();
        header( 'Location: login.php' );

    } else {
        
        if($_GET['page']=='list' || $_GET['page']=='' || !isset($_GET['page'])){
           
            $contacts = new Contact($dbase);
            $datas = $contacts->listContact($_SESSION['user_id']);

            $toView = array(
                'datas' => $datas,
            );
            $view = new View('index',$toView);
            echo $view;          
            
        }elseif($_GET['page']=='add'){
            
            $toView = array(
                'variable' => 'nincs fassz');
            if($_POST){
                $toView = array('variable' => 'fassz');
            }
            
            $view = new View('add',$toView);
            echo $view;              
            
        }elseif($_GET['page']=='edit'){
            
            $view = new View('edit',$toView);
            echo $view;              
            
        }elseif($_GET['page']=='delete'){
            
            $view = new View('delete',$toView);
            echo $view;             
            
        }

    }
}

?>
