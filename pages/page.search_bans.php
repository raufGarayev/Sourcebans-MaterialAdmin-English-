<?php 
if(!defined("IN_SB"))
{
	echo "Permission error!";
	die();
}
$GLOBALS['TitleRewrite'] = "Advanced searching";
require(TEMPLATES_PATH . "/admin.bans.search.php"); //Set theme vars from servers page
?>