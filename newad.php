<?php 
session_start();
$pageTitle ='Créer un nouveau produit';
include 'init.php';
if(isset($_SESSION['user'])){
 
    
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        
         $avatarName = $_FILES['avatar']['name'];
        $avatarSize = $_FILES['avatar']['size'];
        $avatarTmp  = $_FILES['avatar']['tmp_name'];
        $avatarType = $_FILES['avatar']['type'];
            
            $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");
            
           
            
          $ext = (explode('.',$avatarName));
          $avatarExtension = end($ext);
        
        
        
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $desc = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $price= filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
    $Quantité= filter_var($_POST['Quantité'], FILTER_SANITIZE_NUMBER_INT);
    $country= filter_var($_POST['country'], FILTER_SANITIZE_STRING);
    $status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
    $category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
        
         $formErrors = array();
    
    
    if (empty($name)){
     $formErrors[] = 'Le Nom Peut Pas Etre <strong>Vide</strong>';
    }
    
     if (strlen($desc) <10){
     $formErrors[] = 'La Description doit contenir plus de 10 caracteres';
    }
    
     if (strlen($country) <2){
     $formErrors[] = 'Le Pays doit contenir plus de 2 caracteres';
         
     }
     if ($price<0){
          $formErrors[] = 'Le prix Peut Pas Etre <strong>négative</strong>';
          }
    
    if (empty($status)){
     $formErrors[] = 'Veuillez entrer La situation du produit';
    }
    
    if (empty($category)){
     $formErrors[] = 'Veuillez entrer la categorie';
    }
              
        
        if(empty($formErrors)){
              
               $avatar = rand(0, 100000) . '_' . $avatarName;
             move_uploaded_file($avatarTmp, "admin\uploads\avatars\\" . $avatar);
            
                   $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Quantité, Country_Made, Status, Add_Date, Cat_ID, Member_ID, avatar) VALUES(:name, :desc, :price, :Qt, :country, :status, now(), :cat, :member, :avatar)");
                   $stmt->execute(array(
                       
                   'name'=> $name,
                   'desc'=> $desc,
                   'price'=> $price,
                   'Qt'=> $Quantité,
                   'country'=> $country,
                   'status'=> $status,
                   'cat'=> $category,
               'member'=> $_SESSION['uid'],
                       'avatar' => $avatar
                    )); 
            
            if ($stmt){ ?>
               <div class="alert alert-success"> <?php echo'votre produit a été ajouté avec succès' ;?> </div>
                <?php
            }
          }
     }
?>
<h1 class="text-center"><?php echo $pageTitle ?></h1>
<div class="create-ad block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading"><?php echo $pageTitle ?></div>
            <div class="panel-body">
            <div class="row">
                <div class="col-md-8">
                          
                          
               <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
                 <div class="form-group form-group-lg ">
                     <label class="col-sm-3 control-label">Nom</label>
                     <div class="col-sm-10 col-sm-9">
                         <input type="text" name="name" class="form-control"   />
                     </div>
                 </div> 
                     
                  <div class="form-group form-group-lg ">
                     <label class="col-sm-3 control-label">Description</label>
                     <div class="col-sm-10 col-sm-9">
                         <textarea name="description" class="form-control "/></textarea>
                     </div>
                 </div> 
                 
                   <div class="form-group form-group-lg ">
                        <label class="col-sm-3 control-label">Prix</label>
                        <div class="col-sm-10 col-sm-9">
                           <input type="text" name="price" class="form-control "/>
                        </div>
                   </div> 
                   
                       <div class="form-group form-group-lg ">
                        <label class="col-sm-3 control-label">Quantité</label>
                        <div class="col-sm-10 col-sm-9">
                           <input type="text" name="Quantité" class="form-control" />
                        </div>
                   </div> 
                  
                 
                  <div class="form-group form-group-lg ">
                     <label class="col-sm-3 control-label">Made in </label>
                     <div class="col-sm-10 col-sm-9">
                         <input type="text" name="country" class="form-control" />
                     </div>
                 </div> 
                 
                  <div class="form-group form-group-lg ">
                     <label class="col-sm-3 control-label">Statu</label>
                     <div class="col-sm-10 col-sm-9">
                      <select name=" status">
                          <option value="">...</option>
                          <option value="1">NOUVEAU</option>
                          <option value="2">UTILISE</option>
                          <option value="3">VIEUX</option>
                      </select>
                     </div>
                 </div> 
                 
                   <div class="form-group form-group-lg ">
                     <label class="col-sm-3 control-label">Categorie</label>
                     <div class="col-sm-10 col-sm-9">
                      <select name="category">
                          <option value="">...</option>
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
                     <label class="col-sm-3 control-label">Image</label>
                     <div class="col-sm-10 col-sm-9">
                         <input type="file" name="avatar" class="form-control" />
                     </div>
                 </div>
            
                  <div class="form-group form-group-lg">
                     <div class="col-sm-offset-3 col-sm-9">
                         <input type="submit" value="Ajouter Produit" class="btn btn-primary btn-sm"/>
                     </div>
                 </div>  
               </form>
                          
                </div>
             
            </div>
            
              <?php
                if(! empty($formErrors)){
                  foreach($formErrors as $error){
                   echo '<div class="alert alert-danger">' . $error . '</div>';
                  }
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
?>