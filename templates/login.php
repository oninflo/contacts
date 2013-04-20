
<form name="login" action="login.php" method="post">
    <fieldset class="login">
        <legend>Login</legend>
        <input type="email" name="username" placeholder="Az e-mail címedet ide..." autocomplete="on" required="required"  value="<?= $username ?>" />
        <br />
        <input type="password" name="password" placeholder="Jelszavadat írd ide..." autocomplete="off" />
        <br />
        <input type="submit" value="Bejelentkezés" />
        <br />
        <a href="register.php" class="login">Regisztráció</a>
    </fieldset>    
<!--    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td class="form-input-name">E-mail</td>
            <td class="input"><input type="email" name="username" placeholder="Az e-mail címedet ide..." autocomplete="on" required="required"  value="<?= $username ?>" /></td>
        </tr>
        <tr>
            <td class="form-input-name">Jelszó</td>
            <td class="input"><input type="password" name="password" placeholder="Jelszavadat írd ide..." autocomplete="off" /></td>
        </tr>
        <tr>
            <td class="form-input-name"></td>
            <td><input type="submit" value="Bejelentkezés" /></td>
        </tr>
    </table>-->
</form>