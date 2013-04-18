<script type="text/javascript">
function getAddForm(){
   event.preventDefault();
//   $('td.ajax').toggle("slow");
   $.ajax({
      type: "GET",
      url: "some.php",
      data: { name: "John", location: "Boston" },
      success: function(data){
        $('td.ajax').toggle("slow");
        $('td.ajax').html(data);
     }
   });   
}    

$(document).ready(function() {
    
   $('td.ajax').css('display','hide');
   $('td.ajax').hide();
 });    
</script>
<a href="logout.php">Kijelentkezés(<?php echo $_SESSION['uname']; ?>)</a>
<h1>Főoldal</h1>
<br />            
<br />
<a href="index.php?page=add" id="add" name="add" onClick="getAddForm()">Új névjegy hozzáadása</a>

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
    
    echo '<br />';
    echo '<a href="index.php?page=edit&id='.$data['id'].'" class="menu">Szerkesztés</a>&nbsp;&nbsp;';
    echo '<a href="index.php?page=delete&id='.$data['id'].'" class="menu">Törlés</a>';    
    echo '</div>';
}
echo '</td>';

?>
<td class="ajax">
    ef
</td>
</tr>
</table>