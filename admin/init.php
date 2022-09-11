<?php
 include 'connect.php';

$tpl = 'includes/templates/';
$func = 'includes/functions/';
$css = 'layout/css/';
$js = 'layout/js/';

//include les page importante
include $func . 'functions.php';
include $tpl.'header.php';
// include navbar tte les page sauf les page ou il ya $nonavbar

if(!isset($noNavbar)){
 include $tpl.'navbar.php';
}


