<?php
class Db{
    
    public $connection = null;

    public function __construct($array = null) {
        if($array!=0){
            $this->connection = new mysqli(
                    $array['host'], 
                    $array['user'], 
                    $array['password'], 
                    $array['dbname']);

            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }            
        }
    }
 
    public function __destruct() {

        $this->connection->close();
        
    }
    
    public function getUserAuthFields($mail, $id = false){
        $connection = $this->connection;
        if($id){
            $stmt = $connection->prepare(
          "SELECT id, name, email, password, user_salt, is_verified, is_active FROM users WHERE id = ?");            
        }else{
            $stmt = $connection->prepare(
          "SELECT id, name, email, password, user_salt, is_verified, is_active FROM users WHERE email = ?");
        }
        
        
        
        $stmt->bind_param( "s", $mail); 
        if(!$stmt->execute()){
            
            return false;
            
        }else{
            
            $stmt->bind_result($id, $name, $email, $password, $user_salt, $is_verified, $is_active);
            
            $result = array();

            while ($stmt->fetch()) {
                $result = array(
                    'id' => $id,
                    'name' => $name,
                    'password' => $password,
                    'user_salt' => $user_salt,
                    'is_verified' => $is_verified,
                    'is_active' => $is_active,
                );
            }
            
            $stmt->close();  
            return $result;
            
        }       
    }
    
    public function getActiveUserFields($uid){
        $connection = $this->connection;
        
        $stmt = $connection->prepare(
          "SELECT id, user_id, session_id, token
           FROM logged_users WHERE user_id = ?");
        $stmt->bind_param( "s", $uid); 
        if(!$stmt->execute()){
            return false;
        }else{
            
            $stmt->bind_result($id, $user_id, $session_id, $token);
            
            $result = array();

            while ($stmt->fetch()) {
                $result = array(
                    'session_id' => $session_id,
                    'token' => $token,
                    'user_id' => $user_id
                );

            }
            
            $stmt->close();  
            return $result;
                      
        }   
    }    
    
    
    public function addUser($name, $mail,$password,$salt){
        $connection = $this->connection;
        $sql = "INSERT INTO users(
                id, 
                name,
                email,
                password, 
                user_salt, 
                is_verified, 
                is_active, 
                is_admin, 
                verification_code) 
                VALUES (NULL,?,?,?,?,1,1,1,0000);";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param( "ssss", $name, $mail, $password, $salt); 
        if($stmt->execute()){
            $stmt->close();    
            return true;
        }
        
    }
 
    public function addAuth($uid,$sesid,$token){
        $connection = $this->connection;
        $sql = "INSERT INTO logged_users(
                id, 
                user_id,
                session_id, 
                token) 
                VALUES (NULL,?,?,?);";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param( "sss", $uid, $sesid, $token); 
        if($stmt->execute()){
            $stmt->close();    
            return true;
        }
        return false;
    }    
   
    public function delAuth($uid){
        $connection = $this->connection;
        $sql = "DELETE FROM logged_users WHERE user_id = ?;";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param( "s", $uid); 
        if($stmt->execute()){
            $stmt->close();    
            return true;
        }else{
            return false;
        }        
    }   
    
    public function addContact($lname, $fname, $mail){
        $connection = $this->connection;
        $sql = "INSERT INTO contacts(
                lname, 
                fname,
                mail) 
                VALUES (?,?,?);";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param( "sss", $lname, $fname, $mail); 
        if($stmt->execute()){
            $id = mysqli_insert_id($connection);
            $stmt->close();    
            return $id;
        }
        return false;        
    }
    
    public function addNumbers($id, $num){
        $connection = $this->connection;
        $sql = "INSERT INTO contact_phones(
                contact_id, 
                number) 
                VALUES (?,?);";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param( "ss", $id, $num); 
        if($stmt->execute()){
            $stmt->close();    
            return true;
        }
        return false;         
    }
    
    public function removeContact($uid){
        $connection = $this->connection;
        $sql = "DELETE FROM contacts WHERE user_id = ?;";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param( "s", $uid); 
        if($stmt->execute()){
            $stmt->close();    
            return true;
        }else{
            return false;
        }          
    }
    
    public function listContact($uid){
        $connection = $this->connection;      

        $stmt = $connection->prepare(
          "SELECT contacts.id, contacts.lname, contacts.fname, contacts.mail, contact_phones.number
           FROM contacts 
           LEFT JOIN contact_phones ON contacts.id = contact_phones.contact_id
           WHERE contacts.user_id = ?
           ");


        $stmt->bind_param( "s", $uid); 
        if(!$stmt->execute()){
            return false;
        }else{
            
            $stmt->bind_result($id, $lname, $fname, $mail, $number);

            while ($stmt->fetch()) {
                $result[] = array(
                    'id' => $id,
                    'lname' => $lname,
                    'fname' => $fname,
                    'mail' => $mail,
                    'number' => $number,
                );

            }
            
            $stmt->close();  
            return $result;
                      
        }          
    }   
}
?>
