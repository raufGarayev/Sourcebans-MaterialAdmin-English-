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

global $userbank, $ui, $theme;
if(!defined("IN_SB")){echo "Permission error!";die();}
if($GLOBALS['config']['config.enablesubmit']!="1")
{
	CreateRedBox("Error", "Page disabled.");
	PageDie();
}

$sinfo = new CServerControl(intval($GLOBALS['config']['gamecache.enabled']) == 1);

if (!isset($_POST['subban']) || $_POST['subban'] != 1)
{
	$SteamID = "";
	$BanIP = "";
	$PlayerName = "";
	$BanReason = "";
	$SubmitterName = "";
	$Email = "";
	$SID = -1;
}
else
{
	$SteamID = trim(htmlspecialchars($_POST['SteamID']));
	$BanIP = trim(htmlspecialchars($_POST['BanIP']));
	$PlayerName = htmlspecialchars($_POST['PlayerName']);
	$BanReason = htmlspecialchars($_POST['BanReason']);
	$SubmitterName = htmlspecialchars($_POST['SubmitName']);
	$Email = trim(htmlspecialchars($_POST['EmailAddr']));
	$SID = (int)$_POST['server'];
	$validsubmit = true;
	$errors = "";
	if((strlen($SteamID)!=0 && $SteamID != "STEAM_0:") && !validate_steam($SteamID))
	{
		$errors .= '* Type valid STEAM ID.<br>';
		$validsubmit = false;
	}
	if(strlen($BanIP)!=0 && !validate_ip($BanIP))
	{
		$errors .= '* Type valid IP Adress.<br>';
		$validsubmit = false;
	}
	if (strlen($PlayerName) == 0)
	{
		$errors .= '* You should type player nickname<br>';
		$validsubmit = false;
	}
	if (strlen($BanReason) == 0)
	{
		$errors .= '* You should type reason<br>';
		$validsubmit = false;
	}
	if (!check_email($Email))
	{
		$errors .= '* You should type you Email<br>';
		$validsubmit = false;
	}
	if($SID == -1)
	{
		$errors .= '* Choose server.<br>';
		$validsubmit = false;
	}
	if(!empty($_FILES['demo_file']['name']))
	{
		if(!CheckExt($_FILES['demo_file']['name'], "zip") && !CheckExt($_FILES['demo_file']['name'], "rar") && !CheckExt($_FILES['demo_file']['name'], "dem") &&
		   !CheckExt($_FILES['demo_file']['name'], "7z") && !CheckExt($_FILES['demo_file']['name'], "bz2") && !CheckExt($_FILES['demo_file']['name'], "gz"))
		{
			$errors .= '* File format should be zip, rar, 7z, bz2 or gz.<br>';
			$validsubmit = false;
		}
	}
	$checkres = $GLOBALS['db']->Execute("SELECT length FROM ".DB_PREFIX."_bans WHERE authid = ? AND RemoveType IS NULL", array($SteamID));
	$numcheck = $checkres->RecordCount();
	if($numcheck == 1 && $checkres->fields['length'] == 0)
	{
		$errors .= '* Player already banned permanently.<br>';
		$validsubmit = false;
	}


	if(!$validsubmit)
		CreateRedBox("Error", $errors);

	if ($validsubmit)
	{
		$filename = md5($SteamID.time());
		//echo SB_DEMOS."/".$filename;
		$demo = move_uploaded_file($_FILES['demo_file']['tmp_name'],SB_DEMOS."/".$filename);
		if($demo || empty($_FILES['demo_file']['name']))
		{
			if($SID!=0) {
				$res = $GLOBALS['db']->GetRow("SELECT ip, port FROM ".DB_PREFIX."_servers WHERE sid = $SID");
				
				$sinfo->Connect($res[0],$res[1]);
				
				$info = $sinfo->GetInfo();
				if($info)
					$mailserver = "Server: " . $info['HostName'] . " (" . $res[0] . ":" . $res[1] . ")\n";
				else
					$mailserver = "Server: Connection error (" . $res[0] . ":" . $res[1] . ")\n";
				$modid = $GLOBALS['db']->GetRow("SELECT m.mid FROM `".DB_PREFIX."_servers` as s LEFT JOIN `".DB_PREFIX."_mods` as m ON m.mid = s.modid WHERE s.sid = '".$SID."';");
			} else {
				$mailserver = "Server: Other server\n";
				$modid[0] = 0;
			}
			if($SteamID == "STEAM_0:") $SteamID = "";
			$pre = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_submissions(submitted,SteamId,name,email,ModID,reason,ip,subname,sip,archiv,server) VALUES (UNIX_TIMESTAMP(),?,?,?,?,?,?,?,?,0,?)");
			$GLOBALS['db']->Execute($pre,array($SteamID,$PlayerName,$Email,$modid[0],$BanReason, $_SERVER['REMOTE_ADDR'], $SubmitterName, $BanIP, $SID));
			$subid = (int)$GLOBALS['db']->Insert_ID();

			if(!empty($_FILES['demo_file']['name']))
				$GLOBALS['db']->Execute("INSERT INTO ".DB_PREFIX."_demos(demid,demtype,filename,origname) VALUES (?, 'S', ?, ?)", array($subid, $filename, $_FILES['demo_file']['name']));
			$SteamID = "";
			$BanIP = "";
			$PlayerName = "";
			$BanReason = "";
			$SubmitterName = "";
			$Email = "";
			$SID = -1;

			// Send an email when ban was posted
			$headers = 'From: submission@' . $_SERVER['HTTP_HOST'] . "\n" . 'X-Mailer: PHP/' . phpversion();

			$admins = $userbank->GetAllAdmins();
			$requri = substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], ".php")-5);
			foreach($admins AS $admin)
			{
				$message = "";
				$message .= "Hello, " . $admin['user'] . ",\n\n";
				$message .= "New ban submission added to SourceBans:\n\n";
				$message .= "Player: ".$_POST['PlayerName']." (".$_POST['SteamID'].")\nDemo: ".(empty($_FILES['demo_file']['name'])?'Missing':'Presenting (http://' . $_SERVER['HTTP_HOST'] . $requri . 'getdemo.php?type=S&id='.$subid.')')."\n".$mailserver."Reason: ".$_POST['BanReason']."\n\n";
				$message .= "Click link to view ban submission.\n\nhttp://" . $_SERVER['HTTP_HOST'] . $requri . "index.php?p=admin&c=bans#^2";
				if($userbank->HasAccess(ADMIN_OWNER|ADMIN_BAN_SUBMISSIONS, $admin['aid']) && $userbank->HasAccess(ADMIN_NOTIFY_SUB, $admin['aid']))
					mail($admin['email'], "[SourceBans] Ban submission added", $message, $headers);
			}
			CreateGreenBox("Success", "Your report is added and will be viewed one of admins.");
		}
		else
		{
			CreateRedBox("Error", "Error uploading demo. Try later.");
			$log = new CSystemLog("e", "Error uploading demo", "Error uploading demo for ban submission from (". $Email . ")");
		}
	}
}

