<?php
$insq_menu = "INSERT INTO `".DB_PREFIX."_menu` (`id`, `text`, `description`, `url`, `system`, `enabled`, `priority`) VALUES";
$qs = array("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."_menu` ( `id` int(11) NOT NULL AUTO_INCREMENT, `text` varchar(256) NOT NULL, `description` varchar(450) NOT NULL, `url` varchar(300) NOT NULL, `system` tinyint(1) NOT NULL, `enabled` tinyint(1) NOT NULL, `priority` int(11) NOT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=8;",
       $insq_menu . " (1, '<i class=''zmdi zmdi-home zmdi-hc-fw''></i>Home ',' Home page of SourceBans. List of servers, last bans and blocks.', 'index.php?p=home', 1, 1, 1000);", 
       $insq_menu . " (2, '<i class=''zmdi zmdi-input-composite zmdi-hc-fw''></i> Servers ',' List of all servers and their current status.', 'index.php?p=servers', 1, 1, 999);", 
       $insq_menu . " (3, '<i class=''zmdi zmdi-lock-outline zmdi-hc-fw''></i> List of bans ',' List of all bans ever issued.', 'index.php?p=banlist', 1, 1, 998);", 
       $insq_menu . " (4, '<i class=''zmdi zmdi-mic-off zmdi-hc-fw''></i> List of mutes / gags ',' List of all mutes and gags ever issued.', 'index.php?p=commslist', 1, 1, 997);",
       $insq_menu . " (5, '<i class=''zmdi zmdi-plus-circle-o-duplicate zmdi-hc-fw''></i> Report a player ',' Here you can leave a complaint about a player.', 'index.php?p=submit', 1, 0, 996);",
       $insq_menu . " (6, '<i class=''zmdi zmdi-comment-edit zmdi-hc-fw''></i> Ban Appeal ',' You can appeal your ban by providing proof of innocence.', 'index.php?p=protest', 1, 0, 995);", 
       $insq_menu . " (7, '<i class=''zmdi zmdi-accounts zmdi-hc-fw''></i> Adminlist ',' List of administrators on available servers.', 'index.php?p=adminlist', 1, 0, 994);");

foreach ($qs as $query)
    if (!$GLOBALS['db']->Execute($query)) return false;

return true;
?>
