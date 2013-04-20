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
    
    public function addContact($lname, $fname, $mail, $numbers){
        $connection = $this->connection;
        $sql = "INSERT INTO contacts(
                user_id,
                fname, 
                lname,
                mail) 
                VALUES (?,?,?,?);";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param( "ssss", $_SESSION['user_id'], $fname, $lname, $mail); 
        if($stmt->execute()){
            $id = mysqli_insert_id($connection);
            $stmt->close();
            foreach ($numbers as $number){
                $this->addNumbers($id, $number);
            }
            return true;
        }
        return false;        
    }
    
    public function getStrippedNumbers($number){
        $blackList = array("+","-","/","\\"," ","_");
        return str_replace($blackList,"",$number);
    }

        public function addNumbers($id, $num){
        $myContactArr = $this->getOwnContactIds($_SESSION['user_id']);
        if(!in_array($id, $myContactArr)){
            return false;
        }
        $connection = $this->connection;
        $sql = "INSERT INTO contact_phones(
                contact_id, 
                number) 
                VALUES (?,?);";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param( "ss", $id, $this->getStrippedNumbers($num)); 
        if($stmt->execute()){
            $stmt->close();    
            return true;
        }
        return false;         
    }
    
    public function delNumbers($id){
        $connection = $this->connection;
        $sql = "DELETE FROM contact_phones WHERE contact_id = ?;";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param( "s", $id); 
        if($stmt->execute()){
            $stmt->close();    
            return true;
        }
        return false;       
    }

    public function editContact($lname, $fname, $mail, $numbers, $cid){
        $connection = $this->connection;
        $sql = "UPDATE contacts 
                SET 
                    fname = ?,
                    lname = ?,
                    mail = ?
                WHERE id = ?
                AND user_id = ?;";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param( "sssss", $fname, $lname, $mail, $cid, $_SESSION['user_id']); 
        if($stmt->execute()){
            $id = mysqli_insert_id($connection);
            $stmt->close();

                $this->delNumbers($cid);
                foreach ($numbers as $number){
                    if($number!=''){
                       $this->addNumbers($cid, $number); 
                    }                    
                }                
            
            return true;
        }
        return false;        
    }    
    
    public function removeContact($id){
        $connection = $this->connection;
        $sql = "DELETE FROM contacts WHERE id = ? AND user_id = ?;";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param( "ss", $id, $_SESSION['user_id']); 
        if($stmt->execute()){
            $stmt->close();    
            return true;
        }else{
            return false;
        }          
    }
    
    public function listContact($uid, $by, $type){
        $connection = $this->connection;     
        
        if($by=='name'){$by2="contacts.fname";}
        elseif($by=='mail'){$by2="contacts.mail";}
        else{$by2='name';}
        
        $type = ($type!='ASC' AND $type!='DESC')?'ASC':$type;

        $query = "SELECT contacts.id, contacts.lname, contacts.fname, contacts.mail, contact_phones.number
           FROM contacts 
           LEFT JOIN contact_phones ON contacts.id = contact_phones.contact_id
           WHERE contacts.user_id = ?
           ORDER BY ".$by2." ".$type;
        $stmt = $connection->prepare($query);
               
        
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
    
    public function getOwnContactIds($uid){
        $connection = $this->connection;
        $stmt = $connection->prepare(
          "SELECT id FROM contacts WHERE contacts.user_id = ?
           ");

        $stmt->bind_param( "s", $uid); 
        
        if(!$stmt->execute()){
            
            return false;
            
        }else{            
            
            $stmt->bind_result($id);
            
            while ($stmt->fetch()) {
                $result[] = $id;

            }            
            
            $stmt->close();  
            return $result;                      
        }          
    }


    public function getContact($uid,$cid){
        $connection = $this->connection;      

        $stmt = $connection->prepare(
          "SELECT contacts.id, contacts.lname, contacts.fname, contacts.mail, contact_phones.number
           FROM contacts 
           LEFT JOIN contact_phones ON contacts.id = contact_phones.contact_id
           WHERE contacts.user_id = ? AND contacts.id = ?
           ");


        $stmt->bind_param( "ss", $uid, $cid); 
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
