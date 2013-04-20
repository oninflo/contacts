<?php
if($_GET['page']=='add'){
    
    $lname = '';
    $fname = '';
    $mail = '';
    $numbers = array('','','');
    $numberCount = 2 ;
    $title = 'New Contact';
    $action = $_GET['page'];
    $submit = 'Hozzáad!';
    
}elseif($_GET['page']=='edit'){
    
    extract($values[$_GET['id']]);
    $numbers = $values[$_GET['id']]['numbers'];
    
    $numberCount = count($numbers);
    $title = $fname.'&nbsp;'.$lname ;
    $action = $_GET['page'].'&id='.$_GET['id'];
    $submit = 'Módosít!';
    
}

?>
<form id="addForm" name="addForm" action="index.php?page=<?= $action ?>" method="post">
<input type="hidden" name="type" value="add">
    <fieldset class="edit">
    <legend><?= $title ?></legend>
    <table class="form">
        <tr class="form">
            <td class="form-input-name">
                First Name<br />
                <input type="text" name="fname" placeholder="Keresztnév helye..." autocomplete="on" required="required"  value="<?= $fname ?>" />
            </td>
            <td class="input">
                Last Name<br />
                <input type="text" name="lname" placeholder="Vezetéknév helye..." autocomplete="on" required="required"  value="<?= $lname ?>" />
            </td>
        </tr>
    </table>

    &nbsp;E-mail<br />
    &nbsp;<input type="text" name="mail" placeholder="Email helye..." autocomplete="on" required="required"  value="<?= $mail ?>" /><br />

    &nbsp;Phone<br />
    &nbsp;<textarea name="phone" rows="5" cols="40" placeholder="Telefonszámok helye..." autocomplete="on" >
<?php
$i = 0;
foreach($numbers as $number){
    echo $number."\n";
    $i++;
}
?>

    </textarea><br />
    &nbsp;<input type="submit" value="<?= $submit ?>" />
    <a href="index.php?page=delete&id=<?= $id ?>" class="submit">Törlés</a>

 