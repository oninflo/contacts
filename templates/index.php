<script type="text/javascript">
$(document).ready(function() {
   $('td.ajax').load('templates/addForm.php');
 });    
</script>
<a href="logout.php">Kijelentkezés(<?php echo $_SESSION['uname']; ?>)</a>
<h1>Főoldal</h1>
<br />            
<br />

<?php 
function decorate($str){
    return '<font>'.$str.':&nbsp;&nbsp;</font>';
}
echo '<table>';
echo '<tr>';
echo '<td>';
foreach ($datas as $data){
    echo '<div>';
    echo decorate('Vezetéknév').$data['lname'].'<br />';
    echo decorate('Keresztnév').$data['fname'].'<br />';
    echo decorate('E-mail').$data['mail'].'<br />';
    echo decorate('Telefonszámok').'<br />';
    foreach ($data['numbers'] as $numbers){
        echo $numbers.'<br />';
    }    
    echo '</div>';
}
echo '</td>';

?>
<td class="ajax">
    
</td>
</tr>
</table>