<?php
ob_start();
session_start();
$pageTitle ='produit';
include 'init.php';

$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']) : 0;
      
         $stmt = $con->prepare("SELECT items.*, categories.Name AS category_name, users.Username FROM items INNER JOIN categories ON categories.ID = items.Cat_ID INNER JOIN users ON users.UserID = items.Member_ID WHERE Item_ID =? AND Approve = 1 ");
        $stmt->execute(array($itemid));
        $count = $stmt->rowCount();
 
      if ($count >0){
        $item = $stmt->fetch();

?>
<h1 class="text-center"><?php echo $item['Name']?></h1>
<div class="container">
    <div class="row">
        <div class="col-md-3 manage">
            <?php echo"<img src='admin/uploads/avatars/" . $item['avatar'] . "' alt = '' />";?>
        </div>
        <div class="col-md-9 item-info">
           <h2><?php echo $item['Name']?></h2>
           <p><?php echo $item['Description']?></p>
           <ul class="list-unstyled">
           <li>
            <i class="fa fa-calendar fa-fw"></i>
             <span>Date</span>: <?php echo $item['Add_Date']?>
            </li>
           <li> 
             <i class="fa fa-money fa-fw"></i>
             <span>Prix</span>: <?php echo $item['Price']?>DA
            </li>
           <li>
             <i class="fa fa-building fa-fw"></i>
             <span>Made In</span>: <?php echo $item['Country_Made']?>
            </li>
           <li>
              <i class="fa fa-tags fa-fw"></i> 
            <span>Categorie</span>:<a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"> <?php echo $item['category_name']?> </a>
            </li>
           
           <li> 
              <i class="fa fa-user fa-fw"></i>
             <span>Ajouté par</span>:<a href="#"><?php echo $item['Username']?></a>
             
            </li>
            <li>
            <form method="POST">
             <input style="width:150px;" class="btn btn-success " type="submit" value="Acheter" name="sam">
             </form>
            </li>
            </ul>
        </div>
    </div>
    <hr class="custom-hr">
    
    <?php if(isset($_SESSION['user'])){//si l'utili est conneter alors lui afficher le formulaire
    
                
                if(isset($_POST['sam'])){
        
                header("location: modedepay.php");
	            exit();
        }
    
    ?>
    
    <div class="row">
     <div class="col-md-offset-3">
        <div class="add-comment">
         <h3>Commenter</h3>
         <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID']?>" method="POST">
             <textarea class="form-control" name="comment" required></textarea>
             <input class="btn btn-primary" type="submit" value="Ajouter Un Commentaire">
         </form>
         <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
         
             $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
             $itemid = $item['Item_ID'];
             $userid = $_SESSION['uid'];
            
            if(! empty($comment)){
              $stmt = $con->prepare("INSERT INTO comments(comment, status, comment_date, item_id, user_id) VALUES(:comment, 0, NOW(), :itemid, :userid)");
                
                $stmt->execute(array(
                    'comment' => $comment,
                    'itemid' => $itemid,
                    'userid' => $userid
                ));
                if($stmt){
                 echo '<div class="alert alert-success"><b>Commentaire Envoyer</b></div>';
                              

                }

            }
           } 
            ?>
         </div>
     </div>
    </div>
    
    <?php }else{ // sinn lui afficher ce msg
            echo'<a href="login.php"><b>Se Connecter</b></a> Ou <a href="login.php"><b>S’inscrire</b></a>';
        
               if(isset($_POST['sam'])){
        
                header("location: login.php");
	            exit();
        }
        }?>
    
    <hr class="custom-hr">
    
              <?php
            
                   
      $stmt = $con->prepare("SELECT 
                                comments.*, users.Username AS Member
                              FROM 
                                 comments
                             INNER JOIN
                                users
                            ON
                               users.UserID = comments.user_id
                            WHERE
                               item_id = ?
                            AND
                               status = 1
                            ORDER BY
                                c_id DESC"); // afficher le dernier comment en premier
                           
      $stmt->execute(array($item['Item_ID']));
      $comments = $stmt->fetchAll();
       
            ?>
        
        <?php
         foreach($comments as $comment){ ?>
          <div class="comment-box">
              <div class="row">
                  <div class="col-sm-2 text-center">
                      <img class="img-responsive img-thumbnail img-circle center-block" src="avatar.jpg" alt=""/>
                      <?php echo $comment['Member']?>
                  </div>
                  <div class="col-sm-10">
                      <p class="lead"><?php echo $comment['comment']?></p>
                  </div>
              </div>
          </div>
          
          <hr class="custom-hr">
          
        <?php }  ?>
    
</div>
<br><br>
<?php
}else{
      
    echo'<div class="alert alert-danger">Ce Produit existe pas ou bien il est pas approuver </div>';
}
include $tpl.'footer.php';
ob_end_flush();
?>