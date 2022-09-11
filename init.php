<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

 include 'admin/connect.php';
$sessionUser = '';// POUR AFFICHER le nom de l'utili si il est connecter sinn il affiche rien elle est declarer dans init.php

if(isset($_SESSION['user'])){
  $sessionUser = $_SESSION['user'];
}

$tpl = 'includes/templates/';
$func = 'includes/functions/';
$css = 'layout/css/';
$js = 'layout/js/';

//include les page importante
include $func . 'functions.php';
include $tpl.'header.php';
