<?php
$temp_menu='';

$temp_menu.='<div><ul>';
foreach( $menu_array as $key => $value)
{
	  $temp_menu.='<li><a href="'.$value.'">'.$key.'</a></li>';
}
$temp_menu.='</ul></div>';


$menu=$temp_menu;
?>
