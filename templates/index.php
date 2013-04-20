<script type="text/javascript">
//function getAddForm(){
//   event.preventDefault();
////   $('td.ajax').toggle("slow");
//   $.ajax({
//      type: "GET",
//      url: "index.php",
//      data: { page: "add" },
//      success: function(data){
//        $('td.ajax').toggle("slow");
//        $('body').html(data);
//     }
//   });   
//}
//
//function sendAddForm(){
//   event.preventDefault();
////   $('td.ajax').toggle("slow");
//   $.ajax({
//      type: "POST",
//      url: "index.php?page=add",
//      data: $("#addForm").serialize(),
//      success: function(data){
//        $('td.ajax').toggle("slow");
//        $('body').html(data);
//     }
//   });   
//}

$(document).ready(function() {
    
   $('td.ajax').css('display','hide');
   $('td.ajax').hide();
 });    
</script>

<div>
    <ul>
        <li><a href="index.php?page=add">Add</a></li>
        <li><a href="logout.php">Sign Out</a></li>
    </ul>

<?php 
echo '<table>';
echo '<thead><tr>
        <td>
        Name(
        <a href="index.php?orderBy=name&orderType=ASC">Asc</a>
        <a href="index.php?orderBy=name&orderType=DESC">Desc</a>
        )
        </td>
        <td>E-mail(
         <a href="index.php?orderBy=mail&orderType=ASC">Asc</a>
        <a href="index.php?orderBy=mail&orderType=DESC">Desc</a>       
        )
        </td>
        <td>Phone
        </td>
        <td>Action
        </td>
      </tr></thead>';
echo '<tbody>';

foreach ($datas as $data){
    echo '<tr>';
    echo '<td>'.$data['lname'].' '.$data['fname'].'</td>';  
    echo '<td>'.$data['mail'].'</td>';  
    echo '<td>';
    foreach ($data['numbers'] as $numbers){
        echo $numbers.' ';
    }
    echo '</td>';
    echo '<td>';
    echo '<a href="index.php?page=edit&id='.$data['id'].'" class="menu">Szerkesztés</a>&nbsp;&nbsp;';
    echo '<a href="index.php?page=delete&id='.$data['id'].'" class="menu">Törlés</a>';    
    echo '</td>';
    echo '</tr>';
}
echo '</tbody>';

?>
</table>
</div>