//$mod_list = $GLOBALS['db']->GetAssoc("SELECT mid,name FROM ".DB_PREFIX."_mods WHERE `mid` > 0 AND `enabled`= 1 ORDER BY mid ");
//serverlist
$server_list = $GLOBALS['db']->Execute("SELECT sid, ip, port FROM `" . DB_PREFIX . "_servers` WHERE enabled = 1 ORDER BY modid, sid");
$servers = array();
while (!$server_list->EOF)
{
	$info = array();
	$sinfo->Connect($server_list->fields[1], $server_list->fields[2]);
	$info = $sinfo->GetInfo();
	if(!$info)
		$info['HostName'] = "Connection error (" . $server_list->fields[1] . ":" . $server_list->fields[2] . ")";
	$info['sid'] = $server_list->fields[0];
	array_push($servers,$info);
	$server_list->MoveNext();
}

$theme->assign('STEAMID',		$SteamID==""?"STEAM_0:":$SteamID);
$theme->assign('ban_ip',			$BanIP);
$theme->assign('ban_reason',	$BanReason);
$theme->assign('player_name',	$PlayerName);
$theme->assign('subplayer_name',$SubmitterName);
$theme->assign('player_email',	$Email);
$theme->assign('server_list',		$servers);
$theme->assign('server_selected',	$SID);

$theme->display('page_submitban.tpl');
?>
