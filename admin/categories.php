<?php
/* gerer les membre de la page*/
ob_start();
session_start();
$pageTitle = 'Categories';

if(isset($_SESSION['Username'])){
 
    
    include'init.php';
    
   $do = isset($_GET['do'])? $_GET['do'] : 'Manage';
    
    if($do == 'Manage'){
        
        $sort = 'ASC'; // valeur par defaut
        $sort_array = array('ASC', 'DESC');
        if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
        
              $sort = $_GET['sort'];
        
        }
        
        $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
        $stmt2->execute();
        $cats = $stmt2->fetchAll();
    if(!empty($cats)){
?>
       
         <h1 class="text-center" style="color:black;">Gestion des categories</h1> 
       <div class="container categories">
           <div class="panel panel-default">
               <div class="panel-heading">
               <i class="fa fa-edit" style="color:black;"></i><b style="color:black;">Gestion des categories</b>
               
               </div>
               <div class="panel-body">
                <?php
                 foreach($cats as $cat){
                    echo "<div class='cat'>";  
                     
                     echo"<div class='hidden-buttons'>";
                      echo"<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class=' btn btn-xs btn-primary'><i class='fa fa-edit'></i>Modifier</a>";
                      echo"<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Supprimer</a>";
                     echo"</div>";
                     
                    echo "<h3>" . $cat['Name'] . '</h3>';
                    echo "<div class='full-view'>";
                     
                       echo "<p>"; if($cat['Description']=='' ){echo 'Cette Categorie contient cas ce description';}else {echo $cat['Description']; } echo "</p>";
                       
                     echo"</div>";
                    echo"</div>";
                    echo"<hr>";
                     }
                   ?>
               </div>
           </div>
        <a class="  add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i>Ajouter une categorie</a>
          
       </div>
           
        <?php }else {
          echo '<div class="container">';
            echo '<div class="nice-message">Pas de Categories A Voir</div>';
            echo '<a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i>Ajouter une Categorie</a>';

          echo'</div>';
        
        }?>
    
     <?php
    } else if($do == 'Add'){ ?>
    
          <h1 class="text-center" style="color:black;">Ajouter une nouvelle categorie</h1>        
           <div class="container">
               <form class="form-horizontal" action="?do=Insert" method="POST">
                 <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Nom</label>
                     <div class="col-sm-10 col-sm-6">
                         <input type="text" name="name" class="form-control" autocomplete="off" required="required"/>
                     </div>
                 </div> 
                  <div class="form-group form-group-lg">
                     <label class="col-sm-2 control-label">Description</label>
                     <div class="col-sm-10 col-sm-6">
                         <textarea name="description" class=" form-control"></textarea>
                     </div>
                 </div>
                  <div class="form-group form-group-lg">
                     <label class="col-sm-2 control-label">Ordre</label>
                     <div class="col-sm-10 col-sm-6">
                         <input type="text" name="ordering" class="form-control"/>
                     </div>
                 </div>
                  <div class="form-group form-group-lg">
                     <div class="col-sm-offset-2 col-sm-10">
                         <input type="submit" value="Ajouter" class=" confirm btn btn-primary btn-lg"/>
                     </div>
                 </div>  
               </form>
            </div> 
     
     <?php
    }else if($do == 'Insert'){
    
         if ($_SERVER['REQUEST_METHOD'] == 'POST'){
          //get variables form the form
          
          echo"<h1 class='text-center'>Inserer categorie</h1>";
         echo"<div class='container'>";
           // recuperer les valeur entrer du formulaire
          $name = $_POST['name'];
          $desc = $_POST['description'];
          $order  = $_POST['ordering'];
        
     
              
             $check = checkItem("Name", "categories", $name) ;// verifier si la categorie existe deja dans la table
                 if($check  == 1){
                     
                  $theMsg="<div class='alert alert-danger'>Cette Categorie Existe Déja</div>";
                  redirectHome($theMsg, 'back');
             
               }else{
              
                   $stmt = $con->prepare("INSERT INTO categories(Name, Description, Ordering) VALUES(:name, :desc, :order)");
                   $stmt->execute(array(
                   'name'=> $name,
                   'desc'=> $desc,
                   'order'=> $order,
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
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid'])? intval($_GET['catid']) : 0;
      
         $stmt = $con->prepare("SELECT * FROM categories WHERE ID =? ");
        $stmt->execute(array($catid));
        $cat = $stmt->fetch();
        $count = $stmt->rowCount();
      
    if($count>0){ ?> 
          
        <h1 class="text-center" style="color:black;">Modifier categorie</h1>        
           <div class="container">
               <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="catid" value="<?php echo $catid ?>"/>

                 <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Non</label>
                     <div class="col-sm-10 col-sm-6">
                         <input type="text" name="name" class="form-control" required="required" value="<?php echo $cat['Name']?>"/>
                     </div>
                 </div> 
                  <div class="form-group form-group-lg">
                     <label class="col-sm-2 control-label">Description</label>
                     <div class="col-sm-10 col-sm-6">
                         <textarea name="description" class=" form-control" value="<?php echo $cat['Description']?>"></textarea>
                     </div>
                 </div>
                  <div class="form-group form-group-lg">
                     <label class="col-sm-2 control-label">Ordre</label>
                     <div class="col-sm-10 col-sm-6">
                         <input type="text" name="ordering" class="form-control" value="<?php echo $cat['Ordering']?>"/>
                     </div>
                 </div>
                 
                  <div class="form-group form-group-lg">
                     <div class="col-sm-offset-2 col-sm-10">
                         <input type="submit" value="Enregistrer" class=" confirme btn btn-primary btn-lg"/>
                     </div>
                 </div>  
               </form>
            </div>
   
   <?php
      }else{
        
        echo"<div class='container'>";
        
        $theMsg ='<div class="alert alert-danger">Error(ID Entrer N\'Existe Pas)</div>';
        
        redirectHome($theMsg);
        
        echo"</div>";
        
    
    }
    }else if($do == 'Update'){
    
     echo"<h1 class='text-center'>Mettre a Jour</h1>";
       echo"<div class='container'>";
        
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){
          //get variables form the form
          $id = $_POST['catid'];
          $name = $_POST['name'];
          $desc = $_POST['description'];
          $order  = $_POST['ordering'];
          
 
              
          $stmt = $con->prepare("UPDATE categories SET Name = ?, Description = ?, Ordering = ? WHERE ID = ?");
          $stmt->execute(array($name, $desc, $order, $id));
          
            $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'Enregistrement mis à jour
</div>';
            redirectHome($theMsg, 'back'); 
          
          
    }else{
         $theMsg = '<div class="alert alert-danger">On Peut Pas Acceder Directement</div>';
         redirectHome($theMsg);      
      }
        echo"</div>";  
        
    }else if($do == 'Delete'){
         echo"<h1 class='text-center'>Supprimer Categorie</h1>";
         echo"<div class='container'>";
        
         $catid = isset($_GET['catid']) && is_numeric($_GET['catid'])? intval($_GET['catid']) : 0;
     // on select le id qu'on chercher(car on supprime par rapport a l'id rechercher)
        // select all depend on id
         $check = checkItem('ID', 'categories', $catid);
        
         if($check>0){ 
             
           $stmt = $con->prepare("DELETE FROM categories WHERE ID= :id");
            $stmt->bindParam(":id", $catid);
            $stmt->execute();
             
            $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'Enregistrement Supprimer</div>';
            redirectHome($theMsg, 'back');
             
         }else{
             
           $theMsg="<div class='alert alert-danger'>ID N\'Existe Pas</div>";
           redirectHome($theMsg);
         }
        
       echo'</div>';
    
    }
    include $tpl . 'footer.php';
    
}else { // si le mdp et pseudo sont faux alors on rest sur la mm page (index)
     header('Location: index.php');
     exit();
}
  ob_end_flush();

?>