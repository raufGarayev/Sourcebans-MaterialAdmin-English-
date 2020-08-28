<?php 
// *************************************************************************
//  This file is part of SourceBans++.
//
//  Copyright (C) 2014-2016 Sarabveer Singh <me@sarabveer.me>
//
//  SourceBans++ is free software: you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation, per version 3 of the License.
//
//  SourceBans++ is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU General Public License for more details.
//
//  You should have received a copy of the GNU General Public License
//  along with SourceBans++. If not, see <http://www.gnu.org/licenses/>.
//
//  This file is based off work covered by the following copyright(s):  
//
//   SourceBans 1.4.11
//   Copyright (C) 2007-2015 SourceBans Team - Part of GameConnect
//   Licensed under GNU GPL version 3, or later.
//   Page: <http://www.sourcebans.net/> - <https://github.com/GameConnect/sourcebansv1>
//
// *************************************************************************

global $theme, $userbank;

\Asserts::isNotLogged();

if(isset($_GET['validation'],$_GET['email']) && !empty($_GET['email']) && !empty($_GET['validation']))
{  
	$email = $_GET['email'];
	$validation = $_GET['validation'];
	$tryHack = false;
	
	if (is_array($email) || is_array($validation))
		$tryHack = true;
	
	if ($tryHack) {
		CreateRedBox("Error", "Blocked hacking attempt from invalid request. Current attempt logged on system!.");
		require(TEMPLATES_PATH . "/footer.php");
		$log = new CSystemLog("e", "Hacking attempt", "Possible hacking attempt from invalid SQL request.");
		exit();
	}
	
	preg_match("@^(?:http://)?([^/]+)@i", $_SERVER['HTTP_HOST'], $match);

	if($match[0] != $_SERVER['HTTP_HOST']) 
	{ 
		echo '<div class="alert alert-danger" role="alert" id="msg-red"><h4>Error!</h4><span class="p-l-10">Unknown error.</span></div>';
	
		require(TEMPLATES_PATH . "/footer.php");
		$log = new CSystemLog("w", "Error", "Trying reset password on use: " . $_SERVER['HTTP_HOST']);
		exit();
	}

	if(strlen($validation) < 60)
	{
		echo '<div class="alert alert-danger" role="alert" id="msg-red"><h4>Error!</h4><span class="p-l-10">Check string is too short.</span></div>';
	
		require(TEMPLATES_PATH . "/footer.php");
		exit();
	}
	
	$q = $GLOBALS['db']->GetRow("SELECT aid, user FROM `" . DB_PREFIX . "_admins` WHERE `email` = ? && `validate` IS NOT NULL && `validate` = ?", array($email, $validation));
	if($q)
	{
		$newpass = generate_salt(MIN_PASS_LENGTH+8);
		$query = $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_admins` SET `password` = '" . $userbank->encrypt_password($newpass) . "', validate = NULL WHERE `aid` = ?", array($q['aid']));
		$message = "Hello " . $q['user'] . ",\n\n";
		$message .= "Your password successfully reseted.\n";
		$message .= "Your password changed to: ".$newpass."\n\n";
		$message .= "Login to your SourceBans account and change your password.\n";

		$headers = 'From: SourceBans@' . $_SERVER['HTTP_HOST'] . "\n" .
		'X-Mailer: PHP/' . phpversion();
		$m = EMail($email, "Reset SourceBans password", $message, $headers);
		
		echo '<div class="alert alert-success" role="alert" id="msg-blue"><h4>Success!</h4><span class="p-l-10">Your password reseted and sent to your e-mail..<br />Check "Spam" folder too.<br />Please, login with using that password and then change it to normal password :).</span></div>';
	}
	else 
	{
		echo '<div class="alert alert-danger" role="alert" id="msg-red"><h4>Error!</h4><span class="p-l-10">Check string does not match e-mail adress for password reset.</span></div>';
	}
}else 
{
	$theme->display('page_lostpassword.tpl');
}
?>
