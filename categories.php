<?php

ob_start();
session_start();
$pageTitle ='MS-Teck';

include 'init.php';


?>

<div class="container">
    <h1 class="text-center">Categories</h1>
    <div class="row"> 
    <?php
      foreach (getItems('Cat_ID', $_GET['pageid']) as $item){
       echo '<div class="col-sm-6 col-md-3">';
        echo '<div class="thumbnail item-box">';
        echo '<span class="price-tag">' . $item['Price'] . '</span>';
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
ob_end_flush();
include $tpl.'footer.php';
?>