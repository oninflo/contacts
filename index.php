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
        
        $contacts = new Contact($dbase);
        
        if($_GET['page']=='list' || $_GET['page']=='' || !isset($_GET['page'])){
                      
                $datas = $contacts->listContact($_SESSION['user_id']);

                $toView = array(
                    'datas' => $datas,
                );
                $view = new View('index',$toView);
                echo $view;          
            
        }elseif($_GET['page']=='add'){
            
                $msg = '';
                if($_POST){
                    $datas['lname'] = $_POST['lname'];
                    $datas['fname'] = $_POST['fname'];
                    $datas['mail'] = $_POST['mail'];
                    $datas['numbers'] = $_POST['phone'];
                    if($contacts->addContact($datas)){
                        $msg = 'A beírás sikeres volt!';
                    }else{
                        $msg = 'A beírás nem volt sikeres!';
                    }                
                }
                $toView = array(
                    'numbers' => $datas['numbers'],
                    'msg' => $msg,
                    );
                $view = new View('add',$toView);
                echo $view;
            
        }elseif($_GET['page']=='add_phone'){
            
                $msg = '';
                if($_POST){
                    $datas['phone'] = $_POST['phone'];

                    if($contacts->addNumbers($datas)){
                        $msg = 'A beírás sikeres volt!';
                    }else{
                        $msg = 'A beírás nem volt sikeres!';
                    }                
                }
                $toView = array(
                    'numbers' => $datas['numbers'],
                    'msg' => $msg,
                    );
                $view = new View('add_phone',$toView);
                echo $view;             
            
        }elseif($_GET['page']=='edit'){
            
                $msg = '';

                if($_POST){
                    $datas['lname'] = $_POST['lname'];
                    $datas['fname'] = $_POST['fname'];
                    $datas['mail'] = $_POST['mail'];
                    $datas['numbers'] = $_POST['phone'];
                    if($contacts->editContact($datas)){
                        $msg = 'A módosítás sikeres volt!';
                    }else{
                        $msg = 'A módosítás nem volt sikeres!';
                    }
                }

                $datas = $contacts->listContact($_SESSION['user_id'],$_GET['id']);

                $toView = array(
                    'values' => $datas,
                    'msg' => $msg,
                );

                $view = new View('edit',$toView);
                echo $view;            
            
        }elseif($_GET['page']=='delete'){
            
                if($_GET['confirmation']=='yes'){
                    if($contacts->removeContact($_SESSION['user_id'],$_GET['id'])){
                        $datas['msg'] = 'A törlés sikeres volt!';
                    }
                }else{
                    $datas = $contacts->listContact($_SESSION['user_id'],$_GET['id']);
                }           

                $toView = array(
                    'datas' => $datas,
                );

                $view = new View('delete',$toView);
                echo $view;

        }else{
                $view = new View('error');
                echo $view;         
        }
        

    }
}

?>
