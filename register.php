<?php
require_once '_header.php';

function __autoload($class_name) {
    include 'classes/'.$class_name . '.php';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repassword = $_POST['re-password'];
    
    if($name!='' && $username!='' && $password!='' && $repassword!=''){
        
        if(Auth::mailCheck($username)){

            if($password === $repassword){

                $config = require_once 'config.php';

                $dbase = new Db($config);
                $auth = new Auth($dbase);     

                if($auth->addUser($name, $username, $password)){
                    
                    header('Location: login.php');
                    
                }


            }else{
                
                echo 'A két jelszó nem egyezik!';
                
            }
            
        }else{
            
            echo 'Az e-mail nem megfelelő formátumú!';
            
        }

    }else{
        
        echo 'Minden mezőt ki kell tölteni!';
    }    

    echo '<br />';
    echo '<br />';

}else{
    
    $name = '';
    $username = '';
    $password = '';
    $repassword = '';    
    
}

?>

<form name="register" action="register.php" method="post"><br />
    <table class="register">
        <tr>
            <td class="head" colspan="2">Regisztráció</td>
          
        </tr>
        <tr>
            <td class="form-input-name">Becenév</td>
            <td class="input"><input type="text" name="name" placeholder="Beceneved írd ide..." autocomplete="off" required="required"  value="<?= $name ?>" /></td>
        </tr>
        <tr>
            <td class="form-input-name">E-mail</td>
            <td class="input"><input type="email" name="username" placeholder="Az e-mail címedet ide..." autocomplete="off" required="required"  value="<?= $username ?>" /></td>
        </tr>
        <tr>
            <td class="form-input-name">Jelszó</td>
            <td class="input"><input type="password" name="password" placeholder="Jelszavadat írd ide..." autocomplete="off" /></td>
        </tr>
        <tr>
            <td class="form-input-name">Jelszó újra</td>
            <td class="input"><input type="password" name="re-password" placeholder="Az előbbi jelszavadat ird ide ismét..." autocomplete="off" /></td>
        </tr>
        <tr>
            <td class="form-input-name"></td>
            <td><input type="submit" value="Regisztrálok" /></td>
        </tr>
    </table>    
</form>



<?php
require_once '_footer.php';
?>