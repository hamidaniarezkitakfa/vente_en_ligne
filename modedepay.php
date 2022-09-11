<?php 
ob_start();
session_start();
$pageTitle ='Payer';
include 'init.php';
?>

<h1 class="text-center">Moyens de paiement</h1>
<div class="create-ad block">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Moyens de paiement</div>
            <div class="panel-body">
            <div class="row">
                <div class="col-md-8">     
                    <div class="form-group form-group-lg ">
                     <a href="#">Carte Bancaire</a>
                    </div>
                    
                    <div class="form-group form-group-lg ">
                     <a href="#">PayPal</a>
                    </div>
               
                </div>
             
            </div>
           
            </div>
        </div>
    </div>
</div>

<?php
include $tpl.'footer.php';
ob_end_flush()
?>