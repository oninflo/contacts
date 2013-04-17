 <?php

class Auth {
    private $DbAccess = null ;
    private $ownKey = 'ide az oldal saját kulcsa' ;

    public function __construct($db)
    {
        $this->DbAccess = $db;
    }

    private function getRandomString($length = 50)
    {
        $length = ($length > 50) ? 50 : $length ;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $shuffled = str_shuffle($characters);
        return substr($shuffled, 0, $length);
    }    
    
    protected function getEncodedString($data)
    {
        return hash_hmac('sha512', $data, $this->ownKey);
    }   
    
    protected function getToken(){
        $token = $_SERVER['HTTP_USER_AGENT'] . $this->getRandomString() . $_SERVER['REMOTE_ADDR'];
        return $this->getEncodedString($token);        
    }

    public static function mailCheck($mail) { 
        if($mail !== "") { 
            error_reporting(E_DEPRECATED | E_USER_DEPRECATED);
            if(preg_match("/^[A-Za-z0-9\.|-|_]+[@]{1}[A-Za-z0-9]+[A-Za-z0-9\.|-|_]*[.]{1}[a-z]{2,5}$/i", $mail)){ 
                return true;
            } else { 
                return false; 
            } 
        } 
    }
    
    public function checkUser()
    {
        
        $sess = $this->DbAccess->getActiveUserFields($_SESSION['user_id']);
        if($sess) {
            if(session_id() == $sess['session_id'] && $_SESSION['token'] == $sess['token']){
                    $this->refreshUser();
                    return true;
                    
            }
        }
        return false;
    }

    private function refreshUser()
    {
        session_regenerate_id();
        $token = $this->getToken(); 
        $this->DbAccess->delAuth($_SESSION['user_id']);
        $this->DbAccess->addAuth($_SESSION['user_id'], session_id(), $token);
        $_SESSION['token'] = $token;

    }

    public function addUser($name, $email, $password, $is_admin = 0)
    {			
        $salt = $this->getRandomString();
        $password = $salt . $password;
        $password = $this->getEncodedString($password);

        $created = $this->DbAccess->addUser($name,$email,$password,$salt);

        if($created != false){
                return true;
        }

        return false;
    }
    
    public function listUsersData($uid){
        
    }

    public function login($email, $password)
    {
        $user = $this->DbAccess->getUserAuthFields($email);
        
        if(array_key_exists('user_salt', $user)){
            
            $password = $user['user_salt'] . $password;
            $password = $this->getEncodedString($password);            
            
            if($password === $user['password']) {

                $token = $this->getToken();
                
                $_SESSION['token'] = $token;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['uname'] = $user['name'];

                $this->DbAccess->delAuth($_SESSION['user_id']);

                if($this->DbAccess->addAuth($user['id'], session_id(), $token)) {
                        return 0;
                } 

                return 1;
            }            
        }

        return 2;
    }
    
    public function logout()
    {

        $this->DbAccess->delAuth($_SESSION['user_id']);
        header( 'Location: index.php' );

    }    
}
?>
