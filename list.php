<?php
session_start();

function __autoload($class_name) {
    include $class_name . '.php';
}

require_once 'header.php';
?>

<?php

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
        ?>    
        <a href="logout.php">Kijelentkezés(<?php echo $_SESSION['uname']; ?>)</a> - 
        <a href="index.php">Főoldal a bejelentkezett felhasználóknak</a> - 
        <a href="list.php">Lista</a>
        <br />            
        <br />
        Bejelentkezett felhasználó adatai:
            <br />
            <?php
            $retArr = $dbase->getUserAuthFields($_SESSION['user_id'], true);
            echo 'Id: '.$retArr['id'].'<br />';
            echo 'Name: '.$retArr['name'].'<br />';
            echo 'Salt: '.$retArr['user_salt'].'<br />';
            echo 'is_verified: '.$retArr['is_verified'].'<br />';
            echo 'is_active: '.$retArr['is_active'].'<br />';
	}
}


require_once 'footer.php';
?>
