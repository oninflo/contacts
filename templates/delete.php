<fieldset class="login">
<?php 
function decorate($str){
    return '<font>'.$str.':&nbsp;&nbsp;</font>';
}
if(!array_key_exists('msg', $datas)){
    echo '<br />';
    echo 'Biztosan törölni kívánja a névjegyet?<br />';
    echo '<a href="index.php?page=delete&id='.$_GET['id'].'&confirmation=yes">Igen</a> - 
    <a href="index.php">Nem</a>';
    echo '<br /><br />';
    
}else{
    echo $datas['msg'];
    echo '<br /><a href="index.php">Vissza a kezdőoldalra</a>';
}
?>
</fieldset>

