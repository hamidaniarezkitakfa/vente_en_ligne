<?php
/* gerer les membre de la page*/

session_start();
$pageTitle='Members';
if(isset($_SESSION['Username'])){
 
    
    include'init.php';
    
   $do = isset($_GET['do'])? $_GET['do'] : 'Manage';
    
    if($do == 'Manage'){
        
        // creation de l'url des membre en attente
        $query = '';
        if(isset($_GET['page'] )&& $_GET['page'] =='Pending'){
        
              $query = 'AND RegStatus = 0';
        }
        
      $stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=1 $query ORDER BY UserID DESC");
      $stmt->execute();
      $rows = $stmt->fetchAll();
        
        if(!empty($rows)){ // si il ya seulement des membre qu'on doit alors les afficher si il ya pas on affiche une page blanche

?>
    
     <h1 class="text-center" style="color:#648297;">Gestion des membres</h1>       
      <div class="container">
         <div class="table-responsive">
             <table class="main-table text-center table table-border">
                 <tr>
                     <td>ID</td>
                     <td>Pseudo</td>
                     <td>Email</td>
                     <td> Nom</td>
                     <td>Date d'ajout</td>
                     <td>Controle</td>
                 </tr>
                <?php
                    foreach($rows as $row){
                      echo"<tr>";
                        echo"<td>" . $row['UserID'] . "</td>";
                        echo"<td>" . $row['Username'] . "</td>";
                        echo"<td>" . $row['Email'] . "</td>";
                        echo"<td>" . $row['FullName'] . "</td>";
                        echo"<td>" . $row['Date'] . "</td>";
                        echo"<td>
                           <a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Supprimer</a>";
                        
                        if($row['RegStatus']==0){
                            
                         echo "<a href='members.php?do=Activate&userid=" . $row['UserID'] . "'class='btn btn-info'><i class='fa fa-check activate'></i> Activer</a>";
                        }
                        echo "</td>";
                      echo"</tr>";
                    }
                 
                   ?>
                 </tr>
          </table>
         </div>
        <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>Ajouter un nouveau membre</a>
      </div>
       
       
        <?php }else {
          echo '<div class="container">';
            echo '<div class="nice-message">Pas de Membres A Voir</div>';
            echo '<a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>Ajouter un nouveau membre</a>';

          echo'</div>';
        
        }?>
    <?php   
    }else if($do == 'Add'){ ?>
        
        <h1 class="text-center" style="color:black;">Ajouter un nouveau membre</h1>        
           <div class="container">
               <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                 <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Pseudo</label>
                     <div class="col-sm-10 col-sm-6">
                         <input type="text" name="username" class="form-control" autocomplete="off" required="required"/>
                     </div>
                 </div> 
                  <div class="form-group form-group-lg">
                     <label class="col-sm-2 control-label">Mot de passe</label>
                     <div class="col-sm-10 col-sm-6">
                         <input type="password" name="password" class="password form-control" autocomplete="new-password" required="required"/>
                         <i class="show-pass fa fa-eye fa-2x"></i>
                     </div>
                 </div>
                  <div class="form-group form-group-lg">
                     <label class="col-sm-2 control-label">Email</label>
                     <div class="col-sm-10 col-sm-6">
                         <input type="email" name="email" class="form-control"required="required"/>
                     </div>
                 </div>
                  <div class="form-group form-group-lg">
                     <label class="col-sm-2 control-label">Nom</label>
                     <div class="col-sm-10 col-sm-6">
                        <input type="text" name="full" class="form-control"required="required"/>
                     </div>
                 </div>
                  <div class="form-group form-group-lg">
                     <div class="col-sm-offset-2 col-sm-10">
                         <input type="submit" value="Ajouter Un Membre" class="confirm btn btn-primary btn-lg"/>
                     </div>
                 </div>  
               </form>
            </div>
    <?php
    } else if($do == 'Insert'){
        //inserer dans la bdd
        
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){
          //get variables form the form
          
          echo"<h1 class='text-center'>Inserer un Membre</h1>";
         echo"<div class='container'>";
          
          $user = $_POST['username'];
          $pass = $_POST['password'];
          $email = $_POST['email'];
          $name = $_POST['full'];
          $hashPass = sha1($_POST['password']);
        
          //valider le form(les controles)
          $formErrors = array();
          if (strlen($user)<4){
          $formErrors[] = 'pseudo peut pas avoir moin de 4 caracteres';
          }
          if (empty($pass)){
            $formErrors[] = 'mot de passe doit pas etre vide';
          }
          
          if (empty($name)){
          $formErrors[] = 'nom doit pas etre vide';
          }
          
          if (empty($email)){
           $formErrors[] = 'email doit pas etre vide';
          }
          //afficher tte les erreurs
          foreach($formErrors as $error){
             echo'<div class="alert alert-danger">' . $error . '<div/>' ;
          }
          //si il ya pas d'erreur on enregistre
          if(empty($formErrors)){
              
             $check = checkItem("Username", "users", $user) ;// verifier si le usrname existe deja dans la table users qui a la valeur $user
                 if($check  == 1){
                     
                  $theMsg="<div class='alert alert-danger'>Ce Pseudo Existe Déja</div>";
                  redirectHome($theMsg, 'back');
             
               }else{
              
                   $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, FullName, RegStatus, Date) VALUES(:user, :pass, :mail, :name, 1, now())");
                   $stmt->execute(array(
                   'user'=> $user,
                   'pass'=> $hashPass,
                   'mail'=> $email,
                   'name'=> $name,
        ));
                    
                  $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'Enregistrement mis à jour</div>';
                  redirectHome($theMsg, 'back');
             }
          }
          
    }else{
          echo"<div class= 'container'>";
          
           $theMsg = '<div class="alert alert-danger">on peut pas acceder directement</div>';
           redirectHome($theMsg);
          
          echo"</div>";
      }
        echo"</div>";
        
        
    }else if ($do == 'Edit'){ 
      $userid = isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']) : 0;
      
         $stmt = $con->prepare("SELECT * FROM users WHERE UserID =? LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
      
    if($count>0){ ?> 
          
    <h1 class="text-center">Modifier mon profile</h1>        
           <div class="container">
               <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="userid" value="<?php echo $userid ?>"/>
                 <div class="form-group form-group-lg ">
                     <label class="col-sm-2 control-label">Pseuso</label>
                     <div class="col-sm-10 col-sm-6">
                         <input type="text" name="username" class="form-control" value="<?php echo $row['Username']?>" autocomplete="off" required="required"/>
                     </div>
                 </div> 
                  <div class="form-group form-group-lg">
                     <label class="col-sm-2 control-label">Mot de passe</label>
                     <div class="col-sm-10 col-sm-6">
                         <input type="hidden" name="oldpassword" value="<?php echo $row['Password']?>" />
                         <input type="password" name="newpassword" class="form-control" autocomplete="new-password" />
                     </div>
                 </div>
                  <div class="form-group form-group-lg">
                     <label class="col-sm-2 control-label">Email</label>
                     <div class="col-sm-10 col-sm-6">
                         <input type="email" name="email" value="<?php echo $row['Email']?>" class="form-control"required="required"/>
                     </div>
                 </div>
                  <div class="form-group form-group-lg">
                     <label class="col-sm-2 control-label">Nom</label>
                     <div class="col-sm-10 col-sm-6">
                        <input type="text" name="full" value="<?php echo $row['FullName']?>" class="form-control"required="required"/>
                     </div>
                 </div>
                  <div class="form-group form-group-lg">
                     <div class="col-sm-offset-2 col-sm-10">
                         <input type="submit" value="Enregistrer" class="confirme btn btn-primary btn-lg"/>
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
    }else if ($do == 'Update'){ // mettre a jours les infos
        
       echo"<h1 class='text-center'>Mettre a jour</h1>";
       echo"<div class='container'>";
        
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){
          //get variables form the form
           
          $id = $_POST['userid'];
          $user = $_POST['username'];
          $email = $_POST['email'];
          $name = $_POST['full'];
          
          $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);
          
          //valider le form(les controles)
          $formErrors = array();
          if (strlen($user)<4){
          $formErrors[] = 'pseudo peut pas avoir moin de 4 caracteres';
          }
          if (empty($user)){
            $formErrors[] = 'pseudo doit pas etre vide';
          }
          
          if (empty($name)){
          $formErrors[] = 'nom doit pas etre vide';
          }
          
          if (empty($email)){
           $formErrors[] = 'email doit pas etre vide';
          }
          //afficher tte les erreurs
          foreach($formErrors as $error){
             echo'<div class="alert alert-danger">' . $error . '<div/>' ;
          }
          //si il ya pas d'erreur on enregistre
          if(empty($formErrors)){
          
              $stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");
              $stmt2->execute(array($user, $id));
              $count = $stmt2->rowCount();
              
              if ($count == 1){
                  
                 $theMsg= "<div class='alert alert-danger'> Desolé ce Pseudo Existe Déja </div>";
                redirectHome($theMsg, 'back');
              } else{
              
             $stmt = $con->prepare("UPDATE users SET Username = ?,Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
             $stmt->execute(array($user, $email, $name, $pass, $id));
          
              $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'Enregistrement mis à jour</div>';
            redirectHome($theMsg, 'back'); 
          }
          }
          
    }else{
         $theMsg = '<div class="alert alert-danger">On Peut Pas Acceder Directement</div>';
         redirectHome($theMsg);      
      }
        echo"</div>";
    }else if($do == 'Delete'){
        
         echo"<h1 class='text-center'>Upprimer Un Membre</h1>";
         echo"<div class='container'>";
        
         $userid = isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']) : 0;
     // on select le id qu'on chercher(car on supprime par rapport a l'id rechercher)
        // select all depend on id
         $check = checkItem('userid', 'users', $userid);
        
         if($check>0){ 
             
           $stmt = $con->prepare("DELETE FROM users WHERE UserID= :user");
            $stmt->bindParam(":user", $userid);
            $stmt->execute();
             
            $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'Enregistrement Supprimé</div>';
            redirectHome($theMsg, 'back');
             
         }else{
             
           $theMsg="<div class='alert alert-danger'> Cette ID Existe Pas</div>";
           redirectHome($theMsg);
         }
        
       echo'</div>';
        
    } else if($do == 'Activate'){
       
         echo"<h1 class='text-center'>Activer Un Membre</h1>";
         echo"<div class='container'>";
        
         $userid = isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']) : 0;
     // on select le id qu'on chercher(car on supprime par rapport a l'id rechercher)
        // select all depend on id
         $check = checkItem('userid', 'users', $userid);
        
         if($check>0){ 
              
             //mettre a jour de regstatus=1 pour que le membre devient active
           $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID =?");
            $stmt->execute(array($userid));
             
            $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'Enregistrement mis à jour</div>';
            redirectHome($theMsg);
             
         }else{
             
           $theMsg="<div class='alert alert-danger'> Cette ID Existe Pas</div>";
           redirectHome($theMsg);
         }
        
       echo'</div>';
    }
    
    include $tpl.'footer.php';
    
}else{
 header('Location: index.php');
    exit();
}
