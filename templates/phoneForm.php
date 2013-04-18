
<form name="login" action="index.php?page=add_phone&id=<?= $_GET['id'] ?>" method="post">
<input type="hidden" name="type" value="add">
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td class="form-input-name">Telefonszám</td>
            <td class="input"><input type="text" name="phone" placeholder="Telefonszám" autocomplete="on" required="required"  value="" /></td>
        </tr>
        <tr>
            <td class="form-input-name"></td>
            <td><input type="submit" value="Hozzáad" /></td>
        </tr>
    </table>
</form>
