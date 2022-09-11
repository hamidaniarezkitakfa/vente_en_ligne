<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="dashboard.php" style="font-size:18px; color:white;">Accueil</a>
        </div>
        <div class="collapse navbar-collapse" id="app-nav" style="background color:red;">
            <ul class="nav navbar-nav ">
                <li><a href="categories.php" style="font-size:16px; color:white;">Categories</a></li>
                <li><a href="items.php" style="font-size:16px; color:white;">Produits</a></li>
                <li><a href="members.php" style="font-size:16px; color:white;">Membres</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="font-size:18px; color:white;">Admin<span class="caret"></span></a>
                    
                    <ul class="dropdown-menu">
                       <li><a href="../accueil.php">Visiter Le Site </a></li>
                        <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['ID']?>">Modifier Votre profile</a></li>
                        <li><a href="logout.php">Deconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>