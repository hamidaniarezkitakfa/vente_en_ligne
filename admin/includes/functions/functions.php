<?php
function getTitle(){
  global $pageTitle;
    if(isset($pageTitle)){
      echo $pageTitle;
    }else{
    
     echo'Default';
    }

}
/*
** Home redirect function[this function accept parameters]
**$theMsg = echo the message[error ou success ou warning}
**$seconds=seconds before redirecting
** $url = the link you want to redirect*
** cette fonction nous permet a chaque erreur ou succé de retourner a la page principale d'ou on vient $url
*/
function redirectHome($theMsg, $url = null, $seconds = 3){
    
    if($url == null){ //si il ya pas de page ou on veut retourner alors on retourne ar home
    
      $url='index.php';
      $link= 'PAGE ACCUEIL';
    }else{   //si on est venu d'une page alors on retourne direct ar ghoures 
        if(isset($_SERVER['HTTP_REFERER'])&& $_SERVER['HTTP_REFERER'] !== ''){
        
           $url = $_SERVER['HTTP_REFERER'];
           $link= 'page précédente';

        }else{
           $url = 'index.php';
            $link= 'homepage';
        }
    
    }
 echo $theMsg;
 echo"<div class='alert alert-info'>Vous Serez Envoyer Dans la $link Apres $seconds Secondes</div>";
    header("refresh:$seconds;url=$url");
    exit();
}
/*
** check items function v1.0
** function to check item in database
** $select = the item to select ('exmp: user item category)
** $from = the table to select from (users)
** $value = the value of select 
*/
function checkItem($select, $from, $value){
   global $con;
    $statement = $con->prepare("SELECT $select FROM $from WHERE $select =?");
    $statement->execute(array($value));
    $count = $statement->rowCount();
     return $count;
}
/*
** count number of items function v1
** function to count number of items rows
** $item = the item to count
** $table = the table to choose from
*/
function countItems($item, $table){
   global $con;
    
     $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
     $stmt2->execute();
     return $stmt2->fetchColumn();
    
}
/*
** get latest records function v1.0
** function to get latest items from database[users,items,comments]
** $select = le champ a selectionné
** $limit = number og records to get
** $order = ordonner par rapport a quoi exp($order=UserID)
** DESC decsendant car latest items
*/
function getLatest($select, $table, $order, $limit=5){
  global $con;
    $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $getStmt->execute();
    $rows = $getStmt->fetchAll();
    return $rows;
}