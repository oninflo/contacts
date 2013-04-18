<a href="logout.php">Kijelentkezés(<?php echo $_SESSION['uname']; ?>)</a>
<h1>Új névjegy hozzáadása</h1>
<br />            
<br />

<?php
echo ($msg!='')?$msg.'<br /><br />':'';

require_once 'phoneForm.php';

?>
<br /><br />
<a href="index.php">Vissza a kezdőoldalra</a>
