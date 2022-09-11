<?php 
ob_start();
session_start();
$pageTitle ='Accueil';
include 'init.php';
?>
<link rel="stylesheet" type="text/css" href="acceuil.css" media="all"/>

<section id="cover">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 ">
                <h1 class="home-right" style="color:orange; font-family:monospace;">sjdwecfewfcefwe</h1>
               <a href="index.php"><i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
        
    </div>
</section>








<div class="footer">
    
</div>
<script src="<?php echo $js ;?>jquery-1.12.1.min.js"></script>
<script src="<?php echo $js ;?>jquery-ui.min.js"></script>
<script src="<?php echo $js ;?>jquery.selectBoxIt.min.js"></script>
<script src="<?php echo $js ;?>bootstrap.min.js"></script>
<script src="<?php echo $js ;?>sam.js"></script>


















</body>
</html>
<?php
ob_end_flush()
?>