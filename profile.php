<?php 
ob_start();
session_start();
$pageTitle ='profile';
include 'init.php';
if(isset($_SESSION['user'])){ // si l'utilsateur de deconnecte il sera envoyer a le formulaire
    $getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
    $getUser->execute(array($sessionUser));
    $info = $getUser->fetch();

?>
<h1 class="text-center">Mon profil</h1>
<div class="information block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Mes Information</div>
            <div class="panel-body">
            <ul class="list-unstyled">
            <li> 
            <i class="fa fa-unlock-alt fa-fw"></i>
            <span>Pseudo</span> : <?php echo $info['Username']?>
            </li>
            <li>
            <i class="fa fa-envelope-o fa-fw"></i>
            <span> Email</span> : <?php echo $info['Email']?> 
            </li>
            <li>
            <i class="fa fa-user fa-fw"></i>
            <span> Nom</span> : <?php echo $info['FullName']?>
             </li>
            <li>
            <i class="fa fa-calendar fa-fw"></i>
            <span>Date d'enregistrement</span> : <?php echo $info['Date']?> 
            </li>
             </ul>
             <a href="modifier.php" class="btn btn-default">Modifier Mes Information</a>
            </div>
        </div>
    </div>
</div>

<div id="my-ads" class="my-ads block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Mes Annoces</div>
            <div class="panel-body">
                
                  <?php
                     if(!empty(getItems('Member_ID', $info['UserID']))){
                     echo'<div class="row">';
                     foreach (getItems('Member_ID', $info['UserID'], 1) as $item){
                      echo '<div class="col-sm-6 col-md-3">';
                      echo '<div class="thumbnail item-box">';
                         if($item['Approve'] == 0){
                         
                             echo'<span class="approve-status"> Non Approuver</span>';
                         
                         }  
                    echo '<span class="price-tag">' . $item['Price'] . 'DA</span>';
                      echo"<td><img src='admin/uploads/avatars/" . $item['avatar'] . "' alt = '' /></td>";
                      echo '<div class="caption">';
                        echo '<h3><a href="items.php?itemid='. $item['Item_ID'] .'">' . $item['Name'] . '</a></h3>';
                       echo '<p>' . $item['Description'] . '<p>';
                         echo '<div class="date">' . $item['Add_Date'] . '</div>';
                       echo '</div>';
                         echo '</div>';
                       echo '</div>';
                }
             echo'</div>';
        } else{
             echo 'Il Y A pas D\'annonces, crée <a href ="newad.php">une nouvelle annonce</a>';    
       }
               ?>
    
            </div>
        </div>
    </div>
</div>



<?php

}else{
       header('Location: login.php');
       exit();

}

include $tpl.'footer.php';
ob_end_flush();
?>