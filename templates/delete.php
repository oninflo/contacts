<a href="logout.php">Kijelentkezés(<?php echo $_SESSION['uname']; ?>)</a>

<h1>Névjegy törlése</h1>
<br />            
<br />

<?php 
function decorate($str){
    return '<font>'.$str.':&nbsp;&nbsp;</font>';
}
if(!array_key_exists('msg', $datas)){
    
    echo 'Biztosan törölni kívánja a névjegyet?<br />';
    echo '<a href="index.php?page=delete&id='.$_GET['id'].'&confirmation=yes">Igen</a> - 
    <a href="index.php">Nem</a>';
    echo '<br /><br /><br />';
    
    foreach ($datas as $data){    
        echo '<div>';    
        echo decorate('Vezetéknév').$data['lname'].'<br />';
        echo decorate('Keresztnév').$data['fname'].'<br />';
        echo decorate('E-mail').$data['mail'].'<br />';
        echo decorate('Telefonszámok').'<br />';

        foreach ($data['numbers'] as $numbers){
            echo $numbers.'<br />';
        }

        echo '<br />';
        echo '<a href="index.php?page=edit&id='.$data['id'].'" class="menu">Szerkesztés</a>&nbsp;&nbsp;';
        echo '<a href="index.php?page=delete&id='.$data['id'].'" class="menu">Törlés</a>';    
        echo '</div>';

    }
    
}else{
    echo $datas['msg'];
    echo '<br /><br /><br /><a href="index.php">Vissza a kezdőoldalra</a>';
}
?>


