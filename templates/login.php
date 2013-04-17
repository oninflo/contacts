<a href="register.php">Regisztráció</a>
<h1>Bejelentkezés</h1>
<br />
<br />
<form name="login" action="login.php" method="post">
    <table cellpadding="0" cellspacing="0" border="0">
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
    </table>
</form>