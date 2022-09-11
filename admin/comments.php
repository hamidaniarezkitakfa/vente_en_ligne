<?php
/* gerer les membre de la page*/

session_start();
$pageTitle='Commentaires';
if(isset($_SESSION['Username'])){
 
    
    include'init.php';
    
   $do = isset($_GET['do'])? $_GET['do'] : 'Manage';
    
    if($do == 'Manage'){

        
      $stmt = $con->prepare("SELECT 
                                comments.*, items.Name AS Item_Name, users.Username AS member
                              FROM 
                                 comments
                              INNER JOIN 
                                 items
                              ON 
                                items.Item_ID = comments.item_id
                             INNER JOIN
                                users
                            ON
                               users.UserID = comments.user_id
                            ORDER BY
                                c_id DESC"); // afficher le dernier comment en premier
                           
      $stmt->execute();
      $comments = $stmt->fetchAll();
        
        if(!empty($comments)){

?>
    
    <h1 class="text-center">Gestion des commentaires</h1>        
      <div class="container">
         <div class="table-responsive">
             <table class="main-table text-center table table-border">
                 <tr>
                     <td>ID</td>
                     <td>Commentaire</td>
                     <td>Nom Du Produit</td>
                     <td>Nom De L'utilisateur</td>
                     <td>Date D'ajout</td>
                     <td>Controle</td>
                 </tr>
                <?php
                    foreach($comments as $comment){
                      echo"<tr>";
                        echo"<td>" . $comment['c_id'] . "</td>";
                        echo"<td>" . $comment['comment'] . "</td>";
                        echo"<td>" . $comment['Item_Name'] . "</td>";
                        echo"<td>" . $comment['member'] . "</td>";
                        echo"<td>" . $comment['comment_date'] . "</td>";
                        echo"<td>
                           <a href='comments.php?do=Delete&comid=" . $comment['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Supprimer</a>";
                        
                        if($comment['status']==0){
                            
                         echo "<a href='comments.php?do=Approve&comid=" . $comment['c_id'] . "'class='btn btn-info'><i class='fa fa-check activate'></i> Approuver</a>";
                        }
                        echo "</td>";
                      echo"</tr>";
                    }
                 
                   ?>
                 </tr>
          </table>
         </div>
      </div>
        
        <?php }else {
          echo '<div class="container">';
            echo '<div class="nice-message">Pas de Commentaires A Voir</div>';
          echo'</div>';
        
        }?>
        
    <?php   
   
    }else if($do == 'Delete'){
        
         echo"<h1 class='text-center'>Supprimer un commentaire</h1>";
         echo"<div class='container'>";
        
         $comid = isset($_GET['comid']) && is_numeric($_GET['comid'])? intval($_GET['comid']) : 0;
     // on select le id qu'on chercher(car on supprime par rapport a l'id rechercher)
        // select all depend on id
         $check = checkItem('c_id', 'comments', $comid);
        
         if($check>0){ 
             
           $stmt = $con->prepare("DELETE FROM comments WHERE c_id= :id");
            $stmt->bindParam(":id", $comid);
            $stmt->execute();
             
            $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'Enregistrement Supprimer</div>';
            redirectHome($theMsg, 'back');
             
         }else{
             
           $theMsg="<div class='alert alert-danger'>ID N\'Existe Pas</div>";
           redirectHome($theMsg);
         }
        
       echo'</div>';
        
    } else if($do == 'Approve'){
       
         echo"<h1 class='text-center'>Approuver Un Commentaire</h1>";
         echo"<div class='container'>";
        
         $comid = isset($_GET['comid']) && is_numeric($_GET['comid'])? intval($_GET['comid']) : 0;
     // on select le id qu'on chercher(car on supprime par rapport a l'id rechercher)
        // select all depend on id
         $check = checkItem('c_id', 'comments', $comid);
        
         if($check>0){ 
              
             //mettre a jour de regstatus=1 pour que le membre devient active
           $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id =?");
            $stmt->execute(array($comid));
             
            $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'Enregistrement Approuver</div>';
            redirectHome($theMsg, 'back');
             
         }else{
             
           $theMsg="<div class='alert alert-danger'>ID N\'Existe Pas</div>";
           redirectHome($theMsg);
         }
        
       echo'</div>';
    }
    
    include $tpl.'footer.php';
    
}else{
 header('Location: index.php');
    exit();
}
