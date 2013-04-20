 <?php

class Contact {
    private $DbAccess = null ;

    public function __construct($db)
    {
        $this->DbAccess = $db;
    }

    public function listContact($uid, $cid = null, $by, $type){
        if($cid == null){
            $contacts = $this->DbAccess->listContact($uid, $by, $type);
        }else{
            $contacts = $this->DbAccess->getContact($uid,$cid);
        }
        
        $datas = array();
        foreach ($contacts AS $con){
            $id = $con['id'];
            $datas[$id]['id'] = $id;
            $datas[$id]['fname'] = $con['fname'];
            $datas[$id]['lname'] = $con['lname'];
            $datas[$id]['mail'] = $con['mail'];
            $datas[$id]['numbers'][] = $con['number'];
        }
        return $datas;
    }    
    
    public function addContact($datas){
       return $this->DbAccess->addContact($datas['lname'], $datas['fname'], $datas['mail'], $datas['numbers']);
    }
    
    public function addNumbers($datas){
        return $this->DbAccess->addNumbers($_GET['id'],$datas['phone']);
    }
    
    public function editContact($datas){
        return $this->DbAccess->editContact($datas['lname'], $datas['fname'], $datas['mail'], $datas['numbers'], $_GET['id']);
    }


    public function removeContact($uid,$cid){
       $myContacts = $this->DbAccess->getOwnContactIds($uid);
       if(in_array($cid, $myContacts)){
           $this->DbAccess->removeContact($cid);
       }
       return true;
    }
}
?>
