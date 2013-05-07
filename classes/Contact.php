 <?php

class Contact {
    private $DbAccess = null ;

    public function __construct($db)
    {
        $this->DbAccess = $db;
    }
    
    protected function normalize($value){
        $patterns = array("\'","\"","<",">","+","-","/","\\"," ","_");
        return $value = str_replace($patterns, "", $value);
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
    
    public function saveContact($datas, $type){
        foreach ($datas as $key=>$value){
            $datas[$key] = $this->normalize($value);
        }
        if($type=="add"){
            return $this->DbAccess->addContact($datas['lname'], $datas['fname'], $datas['mail'], $datas['numbers']);
        }  elseif($type=="edit") {
            return $this->DbAccess->editContact($datas['lname'], $datas['fname'], $datas['mail'], $datas['numbers'], $_GET['id']);
        }
        
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
