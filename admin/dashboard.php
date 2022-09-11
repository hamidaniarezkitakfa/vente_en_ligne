<?php 

ob_start();
session_start();

if(isset($_SESSION['Username'])){
 
    $pageTitle= 'Accueil';
    include'init.php';
   /*start page*/
    $numUsers = 3; // les dernier membres inscrit
    $latestUsers = getLatest("*", "users", "UserID", $numUsers);
    
    $numItems = 3; // les dernier produits en ligne
    $latestItems = getLatest("*", "items", "Item_ID", $numItems);
     
    $numComments = 4;
    ?>
<div class=" home-stats">
    <div class="container text-center">
    
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-members">
                 <i class="fa fa-users"></i>
                 <div class="info">
                     
                <span><a href="members.php"><?php echo countItems('UserID', 'users')?></a></span>
                 </div>
                </div> <h2>Membres Totale</h2>
            </div>
            <div class="col-md-3">
                <div class="stat st-pending">
                  <i class="fa fa-user-plus"></i>
                   <div class="info">
                    
                   <span><a href="members.php?do=Manage&page=Pending"><?php echo checkItem("RegStatus", "users", 0)?></a></span>
              
                </div>
                </div> <h2>Members en Attente</h2>
            </div>
            <div class="col-md-3">
                <div class="stat st-items">
                <i class="fa fa-tag"></i>
                <div class="info">
                   
                <span><a href="items.php"><?php echo countItems('Item_ID', 'items')?></a></span>
                </div>
                </div> <h2> Produit Totale </h2>
            </div>
           
        </div> 
    </div>
</div>
    <?php
  /*END page */
    include $tpl.'footer.php';
    
}else{
 header('Location: index.php');
    exit();
}
ob_end_flush();
