<?php
for($i=1;$i<=10000000;$i++){}
$array = array(1,2,3,4,5,6,7,8,9,10);
echo $_POST['begin'].' -> ';
foreach ($array as $data){
    echo $data.' -> ';
}
echo $_POST['end'];
?>
