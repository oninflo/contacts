<a href="logout.php">Kijelentkezés(<?php echo $_SESSION['uname']; ?>)</a>
<h1>Névjegy szerkesztése</h1>
<br />            
<br />

<?php
echo ($msg!='')?$msg.'<br /><br />':'';

require_once 'addForm.php';

?>
<br /><br />
<a href="index.php">Vissza a kezdőoldalra</a>