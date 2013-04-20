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
        
        if(!isset($_GET['page'])){
                
                $orderBy = (isset($_GET['orderBy']))?$_GET['orderBy']:'name';
                $orderType = (isset($_GET['orderType']))?$_GET['orderType']:'ASC';
                
                $datas = $contacts->listContact($_SESSION['user_id'], null, $orderBy, $orderType);

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
                    $datas['numbers'] = explode("\n",$_POST['phone']);
                    if($contacts->addContact($datas)){
                        header('Location: index.php');
                    }              
                }
                $toView = array(
                    'numbers' => $datas['numbers'],
                    'msg' => $msg,
                    );
                $view = new View('add',$toView);
                echo $view;
            
        }elseif($_GET['page']=='edit'){
            
                $msg = '';

                if($_POST){
                    $datas['lname'] = $_POST['lname'];
                    $datas['fname'] = $_POST['fname'];
                    $datas['mail'] = $_POST['mail'];
                    $datas['numbers'] = explode("\n",trim($_POST['phone']));
                    if($contacts->editContact($datas)){
                        header('Location: index.php');
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
