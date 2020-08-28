<?php
    $_need_expired = true;
    $_struct = $GLOBALS['db']->GetAll("DESCRIBE `" . DB_PREFIX . "_admins`");
    foreach ($_struct as $_obj) {
        if ($_obj['Field'] == "expired") {
            $_need_expired = false;
            break;
        }
    }
    
    if ($_need_expired) {
        $_expired = $GLOBALS['db']->Execute("ALTER TABLE `" . DB_PREFIX . "_admins` 
            ADD `expired` 	int(11) NULL;");
        
        if (!$_expired)
            return false;
    }
    
	$_admins = $GLOBALS['db']->Execute("ALTER TABLE `" . DB_PREFIX . "_admins` 
			ADD `skype`		varchar(128) 	NULL,
			ADD `comment`	varchar(128)	 NULL,
			ADD `vk`		varchar(128) 	NULL,
			ADD `support`	int(6) 			NULL DEFAULT '0';");

	if(!$_admins)
		return false;
		
	$_settings = $GLOBALS['db']->Execute("INSERT INTO `" . DB_PREFIX . "_settings` (`setting`, `value`) VALUES
			('config.dateformat_ver2', 'd.m.Y'),
			('config.text_home', 'Welcome to the game portal site: AZAZA'),
			('config.text_mon', 'You have the ability to control players through monitoring (test)'),

			('config.text_acc', 'Login successful!'),
			('config.text_acc2', 'Read the details on this page!'),

			('template.global', '0'),
			('dash.info_block',	'1'),
			('dash.info_block_text',	'<h1>Honey community</h1><br><center><img src=\"theme/img/pchelka.jpg\" class=\"img-responsive\" alt=\"\"></center>Additional info about us. TEST. lyrics: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. <br /> Additional information about us. TEST. lyrics: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. <br /> Additional information about us. TEST. lyrics: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.<br /><b>Everything is specified in the settings!</b>'),
			('dash.info_vk',	'http://vk.com/'),
			('dash.info_steam',	'http://steam.com/'),
			('dash.info_yout',	'http://youtube.com'),
			('dash.info_face',	'http://facebock.com/'),
			('dash.info_block_text_t',	'Best regards, main administration.'),
			('page.adminlist',	'0'),
			('page.xleb',	'1'),
			('theme.style', 'lightblue'),
			('theme.style.color', '');");
	
	if(!$_settings)
		return false;
    
    $qs  = array("UPDATE `" . DB_PREFIX . "_settings` SET `value` = '<center><p>SB Material Design has been successfully installed!</p><p>Welcome :)</p></center>' WHERE `setting` = 'dash.intro.text';",
            "UPDATE `" . DB_PREFIX . "_settings` SET `value` = 'images/logos/sb-dark.png' WHERE `setting` = 'template.logo';",
            "UPDATE `" . DB_PREFIX . "_settings` SET `value` = 'SourceBans :: MATERIAL' WHERE `setting` = 'template.title';",
            "UPDATE `" . DB_PREFIX . "_settings` SET `value` = '0' WHERE `setting` = 'config.enableprotest';",
            "UPDATE `" . DB_PREFIX . "_settings` SET `value` = '0' WHERE `setting` = 'config.enablesubmit';",
            "UPDATE `" . DB_PREFIX . "_settings` SET `value` = 'd.m.Y в H:i' WHERE `setting` = 'config.dateformat';",
            "UPDATE `" . DB_PREFIX . "_settings` SET `value` = 'new_box' WHERE `setting` = 'config.theme';",
            "UPDATE `" . DB_PREFIX . "_admins` SET `expired` = 0");
	foreach ($qs as &$query) {
        if (!$GLOBALS['db']->Execute($query)) return false;
	}

	return true;