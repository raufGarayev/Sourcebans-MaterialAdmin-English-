<?php 
if(!defined("IN_SB"))
{
	echo "Permission error!";
	die();
}
$GLOBALS['TitleRewrite'] = "Advanced comms block searching";
require(TEMPLATES_PATH . "/admin.comms.search.php"); //Set theme vars from servers page
?>