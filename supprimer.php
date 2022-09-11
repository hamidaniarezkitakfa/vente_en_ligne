<?php 
session_start();
 if(isset($_SESSION['user'])){
 
   
    include'init.php';
        
         $userid = $_SESSION['uid'];
     // on select le id qu'on chercher(car on supprime par rapport a l'id rechercher)
        // select all depend on id
        
           $stmt = $con->prepare("DELETE FROM users WHERE UserID=?");
            $stmt->execute(array($userid));
             
      header('Location: logout.php');
         
        
    
     }
    
?>