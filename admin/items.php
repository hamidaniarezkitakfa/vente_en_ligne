<?php
/* gerer les membre de la page*/
ob_start();
session_start();
$pageTitle = 'Produits';

if(isset($_SESSION['Username'])){
 
    
    include'init.php';
    
   $do = isset($_GET['do'])? $_GET['do'] : 'Manage';
    
    if($do == 'Manage'){
    
      
        
      $stmt = $con->prepare("SELECT items.*, categories.Name AS category_name , users.Username FROM items INNER JOIN categories ON categories.ID = items.Cat_ID INNER JOIN users ON users.UserID = items.Member_ID ORDER BY Item_ID DESC");
      $stmt->execute();
      $items = $stmt->fetchAll();
    if(!empty($items)){
?>
    
    <h1 class="text-center" style="color:black;">Gestion des produits</h1>        
      <div class="container">
         <div class="table-responsive">
             <table class="main-table manage-items text-center table table-border">
                 <tr>
                     <td>#ID</td>
                     <td>Image</td>
                     <td>Nom</td>
                     <td>Description</td>
                     <td>Prix</td>
                     <td>Quantité</td>
                     <td>Date D'ajout</td>
                     <td>Categorie</td>
                     <td>Nom D'Utilisateur</td>
                     <td>Controle</td>
                 </tr>
                <?php
                    foreach($items as $item){
                      echo"<tr>";
                        echo"<td>" . $item['Item_ID'] . "</td>";
                        echo"<td><img src='uploads/avatars/" . $item['avatar'] . "' alt = '' /></td>";
                        echo"<td>" . $item['Name'] . "</td>";
                        echo"<td>" . $item['Description'] . "</td>";
                        echo"<td>" . $item['Price'] . " </td>";
                        echo"<td>" . $item['Quantité'] . " </td>";
                        echo"<td>" . $item['Add_Date'] . "</td>";
                        echo"<td>" . $item['category_name'] . "</td>";
                        echo"<td>" . $item['Username'] . "</td>";
                        echo"<td>
                           <a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "'class='btn btn-success'><i class='fa fa-edit'></i>Modifier</a>
                           <a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Supprimer</a>";
                        
                           if($item['Approve']==0){
                            
                            echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "'class='btn btn-info activate'><i class='fa fa-check'></i> Approuver</a>";
                        }
                        
                        echo "</td>";
                      echo"</tr>";
                    }
                 
                   ?>
                 </tr>
          </table>
         </div>
        <a href="items.php?do=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>Ajouter un nouveau produit</a>
      </div>
        
        
        <?php }else {
          echo '<div class="container">';
            echo '<div class="nice-message">Pas de Produits A Voir</div>';
            echo '<a href="items.php?do=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>Ajouter un nouveau produit</a>';

          echo'</div>';
        
        }?>
        
    <?php
        
    } else if($do == 'Add'){?>
    
          <h1 class="text-center"style="color:#648297;">Ajouter un nouveau produit</h1>        
           <div class="container">
               <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                 <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Nom</label>
                     <div class="col-sm-10 col-sm-6">
                         <input type="text" name="name" class="form-control" />
                     </div>
                 </div> 
                     
                  <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Description</label>
                     <div class="col-sm-10 col-sm-6">
                         <textarea name="description" class="form-control"></textarea>
                     </div>
                 </div> 
                 
                   <div class="form-group form-group-lg ">
                        <label class="col-sm-2 control-label">Prix</label>
                        <div class="col-sm-10 col-sm-6">
                           <input type="text" name="price" class="form-control" />
                        </div>
                   </div> 
                   
                    <div class="form-group form-group-lg ">
                        <label class="col-sm-2 control-label">Quantité</label>
                        <div class="col-sm-10 col-sm-6">
                           <input type="text" name="Quantité" class="form-control" />
                        </div>
                   </div> 
                 
                  <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Marque </label>
                     <div class="col-sm-10 col-sm-6">
                         <input type="text" name="country" class="form-control" />
                     </div>
                 </div> 
                 
                  <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Statut</label>
                     <div class="col-sm-10 col-sm-6">
                      <select name=" status">
                          <option value="0">...</option>
                          <option value="1">NOUVEAU</option>
                          <option value="2">Occasion</option>
                          
                      </select>
                     </div>
                 </div> 
                 
                   <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Membre</label>
                     <div class="col-sm-10 col-sm-6">
                      <select name=" member">
                          <option value="0">...</option>
                          <?php
                            $stmt = $con->prepare("SELECT * FROM users");                     
                            $stmt->execute();
                            $users = $stmt->fetchAll();
                            foreach ($users as $user){
                             echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
                            }
                            ?>
                      </select>
                     </div>
                 </div> 
                 
                   <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Categorie</label>
                     <div class="col-sm-10 col-sm-6">
                      <select name="category">
                          <option value="0">...</option>
                          <?php
                            $stmt2 = $con->prepare("SELECT * FROM categories");                     
                            $stmt2->execute();
                            $cats = $stmt2->fetchAll();
                            foreach ($cats as $cat){
                             echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                            }
                            ?>
                      </select>
                     </div>
                 </div>
            
                 <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Image</label>
                     <div class="col-sm-10 col-sm-6">
                         <input type="file" name="avatar" class="form-control" />
                     </div>
                 </div>
                 
                  <div class="form-group form-group-lg">
                     <div class="col-sm-offset-2 col-sm-10">
                         <input type="submit" value="Ajouter Produit" class=" confirm btn btn-primary btn-sm"/>
                     </div>
                 </div>  
               </form>
           </div>
       

     <?php
    
    }else if($do == 'Insert'){
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
          //get variables form the form
          
          echo"<h1 class='text-center'>Inserer Produit</h1>";
         echo"<div class='container'>";
  
        $avatarName = $_FILES['avatar']['name'];
        $avatarSize = $_FILES['avatar']['size'];
        $avatarTmp  = $_FILES['avatar']['tmp_name'];
        $avatarType = $_FILES['avatar']['type'];
            
            $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");
            
           
            
          $ext = (explode('.',$avatarName));
          $avatarExtension = end($ext);
         
            
          $name = $_POST['name'];
          $desc = $_POST['description'];
          $price = $_POST['price'];
          $Quantité = $_POST['Quantité'];
          $country= $_POST['country'];
          $status = $_POST['status'];
          $member = $_POST['member'];
          $cat = $_POST['category'];
        
          //valider le form(les controles)
          $formErrors = array();
            
          if (empty($name)){
          $formErrors[] = 'Le Nom Peut Pas Etre <strong>Vide</strong>';
          }
         if (strlen($desc) <10){
         $formErrors[] = 'La Description doit contenir plus de 10 caracteres';
          }
           if (empty($price)){
          $formErrors[] = 'Le prix Peut Pas Etre <strong>Vide</strong>';
          }
          if ($price<0){
          $formErrors[] = 'Le prix Peut Pas Etre <strong>négative</strong>';
          }
          if (empty($country)){
          $formErrors[] = 'Le pays Peut Pas Etre <strong>Vide</strong>';
          }
          if (empty($status)){
          $formErrors[] = 'Veuillez entrer statu du produit';
          }
            if ($member == 0){
          $formErrors[] = 'Vous devez choisir un <strong>Membre</strong>';
          }
            if ($cat == 0){
          $formErrors[] = 'Vous devez choisir une <strong>Categorie</strong>';
          }
            
         if(!empty($avatarName) && !in_array($avatarExtension, $avatarAllowedExtension)){
         $formErrors[] = 'Veuillez entrer une bonne extension';
          }
         if(empty($avatarName)){
         $formErrors[] = 'Veuillez choisir une image';
          }
         if($avatarSize >4194304){
         $formErrors[] = 'Veuillez choisir une image plus petite';
          }
         
          //afficher tte les erreurs
          foreach($formErrors as $error){
             echo'<div class="alert alert-danger">' . $error . '<div/>' ;
          }
            
          //si il ya pas d'erreur on enregistre
          if(empty($formErrors)){
              $avatar = rand(0, 100000) . '_' . $avatarName;
             move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);
              
                   $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Quantité, Country_Made, Status, Add_Date, Cat_ID, Member_ID, avatar) VALUES(:name, :desc, :price,:Qt, :country, :status, now(), :cat, :member, :avatar)");
                   $stmt->execute(array(
                       
                   'name'=> $name,
                   'desc'=> $desc,
                   'price'=> $price,
                   'Qt'=> $Quantité,
                   'country'=> $country,
                   'status'=> $status,
                   'cat'=> $cat,
                  'member'=> $member,
                  'avatar' => $avatar
                       
                    )); 
                  $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'Enregistrement mis à jour
</div>';
                  redirectHome($theMsg, 'back');
             
          }
          
    }else{
          echo"<div class= 'container'>";
          
           $theMsg = '<div class="alert alert-danger">on peut pas acceder directement</div>';
           redirectHome($theMsg);
          
          echo"</div>";
      }
        echo"</div>";
        
    }else if($do == 'Edit'){
    
        
      $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']) : 0;
      
         $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID =? ");
        $stmt->execute(array($itemid));
        $item = $stmt->fetch();
        $count = $stmt->rowCount();
      
    if($count>0){ ?> 
         
           <h1 class="text-center" style="color:black;">Modifier produit</h1>        
           <div class="container">
               <form class="form-horizontal" action="?do=Update" method="POST">
                 <input type="hidden" name="itemid" value="<?php echo $itemid ?>"/>

                 <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Nom</label>
                     <div class="col-sm-10 col-sm-6">
                         <input type="text" name="name" class="form-control" value="<?php echo $item['Name']?>" />
                     </div>
                 </div> 
                     
                  <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Description</label>
                     <div class="col-sm-10 col-sm-6">
                         <textarea name="description" class="form-control" value="<?php echo $item['Description']?>"></textarea>
                     </div>
                 </div> 
                 
                   <div class="form-group form-group-lg ">
                        <label class="col-sm-2 control-label">Prix</label>
                        <div class="col-sm-10 col-sm-6">
                           <input type="text" name="price" class="form-control"value="<?php echo $item['Price']?>" />
                        </div>
                   </div> 
                   
                   
                     <div class="form-group form-group-lg ">
                        <label class="col-sm-2 control-label">Quantité</label>
                        <div class="col-sm-10 col-sm-6">
                           <input type="text" name="Quantité" class="form-control" value="<?php echo $item['Quantité']?>" />
                        </div>
                   </div> 
                 
                  <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Made in </label>
                     <div class="col-sm-10 col-sm-6">
                         <input type="text" name="country" class="form-control" value="<?php echo $item['Country_Made']?>"/>
                     </div>
                 </div> 
                 
                  <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Statu</label>
                     <div class="col-sm-10 col-sm-6">
                      <select name=" status">
                          <option value="0">...</option>
                          <option value="1"<?php if ($item['Status']==1){ echo 'selected';}?>>NOUVEAU</option>
                          <option value="2"<?php if ($item['Status']==2){ echo 'selected';}?>>Occasion</option>
                      </select>
                     </div>
                 </div> 
                 
                   <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Membre</label>
                     <div class="col-sm-10 col-sm-6">
                      <select name=" member">
                          <option value="0">...</option>
                          <?php
                            $stmt = $con->prepare("SELECT * FROM users");                     
                            $stmt->execute();
                            $users = $stmt->fetchAll();
                            foreach ($users as $user){
                             echo "<option value='" . $user['UserID'] ."'"; 
                            if ($item['Member_ID']==$user['UserID']){ echo 'selected';}                                
                            echo ">" . $user['Username'] . "</option>";
                            }
                            ?>
                          ?>
                      </select>
                     </div>
                 </div> 
                 
                   <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Categorie</label>
                     <div class="col-sm-10 col-sm-6">
                      <select name="category">
                          <option value="0">...</option>
                          <?php
                            $stmt2 = $con->prepare("SELECT * FROM categories");                     
                            $stmt2->execute();
                            $cats = $stmt2->fetchAll();
                            foreach ($cats as $cat){
                             echo "<option value='" . $cat['ID'] . "'";
                            if ($item['Cat_ID']==$cat['ID']){ echo 'selected';}
                             echo ">" . $cat['Name'] . "</option>";
                            }
                            ?>
                      </select>
                     </div>
                 </div>
                
                  <div class="form-group form-group-lg">
                     <div class="col-sm-offset-2 col-sm-10">
                         <input type="submit" value="Ajouter Produit" class="confirme btn btn-primary btn-sm"/>
                     </div>
                 </div>  
               </form>
               
               <?php // SELECTIONNER TT LES UTILISATEUR SAUF ADMIN
                $stmt = $con->prepare("SELECT 
                                comments.*, users.Username AS member
                              FROM 
                                 comments
                              
                             INNER JOIN
                                users
                            ON
                               users.UserID = comments.user_id
                            WHERE 
                               item_id = ?");
                           
      $stmt->execute(array($itemid));
      $rows = $stmt->fetchAll();
      
                 
    if(!empty($rows)){ // si il ya des commentaire a afficher sinn la table comment est vide
                 
    ?>

     <?php } ?>
    </div>
   <?php
      }else{
        
        echo"<div class='container'>";
        
        $theMsg ='<div class="alert alert-danger">Error(ID Entrer N\'Existe Pas)</div>';
        
        redirectHome($theMsg);
        
        echo"</div>";
        
    }
        
    }else if($do == 'Update'){
    
                
       echo"<h1 class='text-center'>Mettre a jour</h1>";
       echo"<div class='container'>";
        
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){
          //get variables form the form
           
          $id = $_POST['itemid'];
          $name = $_POST['name'];
          $desc = $_POST['description'];
          $price = $_POST['price'];
          $Quantité = $_POST['Quantité'];
          $country= $_POST['country'];
          $status = $_POST['status'];
          $member = $_POST['member'];
          $cat = $_POST['category'];
          
          //valider le form(les controles)
          $formErrors = array();
            
          if (empty($name)){
          $formErrors[] = 'Le Nom Peut Pas Etre <strong>Vide</strong>';
          }
           if (empty($desc)){
          $formErrors[] = 'La Description Peut Pas Etre <strong>Vide</strong>';
          }
           if (empty($price)){
          $formErrors[] = 'Le prix Peut Pas Etre <strong>Vide</strong>';
          }
          if ($price<0){
          $formErrors[] = 'Le prix Peut Pas Etre <strong>négative</strong>';
          }
          if (empty($country)){
          $formErrors[] = 'Le pays Peut Pas Etre <strong>Vide</strong>';
          }
          if ($status == 0){
          $formErrors[] = 'Vous devez choisir un <strong>Statut</strong>';
          }
            if ($member == 0){
          $formErrors[] = 'Vous devez choisir un <strong>Membre</strong>';
          }
            if ($cat == 0){
          $formErrors[] = 'Vous devez choisir une <strong>Categorie</strong>';
          }
         
         
          //afficher tte les erreurs
          foreach($formErrors as $error){
             echo'<div class="alert alert-danger">' . $error . '<div/>' ;
          }
          //si il ya pas d'erreur on enregistre
          if(empty($formErrors)){
              
          $stmt = $con->prepare("UPDATE 
                                     items
                                SET 
                                  Name = ?,
                                  Description = ?, 
                                  Price = ?,
                                  Country_Made = ?, 
                                  Status = ? ,
                                    Quantité = ?, 
                                  Cat_ID = ?,
                                  Member_ID = ?
                                WHERE 
                                  Item_ID = ?");
              
        $stmt->execute(array($name, $desc, $price, $country, $status, $Quantité, $cat, $member, $id));                                                        
        $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'Enregistrement mis à jour
</div>';
            redirectHome($theMsg, 'back'); 
          }
          
    }else{
         $theMsg = '<div class="alert alert-danger">On Peut Pas Acceder Directement</div>';
         redirectHome($theMsg);      
      }
        echo"</div>";
        
    }else if($do == 'Delete'){
    
         echo"<h1 class='text-center'>Supprimer Produit</h1>";
         echo"<div class='container'>";
        
         $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']) : 0;
     // on select le id qu'on chercher(car on supprime par rapport a l'id rechercher)
        // select all depend on id
         $check = checkItem('Item_ID', 'items', $itemid);
        
         if($check>0){ 
             
           $stmt = $con->prepare("DELETE FROM items WHERE Item_ID= :id");
            $stmt->bindParam(":id", $itemid);
            $stmt->execute();
             
            $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'Enregistrement Supprimer</div>';
            redirectHome($theMsg, 'back');
             
         }else{
             
           $theMsg="<div class='alert alert-danger'>ID Existe Pas</div>";
           redirectHome($theMsg);
         }
        
       echo'</div>';
        
    }else if($do =='Approve'){
        
         echo"<h1 class='text-center'>Approuver Les Produits</h1>";
         echo"<div class='container'>";
        
         $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']) : 0;
     // on select le id qu'on chercher(car on supprime par rapport a l'id rechercher)
        // select all depend on id
         $check = checkItem('Item_ID', 'items', $itemid);
        
         if($check>0){ 
              
             //mettre a jour de regstatus=1 pour que le membre devient active
           $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID =?");
            $stmt->execute(array($itemid));
             
            $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'Enregistrement mis à jour
</div>';
            redirectHome($theMsg);
             
         }else{
             
           $theMsg="<div class='alert alert-danger'>ID Existe Pas</div>";
           redirectHome($theMsg, 'back');
         }
        
       echo'</div>';
     
    
    }
    include $tpl . 'footer.php';
    
}else {
     header('Location: index.php');
     exit();
}
  ob_end_flush();

?>