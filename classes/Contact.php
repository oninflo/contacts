 <?php

class Contact {
    private $DbAccess = null ;

    public function __construct($db)
    {
        $this->DbAccess = $db;
    }

    public function listContact($uid){
        $contacts = $this->DbAccess->listContact($uid);
        $datas = array();
        foreach ($contacts AS $con){
            $id = $con['id'];
            $datas[$id]['fname'] = $con['fname'];
            $datas[$id]['lname'] = $con['lname'];
            $datas[$id]['mail'] = $con['mail'];
            $datas[$id]['numbers'][] = $con['number'];
        }
        return $datas;
    }
    
    public function addContact($lname, $fname, $mail){
       $this->DbAccess->addContact($lname, $fname, $mail);
    }
    
    public function removeContact($uid){
       $this->DbAccess->removeContact($uid);
    }
}
?>
