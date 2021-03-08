<?php

//session_start();

$prod=true;
$title="Accueil";
$sitename="L'heure en français";
$url="http://heures.renaudguezennec.eu/";
$root="/";
$body="";
$home="Accueil";
$github="https://github.com/obiwankennedy/";
$currentLang=array();
$template="include/template/template.html";
$menu_array=array("Home"=>"/");
$description="";
$css='stylesheet';
$jquery= $prod ? "jquery-3.6.0.min.js" : "jquery-3.6.0.js";


# Imports
require_once("include/libphp/lib.php");
//print_r($_GET);

if(!empty($_GET['path']))
{
  $currentPage = $_GET['path'];
  $currentPath = explode('/',$_GET['path']);
}
else
{
  $currentPage="default";
}




//page
$includedpage = "";
if((!empty($currentPage)&&($currentPage!="/")))
{

  if(file_exists('modules/'.$currentPage.".php"))
  {
    $includedpage = 'modules/'.$currentPage.".php";
  }
  else	 if(file_exists('modules/'.$currentPage."/index.php"))
  {
    $includedpage = 'modules/'.$currentPage."/index.php";
  }
  else if(file_exists('modules/'.$currentPath[0].".php"))
  {
    $includedpage = 'modules/'.$currentPath[0].".php";
  }
  else if(file_exists('modules/'.$currentPath[0]."/index.php"))
  {
    $includedpage = 'modules/'.$currentPath[0]."/index.php";
  }
  else if(file_exists('modules/'.$currentPath[0].'/'.$currentPath[0].'.php'))
  {
    $includedpage = 'modules/'.$currentPath[0].'/'.$currentPath[0].'.php';
  }

}
else
{
  $includedpage = "modules/default/index.php";
}


if(strpos($includedpage,"modules/api")=== false)
{
  require_once($includedpage);

  //menu
  require_once("menu.php");

  //template
  require_once($template);

}
else
{
  require_once($includedpage);
}

?>
