<?php 
ob_start();
session_start();
$pageTitle ='profile';
include 'init.php';
if(isset($_SESSION['user'])){ // si l'utilsateur de deconnecte il sera envoyer a le formulaire
$userid = $_SESSION['uid'];      
         $stmt = $con->prepare("SELECT * FROM users WHERE UserID =?");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
?>
<h1 class="text-center">Mon profile</h1>
<div class="information block">
    <div class="container">

     <form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
       <input type="hidden" name="userid" value="<?php echo $userid ?>"/>
        <div class="input-container">
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Entrez Un Pseudo" value="<?php echo $row['Username']?>"/>
        </div>
    
         <div class="input-container">
        <input class="form-control" type="password" name="password" autocomplete="new-password"placeholder="Entrez Un Mot de Passe" required  />
        </div>
        
         <div class="input-container">
        <input class="form-control" type="password" name="password2" autocomplete="new-password"placeholder="Confirmer Votre Mot de Passe" required />
        </div>
        
         <div class="input-container">
        <input class="form-control" type="text" name="email" placeholder="Entrez Un Email" value="<?php echo $row['Email']?>" />
        </div>
        
        <input class="btn btn-success btn-block" name ="signup" type="submit" value="S'inscrire" />
    </form>
   
    </div>
</div>

<?php
     
            
        
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
          //get variables form the form
           
         
          $user = $_POST['username'];
          $email = $_POST['email'];
          
          $pass = sha1($_POST['password']);

  
              
             $stmt = $con->prepare("UPDATE users SET Username = ?,Email = ?, Password = ? WHERE UserID = $userid");
             $stmt->execute(array($user, $email, $pass));
             header('Location: logout.php');
        }
}else{
       header('Location: login.php');
       exit();

}

include $tpl.'footer.php';
ob_end_flush();
?>