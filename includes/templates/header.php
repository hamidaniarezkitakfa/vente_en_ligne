<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8"/>
      <title><?php getTitle()?></title>
    <link rel="stylesheet" href="<?php echo $css ;?>bootstrap2.css"/>
     <link rel="stylesheet" href="<?php echo $css ;?>font-awesome.min.css"/>
     <link rel="stylesheet" href="<?php echo $css ;?>jquery.selectBoxIt.css"/>
     <link rel="stylesheet" href="<?php echo $css ;?>jquery-ui.css"/>
    <link rel="stylesheet" href="<?php echo $css ;?>fontoriginal.css"/>
 
  </head>
<body>
<div class="upper-bar" style="background-color:cadetblue;"> 
   <div class="container">
   <?php
     if(isset($_SESSION['user'])){ ?>
         <div class="btn-group pull-right">
             <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                 <?php echo $sessionUser?>
                 <span class="caret"></span>
             </span>
                     <ul class="dropdown-menu">
                        <li><a href=profile.php>Mon profil</a></li>
                         <li><a href="newad.php">Ajouter produit</a></li>
                         <li><a href="profile.php#my-ads">Mes produits</a></li>
                         <li><a href="logout.php">Deconnexion</a></li>
                         <li><a href="supprimer.php">Supprimer Mon Compte</a></li>
                     </ul>
                
         </div>
         
         
     <?php
     }else{
         ?>
   <a href="login.php">
       <span class="pull-right " style="font-family:Georgia;font-size:19px; color:black;"><b>Se Connecter / S'inscrire</b></span>
   </a>

   <?php } ?> 
</div>
<div class="nav navbar-nav navbar-left sam" style="margin-top:-50px;" >
<h3>MS-Teck</h3> 
</div>
</div>
<nav class="navbar navbar-inverse">
    <div class="container ">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="accueil.php" style="font-size:18px; color:black;">Accueil</a>
        </div>
        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="nav navbar-nav navbar-right">
              <?php
                 foreach (getCat() as $cat){
                   echo '<li><a href="categories.php?pageid=' .$cat['ID'] . '" style="font-size:18px; color:black;">' . $cat['Name'] . '</a></li>';
                 }
                ?>
           </ul>
        </div>
    </div>
</nav>