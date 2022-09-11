<?php 
ob_start();
session_start();
$pageTitle ='Accueil';
include 'init.php';
?>

<div class="container">
    <h1 class="text-center"></h1>
    <div class="row"> 
    <?php
     $allItems = getAllFrom('items', 'where Approve = 1');
      foreach ($allItems as $item){
       echo '<div class="col-sm-6 col-md-3">';
        echo '<div class="thumbnail item-box">';
        echo '<span class="price-tag">' . $item['Price'] . 'DA</span>';
       echo"<td><img src='admin/uploads/avatars/" . $item['avatar'] . "' alt = '' /></td>";
        echo '<div class="caption">';
          echo '<h3><a href="items.php?itemid=' . $item['Item_ID'] .'">' . $item['Name'] . '</a></h3>';
          echo '<p>' . $item['Description'] . '<p>';
          echo '<div class="date">' . $item['Add_Date'] . '</div>';
        echo '</div>';
       echo '</div>';
    echo '</div>';
      }
     ?>
    </div>
</div>

<?php
include $tpl.'footer.php';
ob_end_flush()
?>