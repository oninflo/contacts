<?php
if($_GET['page']=='add'){
    
    $lname = '';
    $fname = '';
    $mail = '';
    $numbers = array('','','');
    $numberCount = 2 ;
    $action = $_GET['page'];
    $submit = 'Hozzáad!';
    
}elseif($_GET['page']=='edit'){
    
    extract($values[$_GET['id']]);
    $numbers = $values[$_GET['id']]['numbers'];
    
    $numberCount = count($numbers);
    $action = $_GET['page'].'&id='.$_GET['id'];
    $submit = 'Módosít!';
    
}

?>
<form name="login" action="index.php?page=<?= $action ?>" method="post">
<input type="hidden" name="type" value="add">
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td class="form-input-name">Vezetéknév</td>
            <td class="input"><input type="text" name="lname" placeholder="Vezetéknév helye" autocomplete="on" required="required"  value="<?= $lname ?>" /></td>
        </tr>
        <tr>
            <td class="form-input-name">Keresztnév</td>
            <td class="input"><input type="text" name="fname" placeholder="Keresztnév elye..." autocomplete="on" required="required"  value="<?= $fname ?>" /></td>
        </tr>
        <tr>
            <td class="form-input-name">E-mail</td>
            <td class="input"><input type="text" name="mail" placeholder="Email helye..." autocomplete="on" required="required"  value="<?= $mail ?>" /></td>
        </tr>
        
<?php
$i = 0;
foreach($numbers as $number){

?>
        
        <tr>
            <td class="form-input-name">Telefon <?= $i+1 ?></td>
            <td class="input"><input type="text" name="phone[]" placeholder="Telefon <?= $i+1 ?>..." autocomplete="on" value="<?= $number ?>" /></td>
        </tr>
        
<?php    
    $i++;
}
if($_GET['page']=='edit'){
?>
        <tr>
            <td class="form-input-name">
                <a href="index.php?page=add_phone&id=<?= $_GET['id'] ?>" style="font-size: 10pt;">Új telefonszám<br />hozzáadása</a>
            </td>
            <td class="input"></td>
        </tr>
        
 <?php
}
?>
        <tr>
            <td class="form-input-name"></td>
            <td><input type="submit" value="<?= $submit ?>" /></td>
        </tr>
    </table>
</form>
