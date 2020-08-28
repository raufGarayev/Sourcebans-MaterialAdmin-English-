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

global $userbank, $theme;

//serverlist
$server_list = $GLOBALS['db']->Execute("SELECT sid, ip, port FROM `" . DB_PREFIX . "_servers` WHERE enabled = 1");
$servers = array();
$serverscript = "<script type=\"text/javascript\">";
while (!$server_list->EOF)
{
	$info = array();
    $serverscript .= "xajax_ServerHostPlayers('".$server_list->fields[0]."', 'id', 'ss".$server_list->fields[0]."', '', '', false, 200);";
	$info['sid'] = $server_list->fields[0];
	$info['ip'] = $server_list->fields[1];
	$info['port'] = $server_list->fields[2];
	array_push($servers,$info);
	$server_list->MoveNext();
}
$serverscript .= "</script>";

//webgrouplist
$webgroup_list = $GLOBALS['db']->Execute("SELECT gid, name FROM ". DB_PREFIX ."_groups WHERE type = '1'");
$webgroups = array();
while (!$webgroup_list->EOF)
{
	$data = array();
	$data['gid'] = $webgroup_list->fields['gid'];
	$data['name'] = $webgroup_list->fields['name'];

	array_push($webgroups,$data);
	$webgroup_list->MoveNext();
}

//serveradmingrouplist
$srvadmgroup_list = $GLOBALS['db']->Execute("SELECT name FROM ". DB_PREFIX ."_srvgroups ORDER BY name ASC");
$srvadmgroups = array();
while (!$srvadmgroup_list->EOF)
{
	$data = array();
	$data['name'] = $srvadmgroup_list->fields['name'];
	
	array_push($srvadmgroups,$data);
	$srvadmgroup_list->MoveNext();
}

//servergroup
$srvgroup_list = $GLOBALS['db']->Execute("SELECT gid, name FROM " . DB_PREFIX . "_groups WHERE type = '3'");
$srvgroups = array();
while (!$srvgroup_list->EOF)
{
	$data = array();
	$data['gid'] = $srvgroup_list->fields['gid'];
	$data['name'] = $srvgroup_list->fields['name'];
	
	array_push($srvgroups,$data);
	$srvgroup_list->MoveNext();
}

//webpermissions
$webflag[] = array("name" => "Adminstrator", "flag"=>"ADMIN_OWNER");
$webflag[] = array("name" => "Admins List", "flag"=>"ADMIN_LIST_ADMINS");
$webflag[] = array("name" => "Add admin", "flag"=>"ADMIN_ADD_ADMINS");
$webflag[] = array("name" => "Edit admins", "flag"=>"ADMIN_EDIT_ADMINS");
$webflag[] = array("name" => "Remove admins", "flag"=>"ADMIN_DELETE_ADMINS");
$webflag[] = array("name" => "Servers list", "flag"=>"ADMIN_LIST_SERVERS");
$webflag[] = array("name" => "Add server", "flag"=>"ADMIN_ADD_SERVER");
$webflag[] = array("name" => "Edit servers", "flag"=>"ADMIN_EDIT_SERVERS");
$webflag[] = array("name" => "Remove servers", "flag"=>"ADMIN_DELETE_SERVERS");
$webflag[] = array("name" => "Add ban", "flag"=>"ADMIN_ADD_BAN");
$webflag[] = array("name" => "Edit own bans", "flag"=>"ADMIN_EDIT_OWN_BANS");
$webflag[] = array("name" => "Edit group bans", "flag"=>"ADMIN_EDIT_GROUP_BANS");
$webflag[] = array("name" => "Edit all bans", "flag"=>"ADMIN_EDIT_ALL_BANS");
$webflag[] = array("name" => "Ban protests", "flag"=>"ADMIN_BAN_PROTESTS");
$webflag[] = array("name" => "Ban submissions", "flag"=>"ADMIN_BAN_SUBMISSIONS");
$webflag[] = array("name" => "Remove bans", "flag"=>"ADMIN_DELETE_BAN");
$webflag[] = array("name" => "Unban own bans", "flag"=>"ADMIN_UNBAN_OWN_BANS");
$webflag[] = array("name" => "Unban group bans", "flag"=>"ADMIN_UNBAN_GROUP_BANS");
$webflag[] = array("name" => "Unban all bans", "flag"=>"ADMIN_UNBAN");
$webflag[] = array("name" => "Import bans", "flag"=>"ADMIN_BAN_IMPORT");
$webflag[] = array("name" => "Notify e-mail on ban submissions", "flag"=>"ADMIN_NOTIFY_SUB");
$webflag[] = array("name" => "Notify e-mail on ban protests", "flag"=>"ADMIN_NOTIFY_PROTEST");
$webflag[] = array("name" => "List groups", "flag"=>"ADMIN_LIST_GROUPS");
$webflag[] = array("name" => "Add group", "flag"=>"ADMIN_ADD_GROUP");
$webflag[] = array("name" => "Edit groups", "flag"=>"ADMIN_EDIT_GROUPS");
$webflag[] = array("name" => "Remove groups", "flag"=>"ADMIN_DELETE_GROUPS");
$webflag[] = array("name" => "Web settings", "flag"=>"ADMIN_WEB_SETTINGS");
$webflag[] = array("name" => "List mods", "flag"=>"ADMIN_LIST_MODS");
$webflag[] = array("name" => "Add mods", "flag"=>"ADMIN_ADD_MODS");
$webflag[] = array("name" => "Edit mods", "flag"=>"ADMIN_EDIT_MODS");
$webflag[] = array("name" => "Remove mods", "flag"=>"ADMIN_DELETE_MODS");
$webflags = array();
foreach($webflag AS $flag)
{
	$data['name'] = $flag["name"];
	$data['flag'] = $flag["flag"];
	
	array_push($webflags, $data);
}

