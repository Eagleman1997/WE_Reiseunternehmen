<?php
/**
 * @author Adrian Mathys
 */
use views\TemplateView;

isset($this->users) ? $users = $this->users : $users = array();
?>


<body style="background-size: cover;background-repeat: no-repeat;background-position: center;background-color: rgb(241,247,252);">
    <h1 style="font-family: Capriola, sans-serif;padding: 20px;background-position: top;margin-bottom: 0px;">Administration of users</h1>
    <section>
        <div id="wrapper">
            <div id="sidebar-wrapper" style="font-family: Capriola, sans-serif;">
                <ul class="sidebar-nav">
                    <li class="sidebar-brand"> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin"><strong>Administration main</strong></a></li>
                    <li> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/packageOverview">Trip templates</a></li>
                    <li> </li>
                    <li> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/users" style="background-color: rgba(255,255,255,0.2);">Users</a></li>
                    <li> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/hotels">Hotels</a></li>
                    <li> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/buses">Buses</a></li>
                    <li> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/insurances">Insurances</a></li>
                </ul>
            </div>
            <div class="page-content-wrapper">
                <div class="container-fluid" style="background-image: url(&quot;assets/img/spanish%20beach.png&quot;);background-position: center;background-size: cover;background-repeat: no-repeat;margin-bottom: 0px;padding-bottom: 40px;min-height: 800px;"><a class="btn btn-link bg-light" role="button" href="#menu-toggle" id="menu-toggle"><i class="fa fa-bars"></i></a>
                    <h2 class="text-center" style="font-family: Capriola, sans-serif;color: #000000;margin-bottom: 30px;"><strong>Overview of added users.</strong><br></h2><!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container" style="font-family: Capriola, sans-serif;">

  <input class="form-control" id="myInput" type="text" placeholder="Search users...">
  <br>
  <table id="userAdminTable" class="tableStyle">
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Admin</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody id="myTable">
    <?php
    foreach($users as $user):?>
    <tr>
        <td><?php echo TemplateView::noHTML($user->getFirstname()); ?></td>
        <td><?php echo TemplateView::noHTML($user->getLastname()); ?></td>
        <td><?php echo TemplateView::noHTML($user->getEmail(), false); ?> </td>
        <td><input type="checkbox" class="adminCheckboxes"  onclick="onClickHandler(<?php $user->getId(); ?>)" id="<?php $user->getId(); ?>" /></td>
        <td><img data-href="admin/users/<?php echo $user->getId(); ?>" src="assets/img/Recycle_Bin.png" alt="Remove" method="delete" border=3 height=20 width=20></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!--Make the table searchable-->
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

// Add/remove admin right from/to users
function onClickHandler(id){

    if (!document.getElementById(id).checked){ // if the user was already admin and therefore now unchecked the checkbox
        document.getElementById(id).checked=true; // temporarily recheck the checkbox
        var c = confirm("Do you want to remove admin rights from this user?");
        if(c == true){
            document.getElementById(id).checked=false;
            // Tell the DB to remove the admin rights from this user
        }
    } else { // if the user wasn't admin yet and therefore just checked the checkbox
        document.getElementById(id).checked=false; // temoporarily uncheck the checkbox again
        var c = confirm("Do you want to assign admin rights to this user?");
        if(c == true){
            document.getElementById(id).checked=true;
            // Tell the DB to assign admin rights to this user
        }
    }
}

// Remove users from the database
function enableRemovalOfUsers() {
    table = document.getElementById("userAdminTable");
            for(var i = 1; i < table.rows.length; i++)
            {
                table.rows[i].cells[4].onclick = function(){
                    var c = confirm("Do you want to delete this user?");
                    if(c == true)
                    {
                        index = this.parentElement.rowIndex;
                        table.deleteRow(index);
                        // send index to database in order to delete the user
                    }
                }
            }
}

enableRemovalOfUsers();

</script>

</body>
</html>
</div>
            </div>
        </div>
    </section>
    