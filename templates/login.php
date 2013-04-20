
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

</form>