//server permissions
$serverflag[] = array("name" => "[z] Root admin", "flag" => "SM_ROOT");
$serverflag[] = array("name" => "[a] Reserved slot", "flag" => "SM_RESERVED_SLOT");
$serverflag[] = array("name" => "[b] Generic", "flag" => "SM_GENERIC");
$serverflag[] = array("name" => "[c] Kick", "flag" => "SM_KICK");
$serverflag[] = array("name" => "[d] Ban", "flag" => "SM_BAN");
$serverflag[] = array("name" => "[e] Unban", "flag" => "SM_UNBAN");
$serverflag[] = array("name" => "[f] Slay", "flag" => "SM_SLAY");
$serverflag[] = array("name" => "[g] Change map", "flag" => "SM_MAP");
$serverflag[] = array("name" => "[h] Cvar access", "flag" => "SM_CVAR");
$serverflag[] = array("name" => "[i] Config settings", "flag" => "SM_CONFIG");
$serverflag[] = array("name" => "[j] Chat privilegies", "flag" => "SM_CHAT");
$serverflag[] = array("name" => "[k] Vote", "flag" => "SM_VOTE");
$serverflag[] = array("name" => "[l] Server password", "flag" => "SM_PASSWORD");
$serverflag[] = array("name" => "[m] Rcon", "flag" => "SM_RCON");
$serverflag[] = array("name" => "[n] Cheats", "flag" => "SM_CHEATS");
$serverflag[] = array("name" => "[o] Custom flag 1", "flag" => "SM_CUSTOM1");
$serverflag[] = array("name" => "[p] Custom flag 2", "flag" => "SM_CUSTOM2");
$serverflag[] = array("name" => "[q] Custom flag 3", "flag" => "SM_CUSTOM3");
$serverflag[] = array("name" => "[r] Custom flag 4", "flag" => "SM_CUSTOM4");
$serverflag[] = array("name" => "[s] Custom flag 5", "flag" => "SM_CUSTOM5");
$serverflag[] = array("name" => "[t] Custom flag 6", "flag" => "SM_CUSTOM6");
$serverflags = array();
foreach($serverflag AS $flag)
{
	$data['name'] = $flag["name"];
	$data['flag'] = $flag["flag"];
	
	array_push($serverflags, $data);
}

if($_GET['showexpiredadmins'] == 'true') {
	$plus_adm = "1";
}else {
	$plus_adm = "";
}

$theme->assign('exiperd_admins', $plus_adm);
$theme->assign('server_list', $servers);
$theme->assign('server_script', $serverscript);
$theme->assign('webgroup_list', $webgroups);
$theme->assign('srvadmgroup_list', $srvadmgroups);
$theme->assign('srvgroup_list', $srvgroups);
$theme->assign('admwebflag_list', $webflags);
$theme->assign('admsrvflag_list', $serverflags);
$theme->assign('can_editadmin', $userbank->HasAccess(ADMIN_EDIT_ADMINS|ADMIN_OWNER));

$theme->display('box_admin_admins_search.tpl');
?>