<?php 
session_start();
$noNavbar = '';
$pageTitle ='Login';

if(isset($_SESSION['Username'])){
 header('Location: dashboard.php');
}
include 'init.php';

//verifier si l'utilisateur et entrer par le formulaire
 if ($_SERVER['REQUEST_METHOD'] == 'POST'){
     $username = $_POST['user'];
     $password = $_POST['pass'];
     $hashedPass = sha1($password);
     
     //verifier si l'utilisateur exist dans la bdd
     $stmt = $con->prepare("SELECT UserID, Username,Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1 LIMIT 1");
     $stmt->execute(array($username, $hashedPass));
     $row = $stmt->fetch();
     $count = $stmt->rowCount();
     if ($count>0){
      $_SESSION['Username'] = $username; //rengistrer le nom
      $_SESSION['ID'] = $row['UserID'];
        header('Location: dashboard.php');
         exit();
     }else{
       echo "<div class='alert alert-danger'>Information incorrecte</div>";
     }
 }

?>
<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
   <h4 class="text-center">Connexion Admin</h4>
    <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off"/>
    
    <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password"/>
    
    <input class="btn btn-primary btn-block" type="submit" value="Connexion"/> 
    
</form>
<?php
include $tpl.'footer.php';
?>