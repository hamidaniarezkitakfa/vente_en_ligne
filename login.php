<?php 
ob_start();
session_start();
$pageTitle ='Connexion';

if(isset($_SESSION['user'])){ //si l'utilisateur qd il se connecte et il est deja membre alors l'envoyer a la page d'acceuil
 header('Location: index.php');
}

include 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if(isset($_POST['Login'])){ // si je viens de login alors:
    
     $user = $_POST['username'];
     $pass = $_POST['password'];
     $hashedPass = sha1($pass);
     
     //verifier si l'utilisateur exist dans la bdd
     $stmt = $con->prepare("SELECT UserID, Username,Password,RegStatus FROM users WHERE Username = ? AND Password = ? ");
     $stmt->execute(array($user, $hashedPass));
    $get = $stmt->fetch();
    $count = $stmt->rowCount();
    
     if ($count>0 and ($get['RegStatus']==1)){
      $_SESSION['user'] = $user; //rengistrer le nom
      $_SESSION['uid'] = $get['UserID'];
         header('Location: accueil.php');
         exit();
       } else{
     
       echo "<div class='alert alert-danger'>Information incorrecte</div>";
     }
        
    } else {
      $formErrors = array(); 
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $email = $_POST['email'];
         $name = $_POST['name'];
        // verifier les champs avant de les remplires
     if(isset($username)){
         
      $filterdUser = filter_var($username, FILTER_SANITIZE_STRING);
         
         if(strlen($filterdUser)<4){
              
             $formErrors[] = 'Pseudo doit contenir plus de 4 caracteres';
             
         }
     }
        
     if(isset($password ) && isset($password2)){
          if(empty($password )){
              
             $formErrors[] = 'Veuillez entrer Un mot de passe';
             
         }
         
         $pass1 = sha1($password );
         $pass2 = sha1($password2);
         
         if($pass1 !== $pass2){
              
             $formErrors[] = 'Veuillez entrer le meme mot de passe';
             
         }
     }
            
    // VERIFIER l'email avc php et sql et mettre dans le champ email type text pour pas avoir un email qui a n'importe koi et qui utile seulement @ et . exp : 111@JJ.com 
     if(isset($email)){
         
      $filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
         
         if(filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true){
              
             $formErrors[] = 'Votre email est pas valide';
             
         }
     }
        
        
                  if(empty($formErrors)){
              
             $check = checkItem("Username", "users", $username) ;// verifier si le usrname existe deja dans la table users qui a la valeur $user
                 if($check  == 1){
                     
                  $formErrors[] ='Ce Pseudo Existe Déja';
                 
               }else{
              
                   $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, FullName, RegStatus, Date) VALUES(:user, :pass, :mail,:name, 0, now())");
                   $stmt->execute(array(
                   'user'=> $username,
                   'pass'=> sha1($password),
                       'name'=>$name,
                      'mail'=> $email,
                   
        ));
                    
            $succesMsg = 'votre compte a été créé avec succès';
             }
          }
        
        
    }
 }

?>

<div class="container login-page">
    <h1 class="text-center">
        <span class="selected" data-class="login">Connexion</span>      <span
        data-class="signup">Inscription</span>
    </h1>
    <!-- begin login part -->
    <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
       <div class="input-container">
       
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Entrez Votre Pseudo" />
        
        </div>
        <div class="input-container">
        
        <input class="form-control" type="password" name="password" autocomplete="new-password"placeholder="Entrez Votre Mot de Passe"/>
        
        </div>
        <input class="btn btn-primary btn-block" name="Login" type="submit" value="Connexion" />
        
    </form>
    <!-- end login part -->
    <!-- begin signup part -->
    <form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
       
        <div class="input-container">
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Entrez Un Pseudo"/>
        </div>
        
        <div class="input-container">
        <input class="form-control" type="text" name="name" autocomplete="off" placeholder="Entrez Un Nom"/>
        </div>
        
         <div class="input-container">
        <input class="form-control" type="password" name="password" autocomplete="new-password"placeholder="Entrez Un Mot de Passe" />
        </div>
        
         <div class="input-container">
        <input class="form-control" type="password" name="password2" autocomplete="new-password"placeholder="Confirmer Votre Mot de Passe" />
        </div>
        
         <div class="input-container">
        <input class="form-control" type="text" name="email" placeholder="Entrez Un Email" />
        </div>
        
        <input class="btn btn-success btn-block" name ="signup" type="submit" value="S'inscrire" />
    </form>
    <!-- end signup part -->
    <div class="the-errors text-center">
         
         <?php
        if(!empty($formErrors)){
           foreach ($formErrors as $error ){
             echo'<div class="alert alert-danger">' . $error . '<div/>' ;
           }
        }
 
      if (isset($succesMsg)){
      echo'<div class="alert alert-success">' . $succesMsg . '<div/>' ;
      }
        ?>
  
    </div>
</div>
<?php
    include $tpl.'footer.php';
    ob_end_flush();
?>