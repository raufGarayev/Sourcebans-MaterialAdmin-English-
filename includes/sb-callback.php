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


require_once('xajax.inc.php');
include_once('system-functions.php');
include_once('user-functions.php');
$xajax = new xajax();
//$xajax->debugOn();
$xajax->setRequestURI(XAJAX_REQUEST_URI);
global $userbank;

$methods = array(
  'admin' => array(
    'AddMod', 'RemoveMod', 'AddGroup', 'RemoveGroup', 'RemoveAdmin',
    'RemoveSubmission', 'RemoveServer', 'UpdateGroupPermissions',
    'UpdateAdminPermissions', 'AddAdmin', 'SetupEditServer',
    'AddServerGroupName', 'AddServer', 'AddBan', 'RehashAdmins',
    'EditGroup', 'RemoveProtest', 'SendRcon', 'EditAdminPerms',
    'AddComment', 'EditComment', 'RemoveComment', 'PrepareReban',
    'Maintenance', 'KickPlayer', 'GroupBan', 'BanMemberOfGroup',
    'GetGroups', 'BanFriends', 'SendMessage', 'ViewCommunityProfile',
    'SetupBan', 'CheckPassword', 'ChangePassword', 'CheckSrvPassword',
    'ChangeSrvPassword', 'ChangeEmail', 'SendMail', 'AddBlock',
    'PrepareReblock', 'PrepareBlockFromBan', 'removeExpiredAdmins',
    'AddSupport', 'ChangeAdminsInfos', 'InstallMOD', 'UpdateGroupPermissions',
    'PastePlayerData', 'AddWarning', 'RemoveWarning'
  ),
  'default' => array(
    'Plogin', 'ServerHostPlayers', 'ServerHostProperty',
    'ServerHostPlayers_list', 'ServerPlayers', 'LostPassword',
    'RefreshServer', 'AddAdmin_pay', 'RehashAdmins_pay',
    'CSRF', 'GetVACBan'
  )
);

if(\UserManager::getMyID() != -1)
    foreach ($methods['admin'] as $method)
        $xajax->registerFunction($method);

foreach ($methods['default'] as $method)
    $xajax->registerFunction($method);

global $userbank;
$username = $userbank->GetProperty("user");

function GetVACBan($bid) {
  $xajax = new xajaxResponse();
  $DB = \DatabaseManager::GetConnection();

  $DB->Prepare('SELECT `authid` FROM `{{prefix}}bans` WHERE `bid` = :bid');
  $DB->BindData('bid', $bid);
  $Result = $DB->Finish();

  $Ban = $Result->Single();
  $Result->EndData();

  if ($Ban) {
    $Ban = $Ban['authid'];

    if (GetVACStatus($Ban)) {
      $xajax->assign("vacban_{$bid}", 'innerHTML', 'Banned');
      $xajax->assign("vacban_{$bid}", 'style', 'color: #F00;');
    } else {
      $xajax->assign("vacban_{$bid}", 'innerHTML', 'No ban');
      $xajax->assign("vacban_{$bid}", 'style', '');
    }
  }
  return $xajax;
}

function CSRF() {
  return new xajaxResponse();
}

function InstallMOD($modfolder, $status = 0) {
    global $userbank;
    
    $objResponse = new xajaxResponse();
    $objResponse->addAlert("Disabled. Under construction");
    return $objResponse;
    
    /* TODO: Добавить загрузку данных из репозитория */
    $mapformat = str_replace('{%folder%}', $GameData['folder'], $RepoData['mapformat']);
    $PathIcon = sprintf('%s/%s', SB_ICON_LOCATION, $GameData['icon']);
    $PathMaps = sprintf('%s/%s', SB_MAP_LOCATION, $mapformat);
    
    if ($status == 0) {
        /* Build install dialog */
        $objResponse->addAssign("install_log", "innerHTML", "[".SBDate($GLOBALS['config']['config.dateformat'], time())."] Downloading files from the mirror...");
        $objResponse->addAssign("install_current", "innerHTML", "Downloading files from the mirror");
        $objResponse->addScript('xajax_InstallMOD("'.$modfolder.'", 1);');
    } else if ($status == 1) {
        /* Download files */
        file_put_contents($PathIcon, sprintf('%s%s%s', $RepoData['mirror'], $RepoData['icons_dir'], $GameData['icon']));
        file_put_contents($PathMaps, sprintf('%s%s%s', $RepoData['mirror'], $RepoData['maps_dir'], $mapformat));
        
        $objResponse->addAppend("install_log", "innerHTML", "<br />[".SBDate($GLOBALS['config']['config.dateformat'], time())."] Unpacking the archive");
        $objResponse->addAssign("install_current", "innerHTML", "Unpacking the archive");
        
        $objResponse->addScript('xajax_InstallMOD("'.$modfolder.'", 2);');
    } else if ($status == 2) {
        /* Decompress maps dir */
        decompress_tar($PathMaps, SB_MAP_LOCATION.'/'.$GameData['folder'].'/');
        
        $objResponse->addAppend("install_log", "innerHTML", "<br />[".SBDate($GLOBALS['config']['config.dateformat'], time())."] Removing temporary files");
        $objResponse->addAssign("install_current", "innerHTML", "Removing temporary files");
        
        $objResponse->addScript('xajax_InstallMOD("'.$modfolder.'", 3);');
    } else if ($status == 3) {
        /* Insert to DB */
        $GLOBALS['db']->Execute(sprintf("INSERT INTO `%s_mods` (`name`, `icon`, `modfolder`, `steam_universe`, `enabled`) VALUES (%s, %s, %s, %d, 1);", DB_PREFIX, $GLOBALS['db']->qstr($GameData['name']), $GLOBALS['db']->qstr($GameData['icon']), $GLOBALS['db']->qstr($GameData['folder']), (int) $GameData['steamcode']));
    
        $objResponse->addAppend("install_log", "innerHTML", "<br />[".SBDate($GLOBALS['config']['config.dateformat'], time())."] Done.");
        $objResponse->addAssign("install_current", "innerHTML", "Install finished.");
    }
    
    return $objResponse;
}

function AddSupport($aid)
{
  $objResponse = new xajaxResponse();
    global $userbank, $username;
  $aid = (int)$aid;
    if(!$userbank->is_logged_in())
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried add admin ".$userbank->GetProperty('user', $aid)." to Support-List, with no permission.");
    return $objResponse;
  }elseif(!$userbank->HasAccess(ADMIN_OWNER)){
    $objResponse->addScript('ShowBox("Error!", "You do not have permission for this!", "red", "index.php");');
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried add admin to Support-List, with no permission.");
    return $objResponse;
  }
  

  $res = $GLOBALS['db']->GetOne("SELECT `support` FROM `".DB_PREFIX."_admins` WHERE `aid` = '".$aid."'");
  if($res == "1"){
    $chek = "0";
    $chek1 = "removed";
  }else{
    $chek = "1";
    $chek1 = "added";
  }  
  $query = $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_admins` SET `support` = ? WHERE `aid` = '".$aid."'", array((int)$chek));
  if($query)
    $objResponse->addScript('ShowBox("Support-List", "Admin has been '.$chek1.', refresh page, to see result or continue your work.", "blue", "", true);');
  
  return $objResponse;
}
function removeExpiredAdmins()
{
  global $userbank, $username;
  $objResponse = new xajaxResponse();

  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_DELETE_ADMINS))
  {
    $objResponse->addScript('ShowBox("Error!", "You do not have permission for this!.", "red", "index.php?p=admin&c=admins");');
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried remove expired admins, with no permission.");
    return $objResponse;
  }
  if($GLOBALS['db']->Execute("DELETE FROM `".DB_PREFIX."_admins` WHERE `expired` < ".time()." AND `expired` <> 0")) {
    $objResponse->addScript('ShowBox("Success!", "All expired admins has been removed.", "green", "index.php?p=admin&c=admins");');
    $log = new CSystemLog("m", "Admin remove", $username . " removed all expired admins.");
  }
  else {
    $objResponse->addScript('ShowBox("Error!", "Error removing expired admins. <br /> Check system log for more info.", "red", "index.php?p=admin&c=admins");');
    $log = new CSystemLog("w", "Admin remove", "Error removing expired admins.");
  }
  
  return $objResponse;
}

function Plogin($username, $password, $remember, $redirect, $nopass) {
  $objResponse = new xajaxResponse();

  $errReason = '';
  if (\UserManager::login($username, $password, $errReason)) {
    if (empty($redirect))
      $redirect = 'p=account';
    $objResponse->addRedirect('?' . $redirect, 0);
  } else 
    $objResponse->addScript("ShowBox('Error authorization', '$errReason', 'red', '', true);");

  return $objResponse;
}

function LostPassword($email)
{
  $objResponse = new xajaxResponse();
  $q = $GLOBALS['db']->GetRow("SELECT * FROM `" . DB_PREFIX . "_admins` WHERE `email` = ?", array($email));

  if(!$q[0])
  {
    $objResponse->addScript("ShowBox('Error', 'Entered E-mail adress not found in system', 'red', '', true);");
      return $objResponse;
  }
  else {
    $objResponse->addScript("$('msg-red').setStyle('display', 'none');");
  }

  $validation = md5(generate_salt(20).generate_salt(20)).md5(generate_salt(20).generate_salt(20));
  $query = $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_admins` SET `validate` = ? WHERE `email` = ?", array($validation, $email));
  $message = "";
  $message .= "Hello " . $q['user'] . "\n";
  $message .= "You requested password reset on PG Bans.\n";
  $message .= "To complete the procedure for changing your password, follow the link below.\n";
  $message .= "NOTE: if you did not ask to change your password, just ignore this message.\n\n";

  $message .= "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?p=lostpassword&email=". RemoveCode($email) . "&validation=" . $validation;

  $headers = 'From: Sourcebans@' . $_SERVER['HTTP_HOST'] . "\n" .
    'X-Mailer: PHP/' . phpversion();
  $m = EMail($email, "SourceBans password reset", $message, $headers);

  if ($m) $objResponse->addScript("ShowBox('Check inbox', 'An email with a link to reset your password has been sent to your email inbox.', 'blue', '', true);");
  else $objResponse->addScript("ShowBox('Error', 'Failed to send a letter to your email account. Write to the main administrator.', 'red', '', true);");
  return $objResponse;
}

function CheckSrvPassword($aid, $srv_pass)
{
  $objResponse = new xajaxResponse();
    global $userbank, $username;
  $aid = (int)$aid;
    if(!$userbank->is_logged_in() || $aid != $userbank->GetAid())
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " trying to check the server password ".$userbank->GetProperty('user', $aid).", with no permission.");
    return $objResponse;
  }
  $res = $GLOBALS['db']->Execute("SELECT `srv_password` FROM `".DB_PREFIX."_admins` WHERE `aid` = '".$aid."'");
  if($res->fields['srv_password'] != NULL && $res->fields['srv_password'] != $srv_pass)
  {
    $objResponse->addScript("$('scurrent.msg').setStyle('display', 'block');");
    $objResponse->addScript("$('scurrent.msg').setHTML('Wrong password.');");
    $objResponse->addScript("set_error(1);");

  }
  else
  {
    $objResponse->addScript("$('scurrent.msg').setStyle('display', 'none');");
    $objResponse->addScript("set_error(0);");
  }
  return $objResponse;
}

function ChangeSrvPassword($aid, $srv_pass)
{
  $objResponse = new xajaxResponse();
    global $userbank, $username;
    $aid = (int)$aid;
    if(!$userbank->is_logged_in() || $aid != $userbank->GetAid())
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " trying to change the server passwordа ".$userbank->GetProperty('user', $aid).", with no permission.");
    return $objResponse;
  }
    
  if($srv_pass == "NULL")
    $GLOBALS['db']->Execute("UPDATE `".DB_PREFIX."_admins` SET `srv_password` = NULL WHERE `aid` = '".$aid."'");
  else
    $GLOBALS['db']->Execute("UPDATE `".DB_PREFIX."_admins` SET `srv_password` = ? WHERE `aid` = ?", array($srv_pass, $aid));
  $objResponse->addScript("ShowBox('Server password changed', 'Server password successfully changed.', 'green', 'index.php?p=account', true);");
  $log = new CSystemLog("m", "Server password changed", "Changed by (".$aid.")");
  return $objResponse;
}

function ChangeEmail($aid, $email, $password)
{
    global $userbank, $username;
  $objResponse = new xajaxResponse();
  $aid = (int)$aid;
    
    if(!$userbank->is_logged_in() || $aid != $userbank->GetAid())
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried change e-mail ".$userbank->GetProperty('user', $aid).", with no permission.");
    return $objResponse;
  }
    
    if($userbank->encrypt_password($password) != $userbank->getProperty('password'))
    {
        $objResponse->addScript("$('emailpw.msg').setStyle('display', 'block');");
    $objResponse->addScript("$('emailpw.msg').setHTML('Wrong password.');");
    $objResponse->addScript("set_error(1);");
    return $objResponse;
  } else {
    $objResponse->addScript("$('emailpw.msg').setStyle('display', 'none');");
    $objResponse->addScript("set_error(0);");
  }
    
  if(!check_email($email)) {
    $objResponse->addScript("$('email1.msg').setStyle('display', 'block');");
    $objResponse->addScript("$('email1.msg').setHTML('Enter valid e-mail.');");
    $objResponse->addScript("set_error(1);");
    return $objResponse;
  } else {
    $objResponse->addScript("$('email1.msg').setStyle('display', 'none');");
    $objResponse->addScript("set_error(0);");
  }

  $GLOBALS['db']->Execute("UPDATE `".DB_PREFIX."_admins` SET `email` = ? WHERE `aid` = ?", array($email, $aid));
  $objResponse->addScript("ShowBox('E-mail changed', 'Your e-mail successfully changed.', 'green', 'index.php?p=account', true);");
  $log = new CSystemLog("m", "E-mail changed", "E-mail changed by admin (".$aid.")");
  return $objResponse;
}

function AddGroup($name, $type, $bitmask, $srvflags)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_ADD_GROUP))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried add group, with no permission.");
    return $objResponse;
  }

  $error = 0;
  $query = $GLOBALS['db']->GetRow("SELECT `gid` FROM `" . DB_PREFIX . "_groups` WHERE `name` = ?", array($name));
  $query2 = $GLOBALS['db']->GetRow("SELECT `id` FROM `" . DB_PREFIX . "_srvgroups` WHERE `name` = ?", array($name));
  if(strlen($name) == 0 || count($query) > 0 || count($query2) > 0)
  {
    if(strlen($name) == 0)
    {
      $objResponse->addScript("$('name.msg').setStyle('display', 'block');");
      $objResponse->addScript("$('name.msg').setHTML('Enter name for group.');");
      $error++;
    }
    else if(strstr($name, ','))  {
      $objResponse->addScript("$('name.msg').setStyle('display', 'block');");
      $objResponse->addScript("$('name.msg').setHTML('The group name cannot contain a comma.');");
      $error++;
    }
    else if(count($query) > 0 || count($query2) > 0){
      $objResponse->addScript("$('name.msg').setStyle('display', 'block');");
      $objResponse->addScript("$('name.msg').setHTML('Group name already in use \'" . $name . "\'');");
      $error++;
    }
    else {
      $objResponse->addScript("$('name.msg').setStyle('display', 'none');");
      $objResponse->addScript("$('name.msg').setHTML('');");
    }
  }
  if($type == "0")
  {
    $objResponse->addScript("$('type.msg').setStyle('display', 'block');");
    $objResponse->addScript("$('type.msg').setHTML('Choose group type.');");
    $error++;
  }
  else {
    $objResponse->addScript("$('type.msg').setStyle('display', 'none');");
    $objResponse->addScript("$('type.msg').setHTML('');");
  }
  if($error > 0)
    return $objResponse;

  $query = $GLOBALS['db']->GetRow("SELECT MAX(gid) AS next_gid FROM `" . DB_PREFIX . "_groups`");
  if($type == "1")
  {
    // add the web group
    $query1 = $GLOBALS['db']->Execute("INSERT INTO `" . DB_PREFIX . "_groups` (`gid`, `type`, `name`, `flags`) VALUES (". (int)($query['next_gid']+1) .", '" . (int)$type . "', ?, '" . (int)$bitmask . "')", array($name));
  }
  elseif($type == "2")
  {
    if(strstr($srvflags, "#"))
    {
      $immunity = "0";
      $immunity = substr($srvflags, strpos($srvflags, "#")+1);
      $srvflags = substr($srvflags, 0, strlen($srvflags) - strlen($immunity)-1);
    }
    $immunity = (isset($immunity) && $immunity>0) ? $immunity : 0;
    $add_group = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_srvgroups(immunity,flags,name,groups_immune)
          VALUES (?,?,?,?)");
    $GLOBALS['db']->Execute($add_group,array($immunity, $srvflags, $name, " "));
  }
  elseif($type == "3")
  {
    // We need to add the server into the table
    $query1 = $GLOBALS['db']->Execute("INSERT INTO `" . DB_PREFIX . "_groups` (`gid`, `type`, `name`, `flags`) VALUES (". ($query['next_gid']+1) .", '3', ?, '0')", array($name));
  }

  $log = new CSystemLog("m", "Group created", "New group ($name) successfully created");
    $objResponse->addScript("ShowBox('Group created', 'Group successfully created.', 'green', 'index.php?p=admin&c=groups', true);");
    $objResponse->addScript("TabToReload();");
  return $objResponse;
}

function RemoveGroup($gid, $type)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_DELETE_GROUPS))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried remove group, with no permission.");
    return $objResponse;
  }

  $gid = (int)$gid;


  if($type == "web") {
    $query2 = $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_admins` SET gid = -1 WHERE gid = $gid");
    $query1 = $GLOBALS['db']->Execute("DELETE FROM `" . DB_PREFIX . "_groups` WHERE gid = $gid");
  }
  else if($type == "server") {
    $query2 = $GLOBALS['db']->Execute("DELETE FROM `" . DB_PREFIX . "_servers_groups` WHERE group_id = $gid");
    $query1 = $GLOBALS['db']->Execute("DELETE FROM `" . DB_PREFIX . "_groups` WHERE gid = $gid");
  }
  else {
    $query2 = $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_admins` SET srv_group = NULL WHERE srv_group = (SELECT name FROM `" . DB_PREFIX . "_srvgroups` WHERE id = $gid)");
    $query1 = $GLOBALS['db']->Execute("DELETE FROM `" . DB_PREFIX . "_srvgroups` WHERE id = $gid");
    $query0 = $GLOBALS['db']->Execute("DELETE FROM `" . DB_PREFIX . "_srvgroups_overrides` WHERE group_id = $gid");
  }
  
  if(isset($GLOBALS['config']['config.enableadminrehashing']) && $GLOBALS['config']['config.enableadminrehashing'] == 1)
  {
    // rehash the settings out of the database on all servers
    $serveraccessq = $GLOBALS['db']->GetAll("SELECT sid FROM ".DB_PREFIX."_servers WHERE enabled = 1;");
    $allservers = array();
    foreach($serveraccessq as $access) {
      if(!in_array($access['sid'], $allservers)) {
        $allservers[] = $access['sid'];
      }
    }
    $rehashing = true;
  }

  $objResponse->addScript("SlideUp('gid_$gid');");
  if($query1)
  {
    if(isset($rehashing))
      $objResponse->addScript("ShowRehashBox('".implode(",", $allservers)."', 'Group deleted', 'Group successfully removed from database', 'green', 'index.php?p=admin&c=groups', true);");
    else
      $objResponse->addScript("ShowBox('Group deleted', 'Group successfully deleted from database', 'green', 'index.php?p=admin&c=groups', true);");
    $log = new CSystemLog("m", "Group deleted", "Group (" . $gid . ") has been deleted");
  }
  else
    $objResponse->addScript("ShowBox('Error', 'Failed to delete the group from the database. See syslog for more information', 'red', 'index.php?p=admin&c=groups', true);");

  return $objResponse;
}

function RemoveSubmission($sid, $archiv)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_BAN_SUBMISSIONS))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to remove the ban submission, with no permission.");
    return $objResponse;
  }
  $sid = (int)$sid;
  if($archiv == "1") { // move submission to archiv
    $query1 = $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_submissions` SET archiv = '1', archivedby = '".$userbank->GetAid()."' WHERE subid = $sid");
    $query = $GLOBALS['db']->GetRow("SELECT count(subid) AS cnt FROM `" . DB_PREFIX . "_submissions` WHERE archiv = '0'");
    $objResponse->addScript("$('subcount').setHTML('" . $query['cnt'] . "');");

    $objResponse->addScript("SlideUp('sid_$sid');");
    $objResponse->addScript("SlideUp('sid_" . $sid . "a');");

    if($query1)
    {
      $objResponse->addScript("ShowBox('The application has been sent to the archive', 'The selected ticket has been moved to the archive!', 'green', 'index.php?p=admin&c=bans', true);");
      $log = new CSystemLog("m", "Request sent to archieve", "Request (" . $sid . ") has been sent to archieve");
    }
    else
      $objResponse->addScript("ShowBox('Error', 'Failed to move the application. See syslog for more information', 'red', 'index.php?p=admin&c=bans', true);");
  } else if($archiv == "0") { // delete submission
    $query1 = $GLOBALS['db']->Execute("DELETE FROM `" . DB_PREFIX . "_submissions` WHERE subid = $sid");
    $query2 = $GLOBALS['db']->Execute("DELETE FROM `" . DB_PREFIX . "_demos` WHERE demid = '".$sid."' AND demtype = 'S'");
    $query = $GLOBALS['db']->GetRow("SELECT count(subid) AS cnt FROM `" . DB_PREFIX . "_submissions` WHERE archiv = '1'");
    $objResponse->addScript("$('subcountarchiv').setHTML('" . $query['cnt'] . "');");

    $objResponse->addScript("SlideUp('asid_$sid');");
    $objResponse->addScript("SlideUp('asid_" . $sid . "a');");

    if($query1)
    {
      $objResponse->addScript("ShowBox('Request removed', 'Request successfully removed from database', 'green', 'index.php?p=admin&c=bans', true);");
      $log = new CSystemLog("m", "Request removed", "Request (" . $sid . ") has been removed");
    }
    else
      $objResponse->addScript("ShowBox('Error', 'Failed to delete the application. See syslog for more information', 'red', 'index.php?p=admin&c=bans', true);");
  } else if($archiv == "2") { // restore the submission
    $query1 = $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_submissions` SET archiv = '0', archivedby = NULL WHERE subid = $sid");
    $query = $GLOBALS['db']->GetRow("SELECT count(subid) AS cnt FROM `" . DB_PREFIX . "_submissions` WHERE archiv = '0'");
    $objResponse->addScript("$('subcountarchiv').setHTML('" . $query['cnt'] . "');");

    $objResponse->addScript("SlideUp('asid_$sid');");
    $objResponse->addScript("SlideUp('asid_" . $sid . "a');");

    if($query1)
    {
      $objResponse->addScript("ShowBox('Request restored', 'The selected application has been restored from the archive!', 'green', 'index.php?p=admin&c=bans', true);");
      $log = new CSystemLog("m", "Request restored", "Request (" . $sid . ") has been restored from archieve");
    }
    else
      $objResponse->addScript("ShowBox('Error', 'It was not possible to restore the application. See syslog for more information', 'red', 'index.php?p=admin&c=bans', true);");
  }
  return $objResponse;
}

function RemoveProtest($pid, $archiv)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_BAN_PROTESTS))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried remove protest, with no permission.");
    return $objResponse;
  }
  $pid = (int)$pid;
  if($archiv == '0') { // delete protest
    $query1 = $GLOBALS['db']->Execute("DELETE FROM `" . DB_PREFIX . "_protests` WHERE pid = $pid");
    $query2 = $GLOBALS['db']->Execute("DELETE FROM `" . DB_PREFIX . "_comments` WHERE type = 'P' AND bid = $pid;");
    $query = $GLOBALS['db']->GetRow("SELECT count(pid) AS cnt FROM `" . DB_PREFIX . "_protests` WHERE archiv = '1'");
    $objResponse->addScript("$('protcountarchiv').setHTML('" . $query['cnt'] . "');");
    $objResponse->addScript("SlideUp('apid_$pid');");
    $objResponse->addScript("SlideUp('apid_" . $pid . "a');");

    if($query1)
    {
      $objResponse->addScript("ShowBox('Protest removed', 'The protest successfully removed from database', 'green', 'index.php?p=admin&c=bans', true);");
      $log = new CSystemLog("m", "Protest removed", "Protest (" . $pid . ") has been removed");
    }
    else
      $objResponse->addScript("ShowBox('Error', 'Failed to delete protest See syslog for more information', 'red', 'index.php?p=admin&c=bans', true);");
  } else if($archiv == '1') { // move protest to archiv
    $query1 = $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_protests` SET archiv = '1', archivedby = '".$userbank->GetAid()."' WHERE pid = $pid");
    $query = $GLOBALS['db']->GetRow("SELECT count(pid) AS cnt FROM `" . DB_PREFIX . "_protests` WHERE archiv = '0'");
    $objResponse->addScript("$('protcount').setHTML('" . $query['cnt'] . "');");
    $objResponse->addScript("SlideUp('pid_$pid');");
    $objResponse->addScript("SlideUp('pid_" . $pid . "a');");

    if($query1)
    {
      $objResponse->addScript("ShowBox('Protest sent to archieve', 'The protest sent to archieve.', 'green', 'index.php?p=admin&c=bans', true);");
      $log = new CSystemLog("m", "Protest in archieve", "Protest (" . $pid . ") has sent to archieve.");
    }
    else
      $objResponse->addScript("ShowBox('Error', 'It was not possible to send a protest to the archive. See syslog for more information', 'red', 'index.php?p=admin&c=bans', true);");
  } else if($archiv == '2') { // restore protest
    $query1 = $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_protests` SET archiv = '0', archivedby = NULL WHERE pid = $pid");
    $query = $GLOBALS['db']->GetRow("SELECT count(pid) AS cnt FROM `" . DB_PREFIX . "_protests` WHERE archiv = '1'");
    $objResponse->addScript("$('protcountarchiv').setHTML('" . $query['cnt'] . "');");
    $objResponse->addScript("SlideUp('apid_$pid');");
    $objResponse->addScript("SlideUp('apid_" . $pid . "a');");

    if($query1)
    {
      $objResponse->addScript("ShowBox('Protest restored', 'The selected protest was successfully restored from the archive.', 'green', 'index.php?p=admin&c=bans', true);");
      $log = new CSystemLog("m", "Protest restored", "Protest (" . $pid . ") has been restored from archieve.");
    }
    else
      $objResponse->addScript("ShowBox('Error', 'It was not possible to restore the protest from the archive. See syslog for more information', 'red', 'index.php?p=admin&c=bans', true);");
  }
  return $objResponse;
}

function RemoveServer($sid)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_DELETE_SERVERS))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried remove server, with no permission.");
    return $objResponse;
  }
  $sid = (int)$sid;
  $objResponse->addScript("SlideUp('sid_$sid');");
  $servinfo = $GLOBALS['db']->GetRow("SELECT ip, port FROM `" . DB_PREFIX . "_servers` WHERE sid = $sid");
  $query1 = $GLOBALS['db']->Execute("DELETE FROM `" . DB_PREFIX . "_servers` WHERE sid = $sid");
  $query2 = $GLOBALS['db']->Execute("DELETE FROM `" . DB_PREFIX . "_servers_groups` WHERE server_id = $sid");
    $query3 = $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_admins_servers_groups` SET server_id = -1 WHERE server_id = $sid");

  $query = $GLOBALS['db']->GetRow("SELECT count(sid) AS cnt FROM `" . DB_PREFIX . "_servers`");
  $objResponse->addScript("$('srvcount').setHTML('" . $query['cnt'] . "');");


  if($query1)
  {
    $objResponse->addScript("ShowBox('Server deleted', 'The server deleted from database', 'green', 'index.php?p=admin&c=servers', true);");
    $log = new CSystemLog("m", "Server deleted", "Server ((" . $servinfo['ip'] . ":" . $servinfo['port'] . ") has been removed");
  }
  else
    $objResponse->addScript("ShowBox('Error', 'Failed to delete the server. See syslog for more information', 'red', 'index.php?p=admin&c=servers', true);");
  return $objResponse;
}

function RemoveMod($mid)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_DELETE_MODS))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to remove mod, with no permission.");
    return $objResponse;
  }
  $mid = (int)$mid;
  $objResponse->addScript("SlideUp('mid_$mid');");

  $modicon = $GLOBALS['db']->GetRow("SELECT icon, name FROM `" . DB_PREFIX . "_mods` WHERE mid = '" . $mid . "';");
  @unlink(SB_ICONS."/".$modicon['icon']);

  $query1 = $GLOBALS['db']->Execute("DELETE FROM `" . DB_PREFIX . "_mods` WHERE mid = '" . $mid . "'");

  if($query1)
  {
    $objResponse->addScript("ShowBox('MOD removed', 'The MOD deleted from database', 'green', 'index.php?p=admin&c=mods', true);");
    $log = new CSystemLog("m", "MOD deleted", "MOD (" . $modicon['name'] . ") has been removed");
  }
  else
    $objResponse->addScript("ShowBox('Error', 'Failed to delete the MOD. See syslog for more information', 'red', 'index.php?p=admin&c=mods', true);");
  return $objResponse;
}

function RemoveAdmin($aid)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_DELETE_ADMINS))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to remove admin, with no permission.");
    return $objResponse;
  }
  $aid = (int)$aid;
  $gid = $GLOBALS['db']->GetRow("SELECT gid, authid, extraflags, user FROM `" . DB_PREFIX . "_admins` WHERE aid = $aid");
  if((intval($gid[2]) & ADMIN_OWNER) != 0)
  {
    $objResponse->addAlert("Error: LMAO, You can not remove owner. Nice try.");
    return $objResponse;
  }

  $delquery = $GLOBALS['db']->Execute(sprintf("DELETE FROM `%s_admins` WHERE aid = %d LIMIT 1", DB_PREFIX, $aid));
  if($delquery) {
    if(isset($GLOBALS['config']['config.enableadminrehashing']) && $GLOBALS['config']['config.enableadminrehashing'] == 1)
    {
      // rehash the admins for the servers where this admin was on
      $serveraccessq = $GLOBALS['db']->GetAll("SELECT s.sid FROM `".DB_PREFIX."_servers` s
                        LEFT JOIN `".DB_PREFIX."_admins_servers_groups` asg ON asg.admin_id = '".(int)$aid."'
                        LEFT JOIN `".DB_PREFIX."_servers_groups` sg ON sg.group_id = asg.srv_group_id
                        WHERE ((asg.server_id != '-1' AND asg.srv_group_id = '-1')
                        OR (asg.srv_group_id != '-1' AND asg.server_id = '-1'))
                        AND (s.sid IN(asg.server_id) OR s.sid IN(sg.server_id)) AND s.enabled = 1");
      $allservers = array();
      foreach($serveraccessq as $access) {
        if(!in_array($access['sid'], $allservers)) {
          $allservers[] = $access['sid'];
        }
      }
      $rehashing = true;
    }

    $GLOBALS['db']->Execute(sprintf("DELETE FROM `%s_admins_servers_groups` WHERE admin_id = %d", DB_PREFIX, $aid));
   }

  $query = $GLOBALS['db']->GetRow("SELECT count(aid) AS cnt FROM `" . DB_PREFIX . "_admins`");
  $objResponse->addScript("SlideUp('aid_$aid');");
  $objResponse->addScript("$('admincount').setHTML('" . $query['cnt'] . "');");
  if($delquery)
  {
    if(isset($rehashing))
      $objResponse->addScript("ShowRehashBox('".implode(",", $allservers)."', 'Admin removed', 'The selected admin has been removed', 'green', 'index.php?p=admin&c=admins', true);");
    else
      $objResponse->addScript("ShowBox('Admin removed', 'The selected admin removed from database', 'green', 'index.php?p=admin&c=admins', true);");
    $log = new CSystemLog("m", "Admin removed", "Admin (" . $gid['user'] . ") has been removed");
  }
  else
    $objResponse->addScript("ShowBox('Error', 'Unable to remove admin. See syslog for more information', 'red', 'index.php?p=admin&c=admins', true);");
  return $objResponse;
}

function AddServer($ip, $port, $rcon, $rcon2, $mod, $enabled, $group, $group_name, $priority)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_ADD_SERVER))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to add server, with no permission.");
    return $objResponse;
  }
  $ip = RemoveCode($ip);
  $group_name = RemoveCode($group_name);

  $error = 0;
  // ip
  if((empty($ip)))
  {
    $error++;
    $objResponse->addAssign("address.msg", "innerHTML", "Enter server IP.");
    $objResponse->addScript("$('address.msg').setStyle('display', 'block');");
  }
  else
  {
    $objResponse->addAssign("address.msg", "innerHTML", "");
    if(!validate_ip($ip) && !is_string($ip))
    {
      $error++;
      $objResponse->addAssign("address.msg", "innerHTML", "Enter valid IP adress.");
      $objResponse->addScript("$('address.msg').setStyle('display', 'block');");
    }
    else
      $objResponse->addAssign("address.msg", "innerHTML", "");
  }
  // Port
  if((empty($port)))
  {
    $error++;
    $objResponse->addAssign("port.msg", "innerHTML", "Enter server port.");
    $objResponse->addScript("$('port.msg').setStyle('display', 'block');");
  }
  else
  {
    $objResponse->addAssign("port.msg", "innerHTML", "");
    if(!is_numeric($port))
    {
      $error++;
      $objResponse->addAssign("port.msg", "innerHTML", "Enter valid port <b>in numbers</b>.");
      $objResponse->addScript("$('port.msg').setStyle('display', 'block');");
    }
    else
    {
      $objResponse->addScript("$('port.msg').setStyle('display', 'none');");
      $objResponse->addAssign("port.msg", "innerHTML", "");
    }
  }
  // rcon
  if(!empty($rcon) && $rcon != $rcon2)
  {
    $error++;
    $objResponse->addAssign("rcon2.msg", "innerHTML", "Passwords do not match.");
    $objResponse->addScript("$('rcon2.msg').setStyle('display', 'block');");
  }
  else
    $objResponse->addAssign("rcon2.msg", "innerHTML", "");

  // Please Select
  if($mod == -2)
  {
    $error++;
    $objResponse->addAssign("mod.msg", "innerHTML", "Choose server MOD.");
    $objResponse->addScript("$('mod.msg').setStyle('display', 'block');");
  }
  else
    $objResponse->addAssign("mod.msg", "innerHTML", "");

  if($group == -2)
  {
    $error++;
    $objResponse->addAssign("group.msg", "innerHTML", "You need to choose option.");
    $objResponse->addScript("$('group.msg').setStyle('display', 'block');");
  }
  else
    $objResponse->addAssign("group.msg", "innerHTML", "");

  if($error)
    return $objResponse;
  
  // Check for dublicates afterwards
  $chk = $GLOBALS['db']->GetRow('SELECT sid FROM `'.DB_PREFIX.'_servers` WHERE ip = ? AND port = ?;', array($ip, (int)$port));
  if($chk)
  {
    $objResponse->addScript("ShowBox('Error', 'The server already exists.', 'red');");
    return $objResponse;
  }

  // ##############################################################
  // ##                     Start adding to DB                   ##
  // ##############################################################
  //they wanna make a new group
  $gid = -1;
  $sid = nextSid();
  
  $enable = ($enabled=="true"?1:0);

  // Add the server
  $addserver = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_servers (`sid`, `ip`, `port`, `rcon`, `modid`, `enabled`, `priority`)
                      VALUES (?,?,?,?,?,?,?)");
  $GLOBALS['db']->Execute($addserver,array($sid, $ip, (int)$port, $rcon, $mod, $enable, intval($priority)));

  // Add server to each group specified
  $groups = explode(",", $group);
  $addtogrp = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_servers_groups (`server_id`, `group_id`) VALUES (?,?)");
  foreach($groups AS $g)
  {
    if($g)
      $GLOBALS['db']->Execute($addtogrp,array($sid, $g));
  }


  $objResponse->addScript("ShowBox('Server added', 'Your server successfully created.', 'green', 'index.php?p=admin&c=servers');");
    $objResponse->addScript("TabToReload();");
    $log = new CSystemLog("m", "Server added", "Server (" . $ip . ":" . $port . ") added");
  return $objResponse;
}


function UpdateGroupPermissions($gid)
{
  $objResponse = new xajaxResponse();
  global $userbank;
  $gid = (int)$gid;
  if($gid == 1)
  {
    $permissions = @file_get_contents(TEMPLATES_PATH . "/groups.web.perm.php");
    $permissions = str_replace("{title}", "Web access permissions", $permissions);
  }
  elseif($gid == 2)
  {
    $permissions = @file_get_contents(TEMPLATES_PATH . "/groups.server.perm.php");
    $permissions = str_replace("{title}", "Server access permissions", $permissions);
  }
  elseif($gid == 3)
    $permissions = "";

  $objResponse->addAssign("perms", "innerHTML", $permissions);
  if(!$userbank->HasAccess(ADMIN_OWNER))
    $objResponse->addScript('if($("wrootcheckbox")) { 
                  $("wrootcheckbox").setStyle("display", "none");
                }
                if($("srootcheckbox")) { 
                  $("srootcheckbox").setStyle("display", "none");
                }');
  $objResponse->addScript("$('type.msg').setHTML('');");
  $objResponse->addScript("$('type.msg').setStyle('display', 'none');");
  return $objResponse;
}

function UpdateAdminPermissions($type, $value)
{
  $objResponse = new xajaxResponse();
  global $userbank;
  $type = (int)$type;
  if($type == 1)
  {
    $id = "web";
    if($value == "c")
    {
      $permissions = @file_get_contents(TEMPLATES_PATH . "/groups.web.perm.php");
      $permissions = str_replace("{title}", "Web access permissions", $permissions);
    }
    elseif($value == "n")
    {
      $permissions = @file_get_contents(TEMPLATES_PATH . "/group.name.php") . @file_get_contents(TEMPLATES_PATH . "/groups.web.perm.php");
      $permissions = str_replace("{name}", "webname", $permissions);
      $permissions = str_replace("{title}", "Add access group", $permissions);
    }
    else
      $permissions = "";
  }
  if($type == 2)
  {
    $id = "server";
    if($value == "c")
    {
      $permissions = file_get_contents(TEMPLATES_PATH . "/groups.server.perm.php");
      $permissions = str_replace("{title}", "Server access permissions", $permissions);
    }
    elseif($value == "n")
    {
      $permissions = @file_get_contents(TEMPLATES_PATH . "/group.name.php") . @file_get_contents(TEMPLATES_PATH . "/groups.server.perm.php");
      $permissions = str_replace("{name}", "servername", $permissions);
      $permissions = str_replace("{title}", "Add access group", $permissions);
    }
    else
      $permissions = "";
  }

  $objResponse->addAssign($id."perm", "innerHTML", $permissions);
  if(!$userbank->HasAccess(ADMIN_OWNER))
    $objResponse->addScript('if($("wrootcheckbox")) { 
                  $("wrootcheckbox").setStyle("display", "none");
                }
                if($("srootcheckbox")) { 
                  $("srootcheckbox").setStyle("display", "none");
                }');
  $objResponse->addAssign($id.".msg", "innerHTML", "");
  return $objResponse;

}

function AddServerGroupName()
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_EDIT_GROUPS))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried rename server group, with no permission.");
    return $objResponse;
  }
  $inject = '<td valign="top"><div class="rowdesc">' . HelpIcon("Server group name", "Enter new group name.") . 'Group name </div></td>';
  $inject .= '<td><div align="left">
        <input type="text" style="border: 1px solid #000000; width: 105px; font-size: 14px; background-color: rgb(215, 215, 215);width: 200px;" id="sgroup" name="sgroup" />
      </div>
        <div id="group_name.msg" style="color:#CC0000;width:195px;display:none;"></div></td>
  ';
  $objResponse->addAssign("nsgroup", "innerHTML", $inject);
  $objResponse->addAssign("group.msg", "innerHTML", "");
  return $objResponse;

}

function AddAdmin_pay($mask, $srv_mask, $a_name, $a_steam, $a_email, $a_password, $a_password2,  $a_sg, $a_wg, $a_serverpass, $a_webname, $a_servername, $server, $singlesrv, $skype, $comment, $vk, $a_code)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  
  $mask = "";
  $srv_mask = "";
  $a_sg = "";
  $a_wg = "";
  $a_serverpass = "-1";
  $a_webname = "0";
  $a_servername = "0";
  $server = "";
  $comment = "";
  
  $vk = RemoveCode($vk);
  $vk = str_replace(array("http://","https://","/","instagram.com"), "", $vk);
  $skype = RemoveCode($skype);
  $a_code = RemoveCode($a_code);
  $a_code = preg_replace("/[^0-9]/", '', $a_code);
  
  $srv_sql_val = $GLOBALS['db']->GetOne("SELECT `servers` FROM `" . DB_PREFIX . "_vay4er` WHERE `value` = '".$a_code."'");
  if($srv_sql_val == "-1"){
    $singlesrv = "";
  }elseif((stristr($srv_sql_val, ',') && stristr($srv_sql_val, 's')) == TRUE){
    $singlesrv = $srv_sql_val;
  }
  
  $qwe = $GLOBALS['db']->GetOne("SELECT `activ` FROM `" . DB_PREFIX . "_vay4er` WHERE `value` = '".$a_code."'");
  if($qwe == "0" || $qwe != "1"){
    $objResponse->addScript("ShowBox('Activation', 'Your Promokey has already been successfully activated! Reactivation is not possible. Redirecting...', 'red', 'index.php', false);");
    $log = new CSystemLog("w", "Promokey", $a_name . " tried activate used promokey.");
    return $objResponse;
    exit();
  }
  
  $pay_days_sql = $GLOBALS['db']->GetOne("SELECT `days` FROM `" . DB_PREFIX . "_vay4er` WHERE `value` = '".$a_code."'");
  if(!$pay_days_sql == "0"){
    $pay_days_sql = (time() + $pay_days_sql * 86400);
  }
  $a_name = RemoveCode($a_name);
  $a_steam = RemoveCode($a_steam);
  $a_email = RemoveCode($a_email);
  $a_servername = ($a_servername=="0" ? null : RemoveCode($a_servername));
  $a_webname = RemoveCode($a_webname);
  $mask = (int)$mask;

  $error=0;
  
    //No name
  if(empty($a_name))
  {
    $error++;
    $objResponse->addAssign("name.msg", "innerHTML", "Enter admin name.");
    $objResponse->addScript("$('name.msg').setStyle('display', 'block');");
  }
  else{
    if(strstr($a_name, "'"))
    {
      $error++;
      $objResponse->addAssign("name.msg", "innerHTML", "Admin name should not contain \" ' \".");
      $objResponse->addScript("$('name.msg').setStyle('display', 'block');");
    }
    else
    {
      if(is_taken("admins", "user", $a_name))
      {
          $error++;
          $objResponse->addAssign("name.msg", "innerHTML", "Admin with this name already exists");
          $objResponse->addScript("$('name.msg').setStyle('display', 'block');");
      }
      else
      {
          $objResponse->addAssign("name.msg", "innerHTML", "");
          $objResponse->addScript("$('name.msg').setStyle('display', 'none');");
      }
    }
  }
  // If they didnt type a steamid
  if((empty($a_steam) || strlen($a_steam) < 10))
  {
    $error++;
    $objResponse->addAssign("steam.msg", "innerHTML", "Enter your STEAM ID. You can find it on your game console, writing <b>status</b>.");
    $objResponse->addScript("$('steam.msg').setStyle('display', 'block');");
  }
  else
  {
    // Validate the steamid or fetch it from the community id
    if((!is_numeric($a_steam) 
    && !validate_steam($a_steam))
    || (is_numeric($a_steam) 
    && (strlen($a_steam) < 15
    || !validate_steam($a_steam = FriendIDToSteamID($a_steam)))))
    {
      $error++;
      $objResponse->addAssign("steam.msg", "innerHTML", "Enter valid STEAM ID.");
      $objResponse->addScript("$('steam.msg').setStyle('display', 'block');");
    }
    else
    {
      if(is_taken("admins", "authid", $a_steam))
      {
        $admins = $userbank->GetAllAdmins();
        foreach($admins as $admin)
        {
          if($admin['authid'] == $a_steam)
          {
            $name = $admin['user'];
            break;
          }
        }
        $error++;
        $objResponse->addAssign("steam.msg", "innerHTML", "This STEAM ID already in use!");
        $objResponse->addScript("$('steam.msg').setStyle('display', 'block');");
      }
      else
      {
        $objResponse->addAssign("steam.msg", "innerHTML", "");
        $objResponse->addScript("$('steam.msg').setStyle('display', 'none');");
      }
    }
  }
  
  // No email
  if(empty($a_email))
  {
    // An E-Mail address is only required for users with web permissions.
    $error++;
    $objResponse->addAssign("email.msg", "innerHTML", "Enter e-mail adress.");
    $objResponse->addScript("$('email.msg').setStyle('display', 'block');");
  }
  else{
    // Is an other admin already registred with that email address?
    if(is_taken("admins", "email", $a_email))
    {
      $admins = $userbank->GetAllAdmins();
      foreach($admins as $admin)
      {
        if($admin['email'] == $a_email)
        {
          $name = $admin['user'];
          break;
        }
      }
      $error++;
      $objResponse->addAssign("email.msg", "innerHTML", "This e-mail already in use!");
      $objResponse->addScript("$('email.msg').setStyle('display', 'block');");
    }
    else
    {
      $objResponse->addAssign("email.msg", "innerHTML", "");
      $objResponse->addScript("$('email.msg').setStyle('display', 'none');");
    }
  }
  
  // no pass
  if(empty($a_password))
  {
    // A password is only required for users with web permissions.
    $error++;
    $objResponse->addAssign("password.msg", "innerHTML", "Enter password.");
    $objResponse->addScript("$('password.msg').setStyle('display', 'block');");
  }
  // Password too short?
  else if(strlen($a_password) < MIN_PASS_LENGTH)
  {
    $error++;
    $objResponse->addAssign("password.msg", "innerHTML", "Password length must be at least " . MIN_PASS_LENGTH . " symbols.");
    $objResponse->addScript("$('password.msg').setStyle('display', 'block');");
  }
  else 
  {
    $objResponse->addAssign("password.msg", "innerHTML", "");
    $objResponse->addScript("$('password.msg').setStyle('display', 'none');");
    
    // No confirmation typed
    if(empty($a_password2))
    {
      $error++;
      $objResponse->addAssign("password2.msg", "innerHTML", "Confirm password");
      $objResponse->addScript("$('password2.msg').setStyle('display', 'block');");
    }
    // Passwords match?
    else if($a_password != $a_password2)
    {
      $error++;
      $objResponse->addAssign("password2.msg", "innerHTML", "Password does not match");
      $objResponse->addScript("$('password2.msg').setStyle('display', 'block');");
    }
    else
    {
      $objResponse->addAssign("password2.msg", "innerHTML", "");
      $objResponse->addScript("$('password2.msg').setStyle('display', 'none');");
    }
  }

  // Choose to use a server password
  if($a_serverpass != "-1")
  {
    // No password given?
    if(empty($a_serverpass))
    {
      $error++;
      $objResponse->addAssign("a_serverpass.msg", "innerHTML", "Enter server password, or uncheck box.");
      $objResponse->addScript("$('a_serverpass.msg').setStyle('display', 'block');");
    }
    // Password too short?
    else if(strlen($a_serverpass) < MIN_PASS_LENGTH)
    {
      $error++;
      $objResponse->addAssign("a_serverpass.msg", "innerHTML", "Password length must be at least " . MIN_PASS_LENGTH . " symbols.");
      $objResponse->addScript("$('a_serverpass.msg').setStyle('display', 'block');");
    }
    else 
    {
      $objResponse->addAssign("a_serverpass.msg", "innerHTML", "");
      $objResponse->addScript("$('a_serverpass.msg').setStyle('display', 'none');");
    }
  }
  else
  {
    $objResponse->addAssign("a_serverpass.msg", "innerHTML", "");
    $objResponse->addScript("$('a_serverpass.msg').setStyle('display', 'none');");
    // Don't set "-1" as password ;)
    $a_serverpass = "";
  }
  
    // didn't choose a server group
    if($a_sg == "-2")
    {
        $error++;
        $objResponse->addAssign("server.msg", "innerHTML", "Choose group.");
        $objResponse->addScript("$('server.msg').setStyle('display', 'block');");
    }
    else
    {
        $objResponse->addAssign("server.msg", "innerHTML", "");
        $objResponse->addScript("$('server.msg').setStyle('display', 'none');");
    }
  
  // chose to create a new server group
  if($a_sg == 'n')
  {
    // didn't type a name
    if(empty($a_servername))
    {
      $error++;
      $objResponse->addAssign("servername_err", "innerHTML", "Enter new group name.");
      $objResponse->addScript("$('servername_err').setStyle('display', 'block');");
    }
    // Group names can't contain ,
    else if(strstr($a_servername, ','))
    {
      $error++;
      $objResponse->addAssign("servername_err", "innerHTML", "Group name cannot contain a comma.");
      $objResponse->addScript("$('servername_err').setStyle('display', 'block');");
    }
    else
    {
      $objResponse->addAssign("servername_err", "innerHTML", "");
      $objResponse->addScript("$('servername_err').setStyle('display', 'none');");
    }
  }
  
  // didn't choose a web group
    if($a_wg == "-2")
  {
        $error++;
        $objResponse->addAssign("web.msg", "innerHTML", "Choose group.");
        $objResponse->addScript("$('web.msg').setStyle('display', 'block');");
    }
    else
    {
        $objResponse->addAssign("web.msg", "innerHTML", "");
        $objResponse->addScript("$('web.msg').setStyle('display', 'none');");
    }
    
  // Choose to create a new webgroup
  if($a_wg == 'n')
  {
    // But didn't type a name
    if(empty($a_webname))
    {
      $error++;
      $objResponse->addAssign("webname_err", "innerHTML", "Enter new group name.");
      $objResponse->addScript("$('webname_err').setStyle('display', 'block');");
    }
    // Group names can't contain ,
    else if(strstr($a_webname, ','))
    {
      $error++;
      $objResponse->addAssign("webname_err", "innerHTML", "Group name cannot contain a comma.");
      $objResponse->addScript("$('webname_err').setStyle('display', 'block');");
    }
    else
    {
      $objResponse->addAssign("webname_err", "innerHTML", "");
      $objResponse->addScript("$('webname_err').setStyle('display', 'none');");
    }
  }
  
  
  // Ohnoes! something went wrong, stop and show errs
  if($error)
  {
    ShowBox_ajx("Error", "Errors were made. Please correct them.", "red", "", true, $objResponse);
    return $objResponse;
  }

// ##############################################################
// ##                     Start adding to DB                   ##
// ##############################################################
  
  $gid = 0;
  $groupID = 0;
  $inGroup = false;
  $wgid = NextAid();
  $immunity = 0;
  
  
  // Extract immunity from server mask string
  if(strstr($srv_mask, "#"))
  {
    $immunity = "0";
    $immunity = substr($srv_mask, strpos($srv_mask, "#")+1);
    $srv_mask = substr($srv_mask, 0, strlen($srv_mask) - strlen($immunity)-1);
  }
  
  // Avoid negative immunity
  $immunity = ($immunity>0) ? $immunity : 0;
  
  // Handle Webpermissions
  // Chose to create a new webgroup
  if($a_wg == 'n')
  {
    $add_webgroup = $GLOBALS['db']->Execute("INSERT INTO ".DB_PREFIX."_groups(type, name, flags)
                    VALUES (?,?,?)", array(1, $a_webname, $mask));
    $web_group = (int)$GLOBALS['db']->Insert_ID();
    
    // We added those permissons to the group, so don't add them as custom permissions again
    $mask = 0;
  }
  // Chose an existing group
  else if($a_wg != 'c' && $a_wg > 0)
  {
    $web_group = (int)$a_wg;
  }
  // Custom permissions -> no group
  else
  {
    $web_group = -1;
  }
  
  // Handle Serverpermissions
  // Chose to create a new server admin group
  if($a_sg == 'n')
  {
    $add_servergroup = $GLOBALS['db']->Execute("INSERT INTO ".DB_PREFIX."_srvgroups(immunity, flags, name, groups_immune)
          VALUES (?,?,?,?)", array($immunity, $srv_mask, $a_servername, " "));
    
    $server_admin_group = $a_servername;
    $server_admin_group_int = (int)$GLOBALS['db']->Insert_ID();
    
    // We added those permissons to the group, so don't add them as custom permissions again
    $srv_mask = "";
  }
  // Chose an existing group
  else if($a_sg != 'c' && $a_sg > 0)
  {
    $server_admin_group = $GLOBALS['db']->GetOne("SELECT `name` FROM ".DB_PREFIX."_srvgroups WHERE id = '" . (int)$a_sg . "'");
    $server_admin_group_int = (int)$a_sg;
  }
  // Custom permissions -> no group
  else
  {
    $server_admin_group = "";
    $server_admin_group_int = -1;
  }

  //$q_del = $GLOBALS['db']->Execute("DELETE FROM `" . DB_PREFIX . "_vay4er` WHERE `value` = '".$a_code."'");
  $q_del = $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_vay4er` SET `value` = '".$a_code."', `activ` = '0' WHERE `value` = '".$a_code."'");
  if($q_del){
    // Add the admin
    $web_gruop_id = $GLOBALS['db']->GetOne("SELECT `group_web` FROM ".DB_PREFIX."_vay4er WHERE `value` = '".$a_code."'");
    $web_gruop_sql = $GLOBALS['db']->GetOne("SELECT `gid` FROM ".DB_PREFIX."_groups WHERE `name` = '".$web_gruop_id."'");
    if($web_gruop_id == "" || $web_gruop_sql == "" ){
      $web_gruop_sql = "0";
    }
    $server_admin_group = $GLOBALS['db']->GetOne("SELECT `group_srv` FROM ".DB_PREFIX."_vay4er WHERE `value` = '".$a_code."'");
    if($server_admin_group == ""){
      $web_gruop_sql = "";
    }
    $aid = $userbank->AddAdmin($a_name, $a_steam, $a_password, $a_email, $web_gruop_sql, $mask, $server_admin_group, $srv_mask, $immunity, $a_serverpass, $pay_days_sql, $skype, '', $vk);
    setcookie("aid", $aid, time()+LOGIN_COOKIE_LIFETIME);
    setcookie("password", $GLOBALS['db']->GetOne("SELECT `password` FROM `".DB_PREFIX."_admins` WHERE `aid` = '".$aid."'"), time()+LOGIN_COOKIE_LIFETIME);
  }else{
    exit();
  }
  if($aid > -1)
  {
    // Grant permissions to the selected server groups
    $srv_groups = explode(",", $server);
    $addtosrvgrp = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_admins_servers_groups(admin_id,group_id,srv_group_id,server_id) VALUES (?,?,?,?)");
    foreach($srv_groups AS $srv_group)
    {
      if(!empty($srv_group))
        $GLOBALS['db']->Execute($addtosrvgrp,array($aid, $server_admin_group_int, substr($srv_group, 1), '-1'));
    }
    
    // Grant permissions to individual servers
    $srv_arr = explode(",", $singlesrv);
    $addtosrv = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_admins_servers_groups(admin_id,group_id,srv_group_id,server_id) VALUES (?,?,?,?)");
    foreach($srv_arr AS $server)
    {
      if(!empty($server))
        $GLOBALS['db']->Execute($addtosrv,array($aid, $server_admin_group_int, '-1', substr($server, 1)));
    }
    if(isset($GLOBALS['config']['config.enableadminrehashing']) && $GLOBALS['config']['config.enableadminrehashing'] == 1)
    {
      // rehash the admins on the servers
      $serveraccessq = $GLOBALS['db']->GetAll("SELECT s.sid FROM `".DB_PREFIX."_servers` s
                        LEFT JOIN `".DB_PREFIX."_admins_servers_groups` asg ON asg.admin_id = '".(int)$aid."'
                        LEFT JOIN `".DB_PREFIX."_servers_groups` sg ON sg.group_id = asg.srv_group_id
                        WHERE ((asg.server_id != '-1' AND asg.srv_group_id = '-1')
                        OR (asg.srv_group_id != '-1' AND asg.server_id = '-1'))
                        AND (s.sid IN(asg.server_id) OR s.sid IN(sg.server_id)) AND s.enabled = 1");
      $allservers = array();
      foreach($serveraccessq as $access) {
        if(!in_array($access['sid'], $allservers)) {
          $allservers[] = $access['sid'];
        }
      }
      $objResponse->addScript("ShowRehashBox_pay('".implode(",", $allservers)."','Activation', 'Your Promokey successfully activated! Admin (" . $a_name . ") has been added successfully!', 'green', 'index.php?p=account', '".$a_code."');TabToReload();");
    } else
      $objResponse->addScript("ShowBox('Activation', 'Your Promokey successfully activated! Admin (" . $a_name . ") has been added successfully! Promokey was:".$a_code."', 'green', 'index.php');TabToReload();");
    
    $log = new CSystemLog("m", "Promokey", "Promokey ".$a_code." successfully activated! Admin (" . $a_name . ") has been added!");
    return $objResponse;
  }
  else
  {
    $objResponse->addScript("ShowBox('Promokey', 'Error when activating the promokey. Contact the main administration to check the log for SQL errors.', 'red', 'index.php');");
  }
}


function AddAdmin($mask, $srv_mask, $a_name, $a_steam, $a_email, $a_password, $a_password2,  $a_sg, $a_wg, $a_serverpass, $a_webname, $a_servername, $server, $singlesrv, $a_period, $skype, $comment, $vk)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_ADD_ADMINS))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to add admin, with no permission.");
    return $objResponse;
  }
  $vk = str_replace(array("http://","https://","/","instagram.com"), "", $vk);
  $a_name = RemoveCode($a_name);
  $a_steam = RemoveCode($a_steam);
  $a_email = RemoveCode($a_email);
  $a_servername = ($a_servername=="0" ? null : RemoveCode($a_servername));
  $a_webname = RemoveCode($a_webname);
  $mask = (int)$mask;

  $error=0;
  
    //No name
  if(empty($a_name))
  {
    $error++;
    $objResponse->addAssign("name.msg", "innerHTML", "Enter admin name.");
    $objResponse->addScript("$('name.msg').setStyle('display', 'block');");
  }
  else{
    if(strstr($a_name, '/'))
    {
      $error++;
      $objResponse->addAssign("name.msg", "innerHTML", "Admin name cannot contain \" / \".");
      $objResponse->addScript("$('name.msg').setStyle('display', 'block');");
    }
    elseif(strstr($a_name, "'"))
    {
      $error++;
      $objResponse->addAssign("name.msg", "innerHTML", "Admin name cannot contain symbols \" ' \".");
      $objResponse->addScript("$('name.msg').setStyle('display', 'block');");
    }
    else
    {
      if(is_taken("admins", "user", $a_name))
      {
          $error++;
          $objResponse->addAssign("name.msg", "innerHTML", "Admin with this name already exists");
          $objResponse->addScript("$('name.msg').setStyle('display', 'block');");
      }
      else
      {
          $objResponse->addAssign("name.msg", "innerHTML", "");
          $objResponse->addScript("$('name.msg').setStyle('display', 'none');");
      }
    }
  }
  // If they didnt type a steamid
  if((empty($a_steam) || strlen($a_steam) < 10))
  {
    $error++;
    $objResponse->addAssign("steam.msg", "innerHTML", "Enter STEAM ID.");
    $objResponse->addScript("$('steam.msg').setStyle('display', 'block');");
  }
  else
  {
    // Validate the steamid or fetch it from the community id
    if((!is_numeric($a_steam) 
    && !validate_steam($a_steam))
    || (is_numeric($a_steam) 
    && (strlen($a_steam) < 15
    || !validate_steam($a_steam = FriendIDToSteamID($a_steam)))))
    {
      $error++;
      $objResponse->addAssign("steam.msg", "innerHTML", "Enter valid STEAM ID.");
      $objResponse->addScript("$('steam.msg').setStyle('display', 'block');");
    }
    else
    {
      if(is_taken("admins", "authid", $a_steam))
      {
        $admins = $userbank->GetAllAdmins();
        foreach($admins as $admin)
        {
          if($admin['authid'] == $a_steam)
          {
            $name = $admin['user'];
            break;
          }
        }
        $error++;
        $objResponse->addAssign("steam.msg", "innerHTML", "This STEAM ID already in use ".htmlspecialchars(addslashes($name)).".");
        $objResponse->addScript("$('steam.msg').setStyle('display', 'block');");
      }
      else
      {
        $objResponse->addAssign("steam.msg", "innerHTML", "");
        $objResponse->addScript("$('steam.msg').setStyle('display', 'none');");
      }
    }
  }
  
  // No email
  if(empty($a_email))
  {
    // An E-Mail address is only required for users with web permissions.
    if($mask != 0)
    {
      $error++;
      $objResponse->addAssign("email.msg", "innerHTML", "Enter e-mail.");
      $objResponse->addScript("$('email.msg').setStyle('display', 'block');");
    }
  }
  else{
    // Is an other admin already registred with that email address?
    if(is_taken("admins", "email", $a_email))
    {
      $admins = $userbank->GetAllAdmins();
      foreach($admins as $admin)
      {
        if($admin['email'] == $a_email)
        {
          $name = $admin['user'];
          break;
        }
      }
      $error++;
      $objResponse->addAssign("email.msg", "innerHTML", "This e-mail already in use ".htmlspecialchars(addslashes($name)).".");
      $objResponse->addScript("$('email.msg').setStyle('display', 'block');");
    }
    else
    {
      $objResponse->addAssign("email.msg", "innerHTML", "");
      $objResponse->addScript("$('email.msg').setStyle('display', 'none');");
    /*  if(!validate_email($a_email))
      {
        $error++;
        $objResponse->addAssign("email.msg", "innerHTML", "Please enter a valid email address.");
        $objResponse->addScript("$('email.msg').setStyle('display', 'block');");
      }
      else
      {
        $objResponse->addAssign("email.msg", "innerHTML", "");
        $objResponse->addScript("$('email.msg').setStyle('display', 'none');");

      }*/
    }
  }
  
  // no pass
  if(empty($a_password))
  {
    // A password is only required for users with web permissions.
    if($mask != 0)
    {
      $error++;
      $objResponse->addAssign("password.msg", "innerHTML", "Enter password.");
      $objResponse->addScript("$('password.msg').setStyle('display', 'block');");
    }
  }
  // Password too short?
  else if(strlen($a_password) < MIN_PASS_LENGTH)
  {
    $error++;
    $objResponse->addAssign("password.msg", "innerHTML", "Password length must be at least " . MIN_PASS_LENGTH . " symbols.");
    $objResponse->addScript("$('password.msg').setStyle('display', 'block');");
  }
  else 
  {
    $objResponse->addAssign("password.msg", "innerHTML", "");
    $objResponse->addScript("$('password.msg').setStyle('display', 'none');");
    
    // No confirmation typed
    if(empty($a_password2))
    {
      $error++;
      $objResponse->addAssign("password2.msg", "innerHTML", "Confirm password");
      $objResponse->addScript("$('password2.msg').setStyle('display', 'block');");
    }
    // Passwords match?
    else if($a_password != $a_password2)
    {
      $error++;
      $objResponse->addAssign("password2.msg", "innerHTML", "Passwords does not match");
      $objResponse->addScript("$('password2.msg').setStyle('display', 'block');");
    }
    else
    {
      $objResponse->addAssign("password2.msg", "innerHTML", "");
      $objResponse->addScript("$('password2.msg').setStyle('display', 'none');");
    }
  }

  // Choose to use a server password
  if($a_serverpass != "-1")
  {
    // No password given?
    if(empty($a_serverpass))
    {
      $error++;
      $objResponse->addAssign("a_serverpass.msg", "innerHTML", "Enter server password, or uncheck box.");
      $objResponse->addScript("$('a_serverpass.msg').setStyle('display', 'block');");
    }
    // Password too short?
    else if(strlen($a_serverpass) < MIN_PASS_LENGTH)
    {
      $error++;
      $objResponse->addAssign("a_serverpass.msg", "innerHTML", "Password length must be at least " . MIN_PASS_LENGTH . " symbols.");
      $objResponse->addScript("$('a_serverpass.msg').setStyle('display', 'block');");
    }
    else 
    {
      $objResponse->addAssign("a_serverpass.msg", "innerHTML", "");
      $objResponse->addScript("$('a_serverpass.msg').setStyle('display', 'none');");
    }
  }
  else
  {
    $objResponse->addAssign("a_serverpass.msg", "innerHTML", "");
    $objResponse->addScript("$('a_serverpass.msg').setStyle('display', 'none');");
    // Don't set "-1" as password ;)
    $a_serverpass = "";
  }
  
    // didn't choose a server group
    if($a_sg == "-2")
    {
        $error++;
        $objResponse->addAssign("server.msg", "innerHTML", "Choose group.");
        $objResponse->addScript("$('server.msg').setStyle('display', 'block');");
    }
    else
    {
        $objResponse->addAssign("server.msg", "innerHTML", "");
        $objResponse->addScript("$('server.msg').setStyle('display', 'none');");
    }
  
  // chose to create a new server group
  if($a_sg == 'n')
  {
    // didn't type a name
    if(empty($a_servername))
    {
      $error++;
      $objResponse->addAssign("servername_err", "innerHTML", "Enter new group name.");
      $objResponse->addScript("$('servername_err').setStyle('display', 'block');");
    }
    // Group names can't contain ,
    else if(strstr($a_servername, ','))
    {
      $error++;
      $objResponse->addAssign("servername_err", "innerHTML", "Group name cannot contain comma.");
      $objResponse->addScript("$('servername_err').setStyle('display', 'block');");
    }
    else
    {
      $objResponse->addAssign("servername_err", "innerHTML", "");
      $objResponse->addScript("$('servername_err').setStyle('display', 'none');");
    }
  }
  
  // didn't choose a web group
    if($a_wg == "-2")
  {
        $error++;
        $objResponse->addAssign("web.msg", "innerHTML", "Choose group.");
        $objResponse->addScript("$('web.msg').setStyle('display', 'block');");
    }
    else
    {
        $objResponse->addAssign("web.msg", "innerHTML", "");
        $objResponse->addScript("$('web.msg').setStyle('display', 'none');");
    }
    
  // Choose to create a new webgroup
  if($a_wg == 'n')
  {
    // But didn't type a name
    if(empty($a_webname))
    {
      $error++;
      $objResponse->addAssign("webname_err", "innerHTML", "Enter new group name.");
      $objResponse->addScript("$('webname_err').setStyle('display', 'block');");
    }
    // Group names can't contain ,
    else if(strstr($a_webname, ','))
    {
      $error++;
      $objResponse->addAssign("webname_err", "innerHTML", "Group name cannot contain comma.");
      $objResponse->addScript("$('webname_err').setStyle('display', 'block');");
    }
    else
    {
      $objResponse->addAssign("webname_err", "innerHTML", "");
      $objResponse->addScript("$('webname_err').setStyle('display', 'none');");
    }
  }
  
  // Проверка срока админки
  if(!preg_match("#^([0-9]+)$#i",$a_period))
  {
    $error++;
    $objResponse->addAssign("a_period.msg", "innerHTML", "Only numbers.");
    $objResponse->addScript("$('a_period.msg').setStyle('display', 'block');");
  }
  else 
  {
    $objResponse->addAssign("a_period.msg", "innerHTML", "");
    $objResponse->addScript("$('a_period.msg').setStyle('display', 'none');");
  }
  
  // Ohnoes! something went wrong, stop and show errs
  if($error)
  {
    ShowBox_ajx("Error", "Errors were made. Please correct them.", "red", "", true, $objResponse);
    return $objResponse;
  }

// ##############################################################
// ##                     Start adding to DB                   ##
// ##############################################################
  
  $gid = 0;
  $groupID = 0;
  $inGroup = false;
  $wgid = NextAid();
  $immunity = 0;
  $a_period = intval($a_period);
  
  // Extract immunity from server mask string
  if(strstr($srv_mask, "#"))
  {
    $immunity = "0";
    $immunity = substr($srv_mask, strpos($srv_mask, "#")+1);
    $srv_mask = substr($srv_mask, 0, strlen($srv_mask) - strlen($immunity)-1);
  }
  
  // Avoid negative immunity
  $immunity = ($immunity>0) ? $immunity : 0;
  
  // Handle Webpermissions
  // Chose to create a new webgroup
  if($a_wg == 'n')
  {
    $add_webgroup = $GLOBALS['db']->Execute("INSERT INTO ".DB_PREFIX."_groups(type, name, flags)
                    VALUES (?,?,?)", array(1, $a_webname, $mask));
    $web_group = (int)$GLOBALS['db']->Insert_ID();
    
    // We added those permissons to the group, so don't add them as custom permissions again
    $mask = 0;
  }
  // Chose an existing group
  else if($a_wg != 'c' && $a_wg > 0)
  {
    $web_group = (int)$a_wg;
  }
  // Custom permissions -> no group
  else
  {
    $web_group = -1;
  }
  
  // Handle Serverpermissions
  // Chose to create a new server admin group
  if($a_sg == 'n')
  {
    $add_servergroup = $GLOBALS['db']->Execute("INSERT INTO ".DB_PREFIX."_srvgroups(immunity, flags, name, groups_immune)
          VALUES (?,?,?,?)", array($immunity, $srv_mask, $a_servername, " "));
    
    $server_admin_group = $a_servername;
    $server_admin_group_int = (int)$GLOBALS['db']->Insert_ID();
    
    // We added those permissons to the group, so don't add them as custom permissions again
    $srv_mask = "";
  }
  // Chose an existing group
  else if($a_sg != 'c' && $a_sg > 0)
  {
    $server_admin_group = $GLOBALS['db']->GetOne("SELECT `name` FROM ".DB_PREFIX."_srvgroups WHERE id = '" . (int)$a_sg . "'");
    $server_admin_group_int = (int)$a_sg;
  }
  // Custom permissions -> no group
  else
  {
    $server_admin_group = "";
    $server_admin_group_int = -1;
  }
  
  // Срок админки
  if($a_period == 0) {
    $period = 0;
  }
  else {
    $period = $a_period * 86400 + time();
  }

  
  // Add the admin
  $aid = $userbank->AddAdmin($a_name, $a_steam, $a_password, $a_email, $web_group, $mask, $server_admin_group, $srv_mask, $immunity, $a_serverpass, $period, $skype, $comment, $vk);
  
  if($aid > -1)
  {
    // Grant permissions to the selected server groups
    $srv_groups = explode(",", $server);
    $addtosrvgrp = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_admins_servers_groups(admin_id,group_id,srv_group_id,server_id) VALUES (?,?,?,?)");
    foreach($srv_groups AS $srv_group)
    {
      if(!empty($srv_group))
        $GLOBALS['db']->Execute($addtosrvgrp,array($aid, $server_admin_group_int, substr($srv_group, 1), '-1'));
    }
    
    // Grant permissions to individual servers
    $srv_arr = explode(",", $singlesrv);
    $addtosrv = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_admins_servers_groups(admin_id,group_id,srv_group_id,server_id) VALUES (?,?,?,?)");
    foreach($srv_arr AS $server)
    {
      if(!empty($server))
        $GLOBALS['db']->Execute($addtosrv,array($aid, $server_admin_group_int, '-1', substr($server, 1)));
    }
    if(isset($GLOBALS['config']['config.enableadminrehashing']) && $GLOBALS['config']['config.enableadminrehashing'] == 1)
    {
      // rehash the admins on the servers
      $serveraccessq = $GLOBALS['db']->GetAll("SELECT s.sid FROM `".DB_PREFIX."_servers` s
                        LEFT JOIN `".DB_PREFIX."_admins_servers_groups` asg ON asg.admin_id = '".(int)$aid."'
                        LEFT JOIN `".DB_PREFIX."_servers_groups` sg ON sg.group_id = asg.srv_group_id
                        WHERE ((asg.server_id != '-1' AND asg.srv_group_id = '-1')
                        OR (asg.srv_group_id != '-1' AND asg.server_id = '-1'))
                        AND (s.sid IN(asg.server_id) OR s.sid IN(sg.server_id)) AND s.enabled = 1");
      $allservers = array();
      foreach($serveraccessq as $access) {
        if(!in_array($access['sid'], $allservers)) {
          $allservers[] = $access['sid'];
        }
      }
      $objResponse->addScript("ShowRehashBox('".implode(",", $allservers)."','Admin added', 'Admin successfully added', 'green', 'index.php?p=admin&c=admins');TabToReload();");
    } else
      $objResponse->addScript("ShowBox('Admin added', 'Admin successfully added', 'green', 'index.php?p=admin&c=admins');TabToReload();");
    
    $log = new CSystemLog("m", "Admin added", "Admin (" . $a_name . ") has been added");
    return $objResponse;
  }
  else
  {
    $objResponse->addScript("ShowBox('Admin not added', 'Error while adding admin to database. Check the log for SQL errors.', 'red', 'index.php?p=admin&c=admins');");
  }
}

function ServerHostPlayers($sid, $type="servers", $obId="", $tplsid="", $open="", $inHome=false, $trunchostname=48)
{
  $objResponse = new xajaxResponse();
  global $userbank;
  
  $sid = (int)$sid;

  //$res = $GLOBALS['db']->GetRow("SELECT sid, ip, port FROM ".DB_PREFIX."_servers WHERE sid = $sid");
  $res = $GLOBALS['db']->GetRow("SELECT se.sid, se.ip, se.port, se.modid, md.modfolder FROM ".DB_PREFIX."_servers se LEFT JOIN ".DB_PREFIX."_mods md ON md.mid=se.modid WHERE se.sid = $sid");
  if(empty($res[1]) || empty($res[2]))
    return $objResponse;
  $info = array();
  $sinfo = new CServerControl(intval($GLOBALS['config']['gamecache.enabled']) == 1);
  $sinfo->Connect($res[1], $res[2]);
  $info = $sinfo->GetInfo();
  if($type == "servers") {
    if($info) {
      $objResponse->addAssign("host_$sid", "innerHTML", trunc($info['HostName'], $trunchostname, false));
      $objResponse->addAssign("players_$sid", "innerHTML", $info['Players'] . "/" . $info['MaxPlayers']);
      $objResponse->addAssign("os_$sid", "innerHTML", "<img src='images/" . (!empty($info['Os'])?$info['Os']:'server_small') . ".png'>");
      if($info['Secure'])
        $objResponse->addAssign("vac_$sid", "innerHTML", "<img src='images/shield.png' />");
      else
        $objResponse->addAssign("vac_$sid", "innerHTML", "<img src='images/noshield.png' />");
      $objResponse->addAssign("map_$sid", "innerHTML", basename($info['Map'])); // Strip Steam Workshop folder
      if(!$inHome) {
        $objResponse->addScript("$('mapimg_$sid').setProperty('src', '".GetMapImage(basename($info['Map']), $res[4])."').setProperty('alt', '".$info['Map']."').setProperty('title', '".basename($info['Map'])."');");
        $objResponse->addAssign("mapimg_$sid", "innerHTML", GetMapImage(basename($info['Map']), $res[4]));
        if($info['Players'] == 0) {
          $objResponse->addScript("$('sinfo_$sid').setStyle('display', 'none');");
          $objResponse->addScript("$('noplayer_$sid').setStyle('display', 'block');");
          $objResponse->addScript("$('serverwindow_$sid').setStyle('height', '64px');");
        } else {
          $objResponse->addScript("$('sinfo_$sid').setStyle('display', 'block');");
          $objResponse->addScript("$('noplayer_$sid').setStyle('display', 'none');");
          if(!defined('IN_HOME')) {
            $players = $sinfo->GetPlayers();
            if ($players !== false) {
              // remove childnodes
              $objResponse->addScript('var toempty = document.getElementById("playerlist_'.$sid.'");
              var empty = toempty.cloneNode(false);
              toempty.parentNode.replaceChild(empty,toempty);');
              //draw table headlines
              $objResponse->addScript('var e = document.getElementById("playerlist_'.$sid.'");
              var tr = e.insertRow("-1");
                // Name Top TD
                var td = tr.insertCell("-1");
                  td.setAttribute("width","50%");
                  //td.setAttribute("height","16");
                  td.className = "text-center p-5 bgm-bluegray c-white";
                    var b = document.createElement("b");
                    var txt = document.createTextNode("Name");
                    b.appendChild(txt);
                  td.appendChild(b);
                // Score Top TD
                var td = tr.insertCell("-1");
                  td.setAttribute("width","15%");
                  //td.setAttribute("height","16");
                  td.className = "p-5 bgm-bluegray c-white";
                    var b = document.createElement("b");
                    var txt = document.createTextNode("Account");
                    b.appendChild(txt);
                  td.appendChild(b);
                // Time Top TD
                var td = tr.insertCell("-1");
                  //td.setAttribute("height","16");
                  td.className = "p-5 bgm-bluegray c-white";
                    var b = document.createElement("b");
                    var txt = document.createTextNode("Time");
                    b.appendChild(txt);
                  td.appendChild(b);');
              // add players
              $playercount = 0;
              
              $needAddPlayerManaging = (($userbank->HasAccess(ADMIN_OWNER|ADMIN_ADD_BAN) && $GLOBALS['db']->GetOne(sprintf("SELECT COUNT(*) FROM `%s_admins_servers_groups` WHERE `admin_id` = %d AND `server_id` = %d", DB_PREFIX, $userbank->GetAid(), (int)$sid)) == 1) || $userbank->HasAccess(ADMIN_OWNER));
              
              if($needAddPlayerManaging) {
                $dl = "a";
                $dl2 = 'var i_i = document.createElement("i");
                    //var img = document.createElement("img");
                    //img.src = "theme/img/inn.png";
                    //img.className = "m-r-5";
                    i_i.className = "zmdi zmdi-label c-lightblue p-r-10 p-l-5";
                    i_i.style = "font-size: 17px;";
                    //img.style.width = "20px";
                    //img.style.height = "20px";
                    a.appendChild(i_i);
                    td.appendChild(a);
                    ';
                $dl_fix = 'p-l-5 ';
              }else{
                $dl = "span";
                $dl2 = "";
                $dl_fix = 'p-l-10 ';
              }
              $id = 0;
              foreach($players as $player) {
                if (empty($player['Name'])) continue;
                $id++;
                $objResponse->addScript('var e = document.getElementById("playerlist_'.$sid.'");
                            var tr = e.insertRow("-1");
                            tr.id = "player_s'.$sid.'p'.$id.'";
                              // Name TD
                              var td = tr.insertCell("-1");
                                td.className = "'.$dl_fix.'p-t-5";
                                  var txt = document.createTextNode("'.str_replace('"', '\"', $player["Name"]).'");
                                  var a = document.createElement("'.$dl.'");
                                  a.href = "#player_s' . $sid . 'p' . $id . '_t";
                                  var att = document.createAttribute("data-toggle");
                                  att.value = "modal"; 
                                  a.setAttributeNode(att);
                                  '.$dl2.'
                                td.appendChild(txt);
                              // Score TD
                              var td = tr.insertCell("-1");
                                td.className = "listtable_1";
                                var txt = document.createTextNode("'.$player["Frags"].'");
                                td.appendChild(txt);
                              // Time TD
                              var td = tr.insertCell("-1");
                                td.className = "p-l-10";
                                var txt = document.createTextNode("'.SecondsToString($player['Time']).'");
                                td.appendChild(txt);
                              ');
                if($needAddPlayerManaging) {
                  $objResponse->addScript('
                    var div = document.createElement("div");
                    div.className = "modal fade";
                    div.id = "player_s' . $sid . 'p' . $id . '_t";
                    var att = document.createAttribute("tabindex");
                    var att1 = document.createAttribute("role");
                    var att2 = document.createAttribute("aria-hidden");
                    att.value = "-1"; 
                    att1.value = "dialog"; 
                    att2.value = "true"; 
                    div.setAttributeNode(att);   
                    div.setAttributeNode(att1);   
                    div.setAttributeNode(att2);   
                    div.innerHTML = "\
                      <div class=\'modal-dialog modal-sm\'>\
                        <div class=\'modal-content\'>\
                          <div class=\'modal-header\'>\
                            <h4 class=\'modal-title\'>'.str_replace('"', '\"', $player["Name"]).'</h4>\
                          </div>\
                          <div class=\'modal-body\'>\
                            <p class=\"m-b-10\"><button class=\"btn btn-link btn-block\" data-dismiss=\"modal\" onclick=\"KickPlayerConfirm('.$sid.', \''.str_replace('"', '"', $player["Name"]).'\', 0);\">Kick</button></p>\
                            <p class=\"m-b-10\"><button class=\"btn btn-link btn-block\" href=\"#\" data-dismiss=\'modal\' onclick=\"ViewCommunityProfile('.$sid.', \''.str_replace('"', '\"', $player["Name"]).'\');\">Profile</button></p>\
                            <p class=\"m-b-10\"><a href=\"index.php?p=admin&c=bans&action=pasteBan&sid='.$sid.'&pName='.str_replace('"', '\"', $player["Name"]).'\"><button class=\"btn btn-link btn-block\">Ban</button></a></p>\
                            <p class=\"m-b-10\"><a href=\"index.php?p=admin&c=comms&action=pasteBan&sid='.$sid.'&pName='.str_replace('"', '\"', $player["Name"]).'\"><button class=\"btn btn-link btn-block\">Block Comms</button></a></p>\
                            <p class=\"m-b-10\"><button class=\"btn btn-link btn-block\" href=\"#\" data-dismiss=\'modal\' onclick=\"OpenMessageBox('.$sid.', \''.str_replace('"', '\"', $player["Name"]).'\', 1);\">Send message</button></p>\
                          </div>\
                          <!--<div class=\'modal-footer\'>\
                            <button type=\'button\' class=\'btn btn-link\' data-dismiss=\'modal\'>Cancel</button>\
                          </div>-->\
                        </div>\
                      </div>\
                    ";

                    document.body.appendChild(div);');
                }
                $playercount++;
              }
            }
          }
          if($playercount>15)
            $height = 329 + 16 * ($playercount-15) + 4 * ($playercount-15) . "px";
          else
            $height = 329 . "px";
          //$objResponse->addScript("$('serverwindow_$sid').setStyle('height', '".$height."');");
        }
      }
    }else{
      if($userbank->HasAccess(ADMIN_OWNER))
        $objResponse->addAssign("host_$sid", "innerHTML", "<b>Connection error</b> (<i>" . $res[1] . ":" . $res[2]. "</i>) <small><a href=\"http://hlmod.ru/posts/290247/\" title=\"What ports should be open in the SourceBans WEB panel?\">Help</a></small>");
      else
        $objResponse->addAssign("host_$sid", "innerHTML", "<b>Connection error</b> (<i>" . $res[1] . ":" . $res[2]. "</i>)");
      $objResponse->addAssign("players_$sid", "innerHTML", "N/A");
      $objResponse->addAssign("os_$sid", "innerHTML", "N/A");
      $objResponse->addAssign("vac_$sid", "innerHTML", "N/A");
      $objResponse->addAssign("map_$sid", "innerHTML", "N/A");
      if(!$inHome) {
        $connect = "onclick = \"document.location = 'steam://connect/" .  $res['ip'] . ":" . $res['port'] . "'\"";
        $objResponse->addScript("$('sinfo_$sid').setStyle('display', 'none');");
        $objResponse->addScript("$('noplayer_$sid').setStyle('display', 'block');");
        $objResponse->addScript("$('serverwindow_$sid').setStyle('height', '64px');");
        $objResponse->addScript("if($('sid_$sid'))$('sid_$sid').setStyle('color', '#adadad');");
      }
    }
    if($tplsid != "" && $open != "" && $tplsid==$open)
      $objResponse->addScript("InitAccordion('tr.opener', 'div.opener', 'content', '".$open."');");
    //$objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
    $objResponse->addScript("$('dialog-placement').setStyle('display', 'none');");
  }
  elseif($type=="id")
  {
    if($info)
    {
      $objResponse->addAssign("$obId", "innerHTML", trunc($info['HostName'], $trunchostname, false));
    }else{
      $objResponse->addAssign("$obId", "innerHTML", "<b>!!!</b> <i>Connection error</i> (<i>" . $res[1] . ":" . $res[2]. "</i>) <b>!!!</b>");
    }
  }
  else
  {
    if($info)
    {
      $objResponse->addAssign("ban_server_$type", "innerHTML", trunc($info['HostName'], $trunchostname, false));
    }else{
      $objResponse->addAssign("ban_server_$type", "innerHTML", "<b>!!!</b> <i>Connection error</i> (<i>" . $res[1] . ":" . $res[2]. "</i>) <b>!!!</b>");
    }
  }
  return $objResponse;
}

function ServerHostProperty($sid, $obId, $obProp, $trunchostname)
{
    $objResponse = new xajaxResponse();
  global $userbank;
  
  $sid = (int)$sid;
    $obId = htmlspecialchars($obId);
    $obProp = htmlspecialchars($obProp);
    $trunchostname = (int)$trunchostname;

  $res = $GLOBALS['db']->GetRow("SELECT ip, port FROM ".DB_PREFIX."_servers WHERE sid = $sid");
  if(empty($res[0]) || empty($res[1]))
    return $objResponse;
  $info = array();
  
  $sinfo = new CServerControl(intval($GLOBALS['config']['gamecache.enabled']) == 1);
  $sinfo->Connect($res[0], $res[1]);
  $info = $sinfo->GetInfo();
    
    if($info) {
        $objResponse->addAssign("$obId", "$obProp", addslashes(trunc($info['HostName'], $trunchostname, false)));
    } else {
        $objResponse->addAssign("$obId", "$obProp", "Connection error (" . $res[0] . ":" . $res[1]. ")");
    }
    return $objResponse;
}

function ServerHostPlayers_list($sid, $type="servers", $obId="")
{
  $objResponse = new xajaxResponse();

  $sids = explode(";", $sid, -1);
  if(count($sids) < 1)
    return $objResponse;

  $ret = "";
  for($i=0;$i<count($sids);$i++)
  {
    $sid = (int)$sids[$i];

    $res = $GLOBALS['db']->GetRow("SELECT sid, ip, port FROM ".DB_PREFIX."_servers WHERE sid = $sid");
    if(empty($res[1]) || empty($res[2]))
      return $objResponse;
    $info = array();
    $sinfo = new CServerControl(intval($GLOBALS['config']['gamecache.enabled']) == 1);
    $sinfo->Connect($res[1], $res[2]);
    $info = $sinfo->GetInfo();

    if($info)
      $ret .= trunc($info['HostName'], 48, false) . "<br />";
    else
      $ret .= "<b>Connection error</b> (<i>" . $res[1] . ":" . $res[2]. "</i>) <br />";
    
  }

  if($type=="id")
  {
    $objResponse->addAssign("$obId", "innerHTML", $ret);
  }
  else
  {
    $objResponse->addAssign("ban_server_$type", "innerHTML", $ret);
  }

  return $objResponse;
}


function ServerPlayers($sid)
{
  $objResponse = new xajaxResponse();

  $sid = (int)$sid;

  $res = $GLOBALS['db']->GetRow("SELECT sid, ip, port FROM ".DB_PREFIX."_servers WHERE sid = $sid");
  if(empty($res[1]) || empty($res[2]))
  {
    $objResponse->addAlert('IP or port not defined :o');
    return $objResponse;
  }
  $info = array();
  $sinfo = new CServerControl(intval($GLOBALS['config']['gamecache.enabled']) == 1);
  $sinfo->Connect($res[1], $res[2]);
  $info = $sinfo->GetPlayers();

  $html = "";
  if(empty($info))
    return $objResponse;
  foreach($info AS $player) {
    $html .= '<tr> <td class="listtable_1">'.htmlentities($player['Name']).'</td>
            <td class="listtable_1">'.(int)$player['Frags'].'</td>
            <td class="listtable_1">'.$player['TimeF'].'</td>
          </tr>';
  }
  $objResponse->addAssign("player_detail_$sid", "innerHTML", $html);
  //$objResponse->addScript("document.getElementById('player_detail_$sid').innerHTML = 'hi';");
  $objResponse->addScript("setTimeout('xajax_ServerPlayers($sid)', 5000);");
  $objResponse->addScript("$('opener_$sid').setProperty('onclick', '');");
  return $objResponse;
}

function KickPlayer($sid, $name)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  $sid = (int)$sid;
  
  //$objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
    
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_ADD_BAN))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried kick ".htmlspecialchars($name).", with no permission.");
    return $objResponse;
  }

  //get the server data
  $data = $GLOBALS['db']->GetRow("SELECT ip, port, rcon FROM ".DB_PREFIX."_servers WHERE sid = '".$sid."';");
  if(empty($data['rcon'])) {
    $objResponse->addScript("ShowBox('Error', 'Cannot kick ".addslashes(htmlspecialchars($name)).". RCON password not given!', 'red', '', true);");
    return $objResponse;
  }
  
  $r = new CServerControl(intval($GLOBALS['config']['gamecache.enabled']) == 1);
  $r->Connect($data['ip'], $data['port']);

  if(!$r->AuthRcon($data['rcon']))
  {
    $GLOBALS['db']->Execute("UPDATE ".DB_PREFIX."_servers SET rcon = '' WHERE sid = '".$sid."';");
    $objResponse->addScript("ShowBox('Error', 'Cannot kick ".addslashes(htmlspecialchars($name)).". Incorrect RCON password!', 'red', '', true);");
    return $objResponse;
  }
  // search for the playername
  $ret = $r->SendCommand("status");
  $search = preg_match_all(STATUS_PARSE,$ret,$matches,PREG_PATTERN_ORDER);
  $i = 0;
  $found = false;
  $index = -1;
  foreach($matches[2] AS $match) {
    if($match == $name) {
      $found = true;
      $index = $i;
      break;
    }
    $i++;
  }
  if($found) {
    $steam = $matches[3][$index];
    $steam2 = $steam;
    // Hack to support steam3 [U:1:X] representation.
    if(strpos($steam, "[U:") === 0) {
      $steam2 = renderSteam2(getAccountId($steam), 0);
    }
    // check for immunity
    $admin = $GLOBALS['db']->GetRow("SELECT a.immunity AS pimmune, g.immunity AS gimmune FROM `".DB_PREFIX."_admins` AS a LEFT JOIN `".DB_PREFIX."_srvgroups` AS g ON g.name = a.srv_group WHERE authid = '".$steam2."' LIMIT 1;");
    if($admin && $admin['gimmune']>$admin['pimmune'])
      $immune = $admin['gimmune'];
    elseif($admin)
      $immune = $admin['pimmune'];
    else
      $immune = 0;

    if($immune <= $userbank->GetProperty('srv_immunity')) {
      $requri = substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], ".php")+4);
      
      if(strpos($steam, "[U:") === 0) {
        $kick = $r->sendCommand("kickid \"".$steam."\" \"You have been kicked from the server. Go to address http://" . $_SERVER['HTTP_HOST'].$requri." for more information.\"");
      } else {
        $kick = $r->sendCommand("kickid ".$steam." \"You have been kicked from the server. Go to address http://" . $_SERVER['HTTP_HOST'].$requri." for more information.\"");
      }

      $log = new CSystemLog("m", "Player kicked", $username . " kicked player '".htmlspecialchars($name)."' (".$steam.") from ".$data['ip'].":".$data['port'].".", true, true);
      $objResponse->addScript("ShowBox('Player kicked', 'Player \'".addslashes(htmlspecialchars($name))."\' has been kicked from server.', 'green', 'index.php?p=servers', 1500);$('dialog-control').setStyle('display', 'none');");
    } else {
      $objResponse->addScript("ShowBox('Error', 'Cannot kick ".addslashes(htmlspecialchars($name)).". He have immunity!', 'red', '', true);");
    }
  } else {
    $objResponse->addScript("ShowBox('Error', 'Cannot kick ".addslashes(htmlspecialchars($name)).". Player left server!', 'red', '', true);");
  }
  return $objResponse;
}

function AddBan($nickname, $type, $steam, $ip, $length, $dfile, $dname, $reason, $fromsub, $udemo=false)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_ADD_BAN))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to add ban, with no permission.");
    return $objResponse;
  }
  
  $steam = trim($steam);
  
  $error = 0;
  // If they didnt type a steamid
  if(empty($steam) && $type == 0)
  {
    $error++;
    $objResponse->addAssign("steam.msg", "innerHTML", "Enter STEAM ID");
    $objResponse->addScript("$('steam.msg').setStyle('display', 'block');");
  }
  else if(($type == 0 
  && !is_numeric($steam) 
  && !validate_steam($steam))
  || (is_numeric($steam) 
  && (strlen($steam) < 15
  || !validate_steam($steam = FriendIDToSteamID($steam)))))
  {
    $error++;
    $objResponse->addAssign("steam.msg", "innerHTML", "Enter valid STEAM ID");
    $objResponse->addScript("$('steam.msg').setStyle('display', 'block');");
  }
  else if (empty($ip) && $type == 1)
  {
    $error++;
    $objResponse->addAssign("ip.msg", "innerHTML", "Enter IP");
    $objResponse->addScript("$('ip.msg').setStyle('display', 'block');");
  }
  else if($type == 1 && !validate_ip($ip))
  {
    $error++;
    $objResponse->addAssign("ip.msg", "innerHTML", "Enter real IP");
    $objResponse->addScript("$('ip.msg').setStyle('display', 'block');");
  }
  else
  {
    $objResponse->addAssign("steam.msg", "innerHTML", "");
    $objResponse->addScript("$('steam.msg').setStyle('display', 'none');");
    $objResponse->addAssign("ip.msg", "innerHTML", "");
    $objResponse->addScript("$('ip.msg').setStyle('display', 'none');");
  }
  if ($udemo && ! checkdnsrr($udemo,'A') && ! @get_headers($udemo, 1)){
    $error++;
    $objResponse->addAssign("demo_link.msg", "innerHTML", "Enter a valid URL to the demo file, or leave it blank!");
    $objResponse->addScript("$('demo_link.msg').setStyle('display', 'block');");
  }
  
  if($error > 0)
    return $objResponse;

  $nickname = RemoveCode($nickname);
  $ip = preg_replace('#[^\d\.]#', '', $ip);//strip ip of all but numbers and dots
  $dname = RemoveCode($dname);
  $reason = RemoveCode($reason);
  if(!$length)
    $len = 0;
  else
    $len = $length*60;

  // prune any old bans
  PruneBans();
  if((int)$type==0) {
    // Check if the new steamid is already banned
    $chk = $GLOBALS['db']->GetRow("SELECT count(bid) AS count FROM ".DB_PREFIX."_bans WHERE authid = ? AND (length = 0 OR ends > UNIX_TIMESTAMP()) AND RemovedBy IS NULL AND type = '0'", array($steam));

    if(intval($chk[0]) > 0)
    {
      $objResponse->addScript("ShowBox('Error', 'SteamID: $steam already banned.', 'red', '', true);");
      return $objResponse;
    }
        
        // Check if player is immune
        $admchk = $userbank->GetAllAdmins();
        foreach($admchk as $admin)
            if($admin['authid'] == $steam && $userbank->GetProperty('srv_immunity') < $admin['srv_immunity'])
            {
                $objResponse->addScript("ShowBox('Error', 'SteamID: admin ".$admin['user']." ($steam) have immunity.', 'red', '', true);");
                return $objResponse;
            }
  }
  if((int)$type==1) {
    $chk = $GLOBALS['db']->GetRow("SELECT count(bid) AS count FROM ".DB_PREFIX."_bans WHERE ip = ? AND (length = 0 OR ends > UNIX_TIMESTAMP()) AND RemovedBy IS NULL AND type = '1'", array($ip));

    if(intval($chk[0]) > 0)
    {
      $objResponse->addScript("ShowBox('Error', 'This IP ($ip) already banned.', 'red', '', true);");
      return $objResponse;
    }
  }

  $pre = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_bans(created,type,ip,authid,name,ends,length,reason,aid,adminIp ) VALUES
                  (UNIX_TIMESTAMP(),?,?,?,?,(UNIX_TIMESTAMP() + ?),?,?,?,?)");
  $GLOBALS['db']->Execute($pre,array($type,
                     $ip,
                     $steam,
                     $nickname,
                     $length*60,
                     $len,
                     $reason,
                     $userbank->GetAid(),
                     $_SERVER['REMOTE_ADDR']));
  $subid = $GLOBALS['db']->Insert_ID();

  if($dname && $dfile && preg_match('/^[a-z0-9]*$/i', $dfile))
  //Thanks jsifuentes: http://jacobsifuentes.com/sourcebans-1-4-lfi-exploit/
  //Official Fix: https://code.google.com/p/sourcebans/source/detail?r=165
  {
    $GLOBALS['db']->Execute("INSERT INTO ".DB_PREFIX."_demos(demid,demtype,filename,origname)
                 VALUES(?,'B', ?, ?)", array((int)$subid, $dfile, $dname));
  }elseif(!$dname && !$dfile && $udemo){
    $GLOBALS['db']->Execute("INSERT INTO ".DB_PREFIX."_demos(demid,demtype,filename,origname)
                 VALUES(?,'U', '', ?)", array((int)$subid, $udemo));
  }
  if($fromsub) {
    $submail = $GLOBALS['db']->Execute("SELECT name, email FROM ".DB_PREFIX."_submissions WHERE subid = '" . (int)$fromsub . "'");
    // Send an email when ban is accepted
    $requri = substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], ".php")+4);
    $headers = 'From: submission@' . $_SERVER['HTTP_HOST'] . "\n" .
    'X-Mailer: PHP/' . phpversion();

    $message = "Hello,\n";
    $message .= "Your ban application has been confirmed by the admin.\nFollow the link to watch the banlist.\n\nhttp://" . $_SERVER['HTTP_HOST'] . $requri . "?p=banlist";

    EMail($submail->fields['email'], "[SourceBans] Ban added", $message, $headers);
    $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_submissions` SET archiv = '2', archivedby = '".$userbank->GetAid()."' WHERE subid = '" . (int)$fromsub . "'");
  }

  $GLOBALS['db']->Execute("UPDATE `".DB_PREFIX."_submissions` SET archiv = '3', archivedby = '".$userbank->GetAid()."' WHERE SteamId = ?;", array($steam));

  $kickit = isset($GLOBALS['config']['config.enablekickit']) && $GLOBALS['config']['config.enablekickit'] == "1";
  if ($kickit)
    $objResponse->addScript("ShowKickBox('".((int)$type==0?$steam:$ip)."', '".(int)$type."');");
  else
    $objResponse->addScript("ShowBox('Ban added', 'Ban successfully added', 'green', 'index.php?p=admin&c=bans');");

  $objResponse->addScript("TabToReload();");
  $log = new CSystemLog("m", "Ban added", "Ban against (" . ((int)$type==0?$steam:$ip) . ") has been added, reason: $reason, length: $length", true, $kickit);
  return $objResponse;
}

function SetupBan($subid)
{
  $objResponse = new xajaxResponse();
  $subid = (int)$subid;

  $ban = $GLOBALS['db']->GetRow("SELECT * FROM ".DB_PREFIX."_submissions WHERE subid = $subid");
  $demo = $GLOBALS['db']->GetRow("SELECT * FROM ".DB_PREFIX."_demos WHERE demid = $subid AND demtype = \"S\"");
  // clear any old stuff
  $objResponse->addScript("$('nickname').value = ''");
  $objResponse->addScript("$('fromsub').value = ''");
  $objResponse->addScript("$('steam').value = ''");
  $objResponse->addScript("$('ip').value = ''");
  $objResponse->addScript("$('txtReason').value = ''");
  $objResponse->addAssign("demo.msg", "innerHTML",  "");
  // add new stuff
  $objResponse->addScript("$('nickname').value = '" . $ban['name'] . "'");
  $objResponse->addScript("$('steam').value = '" . $ban['SteamId']. "'");
  $objResponse->addScript("$('ip').value = '" . $ban['sip'] . "'");
  if(trim($ban['SteamId']) == "")
    $type = "1";
  else
    $type = "0";
  $objResponse->addScriptCall("selectLengthTypeReason", "0", $type, addslashes($ban['reason']));

  $objResponse->addScript("$('fromsub').value = '$subid'");
  if($demo)
  {
    $objResponse->addAssign("demo.msg", "innerHTML",  $demo['origname']);
    $objResponse->addScript("demo('" . $demo['filename'] . "', '" . $demo['origname'] . "');");
  }
  $objResponse->addScript("SwapPane(0);");
  return $objResponse;
}

function PrepareReban($bid)
{
  $objResponse = new xajaxResponse();
  $bid = (int)$bid;

  $ban = $GLOBALS['db']->GetRow("SELECT type, ip, authid, name, length, reason FROM ".DB_PREFIX."_bans WHERE bid = '".$bid."';");
  $demo = $GLOBALS['db']->GetRow("SELECT * FROM ".DB_PREFIX."_demos WHERE demid = '".$bid."' AND demtype = \"B\";");
  // clear any old stuff
  $objResponse->addScript("$('nickname').value = ''");
  $objResponse->addScript("$('ip').value = ''");
  $objResponse->addScript("$('fromsub').value = ''");
  $objResponse->addScript("$('steam').value = ''");
  $objResponse->addScript("$('txtReason').value = ''");
  $objResponse->addAssign("demo.msg", "innerHTML",  "");
  $objResponse->addAssign("txtReason", "innerHTML",  "");

  // add new stuff
  $objResponse->addScript("$('nickname').value = '" . $ban['name'] . "'");
  $objResponse->addScript("$('steam').value = '" . $ban['authid']. "'");
  $objResponse->addScript("$('ip').value = '" . $ban['ip']. "'");
  $objResponse->addScriptCall("selectLengthTypeReason", $ban['length'], $ban['type'], addslashes($ban['reason']));

  if($demo)
  {
    $objResponse->addAssign("demo.msg", "innerHTML",  $demo['origname']);
    $objResponse->addScript("demo('" . $demo['filename'] . "', '" . $demo['origname'] . "');");
  }
  $objResponse->addScript("SwapPane(0);");
  return $objResponse;
}

function SetupEditServer($sid)
{
  $objResponse = new xajaxResponse();
  $sid = (int)$sid;
  $server = $GLOBALS['db']->GetRow("SELECT * FROM ".DB_PREFIX."_servers WHERE sid = $sid");

  // clear any old stuff
  $objResponse->addScript("$('address').value = ''");
  $objResponse->addScript("$('port').value = ''");
  $objResponse->addScript("$('rcon').value = ''");
  $objResponse->addScript("$('rcon2').value = ''");
  $objResponse->addScript("$('mod').value = '0'");
  $objResponse->addScript("$('serverg').value = '0'");


  // add new stuff
  $objResponse->addScript("$('address').value = '" . $server['ip']. "'");
  $objResponse->addScript("$('port').value =  '" . $server['port']. "'");
  $objResponse->addScript("$('rcon').value =  '" . $server['rcon']. "'");
  $objResponse->addScript("$('rcon2').value =  '" . $server['rcon']. "'");
  $objResponse->addScript("$('mod').value =  " . $server['modid']);
  $objResponse->addScript("$('serverg').value =  " . $server['gid']);

  $objResponse->addScript("$('insert_type').value =  " . $server['sid']);
  $objResponse->addScript("SwapPane(1);");
  return $objResponse;
}

function CheckPassword($aid, $pass)
{
  $objResponse = new xajaxResponse();
  global $userbank;
  $aid = (int)$aid;
  if(!$userbank->CheckLogin($userbank->encrypt_password($pass), $aid))
  {
    $objResponse->addScript("$('current.msg').setStyle('display', 'block');");
    $objResponse->addScript("$('current.msg').setHTML('<div class=\"c-red\">The data does not match</div>');");
    $objResponse->addScript("set_error(1);");

  }
  else
  {
    $objResponse->addScript("$('current.msg').setStyle('display', 'none');");
    $objResponse->addScript("set_error(0);");
  }
  return $objResponse;
}

function ChangeAdminsInfos($aid, $vk, $skype)
{
  global $userbank;
  $objResponse = new xajaxResponse();
  $aid = (int)$aid;

  if($aid != $userbank->aid && !$userbank->is_logged_in())
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $_SERVER["REMOTE_ADDR"] . " tried change instagram or skype, with no permission.");
    return $objResponse;
  }

  $vk = RemoveCode($vk);
  $vk = str_replace(array("http://","https://","/","instagram.com"), "", $vk);
  $skype = RemoveCode($skype);
  
  $GLOBALS['db']->Execute("UPDATE `".DB_PREFIX."_admins` SET `vk` = '".$vk."', `skype` = '".$skype."' WHERE `aid` = ?", array((int)$aid));
  $admname = $GLOBALS['db']->GetRow("SELECT user FROM `".DB_PREFIX."_admins` WHERE aid = ?", array((int)$aid));
  $objResponse->addScript("ShowBox('Info', 'Your info successfully updated!', 'green', 'index.php?p=account');");
  $log = new CSystemLog("m", "Contact info updated", "Admin ".$admname['user']." updated contact info (ig: ".$vk.", skype: ".$skype.")");
  return $objResponse;
}
function ChangePassword($aid, $pass)
{
  global $userbank;
  $objResponse = new xajaxResponse();
  $aid = (int)$aid;

  if($aid != $userbank->aid && !$userbank->HasAccess(ADMIN_OWNER|ADMIN_EDIT_ADMINS))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $_SERVER["REMOTE_ADDR"] . " tried to change password, with no permission.");
    return $objResponse;
  }

  $GLOBALS['db']->Execute("UPDATE `".DB_PREFIX."_admins` SET `password` = '" . $userbank->encrypt_password($pass) . "' WHERE `aid` = $aid");
  $admname = $GLOBALS['db']->GetRow("SELECT user FROM `".DB_PREFIX."_admins` WHERE aid = ?", array((int)$aid));
  $objResponse->addAlert("Password successfully changed");
  $objResponse->addRedirect("index.php?p=login", 0);
  $log = new CSystemLog("m", "Password changed", "Admin (".$admname['user'].") changed password");
  return $objResponse;
}

function AddMod($name, $folder, $icon, $steam_universe, $enabled)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_ADD_MODS))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried add MOD, with no permission.");
    return $objResponse;
  }
  $name = htmlspecialchars(strip_tags($name));//don't want to addslashes because execute will automatically do it
  $icon = htmlspecialchars(strip_tags($icon));
  $folder = htmlspecialchars(strip_tags($folder));
  $steam_universe = (int)$steam_universe;
  $enabled = ($enabled == "on") ? 1 : 0;
  
  // Already there?
  $check = $GLOBALS['db']->GetRow("SELECT * FROM `" . DB_PREFIX . "_mods` WHERE modfolder = ? OR name = ?;", array($folder, $name));
  if(!empty($check))
  {
    $objResponse->addScript("ShowBox('MOD not added', 'MOD with this name or folder already exists.', 'red');");
    return $objResponse;
  }

  $pre = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_mods(name,icon,modfolder,steam_universe,enabled) VALUES (?,?,?,?,?)");
  $GLOBALS['db']->Execute($pre,array($name, $icon, $folder, $steam_universe, $enabled));

  $objResponse->addScript("ShowBox('MOD added', 'Game MOD successfully added', 'green', 'index.php?p=admin&c=mods');");
  $objResponse->addScript("TabToReload();");
  $log = new CSystemLog("m", "MOD added", "The MOD ($name) has been added");
  return $objResponse;
}

function EditAdminPerms($aid, $web_flags, $srv_flags)
{
  if(empty($aid))
    return;
  $aid = (int)$aid;
  $web_flags = (int)$web_flags;

  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_EDIT_ADMINS))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to edit admin permissions, with no permission.");
    return $objResponse;
  }

  if(!$userbank->HasAccess(ADMIN_OWNER) && (int)$web_flags & ADMIN_OWNER )
  {
      $objResponse->redirect("index.php?p=login&m=no_access", 0);
      $log = new CSystemLog("w", "Hacking attempt", $username . " tried to edit Root admin permissions, with no permission.");
      return $objResponse;
  }

  // Users require a password and email to have web permissions
  $password = $GLOBALS['userbank']->GetProperty('password', $aid);
  $email = $GLOBALS['userbank']->GetProperty('email', $aid);
  if($web_flags > 0 && (empty($password) || empty($email)))
  {
    $objResponse->addScript("ShowBox('Error', 'Admin must enter E-mail and password to get access rights to the site.<br /><a href=\"index.php?p=admin&c=admins&o=editdetails&id=" . $aid . "\" title=\"Edit admin details\">Edit admin details</a> agin or try later.', 'red', '');");
    return $objResponse;
  }
  
  // Update web stuff
  $GLOBALS['db']->Execute("UPDATE `".DB_PREFIX."_admins` SET `extraflags` = $web_flags WHERE `aid` = $aid");


  if(strstr($srv_flags, "#"))
  {
    $immunity = "0";
    $immunity = substr($srv_flags, strpos($srv_flags, "#")+1);
    $srv_flags = substr($srv_flags, 0, strlen($srv_flags) - strlen($immunity)-1);
  }
  $immunity = ($immunity>0) ? $immunity : 0;
  // Update server stuff
  $GLOBALS['db']->Execute("UPDATE `".DB_PREFIX."_admins` SET `srv_flags` = ?, `immunity` = ? WHERE `aid` = $aid", array($srv_flags, $immunity));

  if(isset($GLOBALS['config']['config.enableadminrehashing']) && $GLOBALS['config']['config.enableadminrehashing'] == 1)
  {
    // rehash the admins on the servers
    $serveraccessq = $GLOBALS['db']->GetAll("SELECT s.sid FROM `".DB_PREFIX."_servers` s
                        LEFT JOIN `".DB_PREFIX."_admins_servers_groups` asg ON asg.admin_id = '".(int)$aid."'
                        LEFT JOIN `".DB_PREFIX."_servers_groups` sg ON sg.group_id = asg.srv_group_id
                        WHERE ((asg.server_id != '-1' AND asg.srv_group_id = '-1')
                        OR (asg.srv_group_id != '-1' AND asg.server_id = '-1'))
                        AND (s.sid IN(asg.server_id) OR s.sid IN(sg.server_id)) AND s.enabled = 1");
    $allservers = array();
    foreach($serveraccessq as $access) {
      if(!in_array($access['sid'], $allservers)) {
        $allservers[] = $access['sid'];
      }
    }
    $objResponse->addScript("ShowRehashBox('".implode(",", $allservers)."', 'Permissions updated', 'User permissions updated', 'green', 'index.php?p=admin&c=admins');TabToReload();");
  } else
    $objResponse->addScript("ShowBox('Permissions updated', 'User permissions updated', 'green', 'index.php?p=admin&c=admins');TabToReload();");
  $admname = $GLOBALS['db']->GetRow("SELECT user FROM `".DB_PREFIX."_admins` WHERE aid = ?", array((int)$aid));
    $log = new CSystemLog("m", "Permissions updated", "Permissions updated for (".$admname['user'].")");
  return $objResponse;
}

function EditGroup($gid, $web_flags, $srv_flags, $type, $name, $overrides, $newOverride)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_EDIT_GROUPS))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to edit group details, with no permission.");
    return $objResponse;
  }
  
  if(empty($name))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried remove group name. Group must contain a name.");
    return $objResponse;
  }
  
  $gid = (int)$gid;
  $name = RemoveCode($name);
  $web_flags = (int)$web_flags;
  if($type == "web" || $type == "server" )
  // Update web stuff
  $GLOBALS['db']->Execute("UPDATE `".DB_PREFIX."_groups` SET `flags` = ?, `name` = ? WHERE `gid` = $gid", array($web_flags, $name));

  if($type == "srv")
  {
    $gname = $GLOBALS['db']->GetRow("SELECT name FROM ".DB_PREFIX."_srvgroups WHERE id = $gid");

    if(strstr($srv_flags, "#"))
    {
      $immunity = 0;
      $immunity = substr($srv_flags, strpos($srv_flags, "#")+1);
      $srv_flags = substr($srv_flags, 0, strlen($srv_flags) - strlen($immunity)-1);
    }
    $immunity = ($immunity>0) ? $immunity : 0;

    // Update server stuff
    $GLOBALS['db']->Execute("UPDATE `".DB_PREFIX."_srvgroups` SET `flags` = ?, `name` = ?, `immunity` = ? WHERE `id` = $gid", array($srv_flags, $name, $immunity));

    $oldname = $GLOBALS['db']->GetAll("SELECT aid FROM ".DB_PREFIX."_admins WHERE srv_group = ?", array($gname['name']));
    foreach($oldname as $o)
    {
      $GLOBALS['db']->Execute("UPDATE `".DB_PREFIX."_admins` SET `srv_group` = ? WHERE `aid` = '" . (int)$o['aid'] . "'", array($name));
    }
    
    // Update group overrides
    if(!empty($overrides))
    {
      foreach($overrides as $override)
      {
        // Skip invalid stuff?!
        if($override['type'] != "command" && $override['type'] != "group")
          continue;
      
        $id = (int)$override['id'];
        // Wants to delete this override?
        if(empty($override['name']))
        {
          $GLOBALS['db']->Execute("DELETE FROM `" . DB_PREFIX . "_srvgroups_overrides` WHERE id = ?;", array($id));
          continue;
        }
        
        // Check for duplicates
        $chk = $GLOBALS['db']->GetAll("SELECT * FROM `" . DB_PREFIX . "_srvgroups_overrides` WHERE name = ? AND type = ? AND group_id = ? AND id != ?", array($override['name'], $override['type'], $gid, $id));
        if(!empty($chk))
        {
          $objResponse->addScript("ShowBox('Error', 'Override with this name already exists \\\"" . htmlspecialchars(addslashes($override['name'])) . "\\\" for selected type..', 'red', '', true);");
          return $objResponse;
        }
        
        // Edit the override
        $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_srvgroups_overrides` SET name = ?, type = ?, access = ? WHERE id = ?;", array($override['name'], $override['type'], $override['access'], $id));
      }
    }
    
    // Add a new override
    if(!empty($newOverride))
    {
      if(($newOverride['type'] == "command" || $newOverride['type'] == "group") && !empty($newOverride['name']))
      {
        // Check for duplicates
        $chk = $GLOBALS['db']->GetAll("SELECT * FROM `" . DB_PREFIX . "_srvgroups_overrides` WHERE name = ? AND type = ? AND group_id = ?", array($newOverride['name'], $newOverride['type'], $gid));
        if(!empty($chk))
        {
          $objResponse->addScript("ShowBox('Error', 'Override with this name already exists \\\"" . htmlspecialchars(addslashes($newOverride['name'])) . "\\\" for selected type..', 'red', '', true);");
          return $objResponse;
        }
        
        // Insert the new override
        $GLOBALS['db']->Execute("INSERT INTO `" . DB_PREFIX . "_srvgroups_overrides` (group_id, type, name, access) VALUES (?, ?, ?, ?);", array($gid, $newOverride['type'], $newOverride['name'], $newOverride['access']));
      }
    }
    
    if(isset($GLOBALS['config']['config.enableadminrehashing']) && $GLOBALS['config']['config.enableadminrehashing'] == 1)
    {
      // rehash the settings out of the database on all servers
      $serveraccessq = $GLOBALS['db']->GetAll("SELECT sid FROM ".DB_PREFIX."_servers WHERE enabled = 1;");
      $allservers = array();
      foreach($serveraccessq as $access) {
        if(!in_array($access['sid'], $allservers)) {
          $allservers[] = $access['sid'];
        }
      }
      $objResponse->addScript("ShowRehashBox('".implode(",", $allservers)."', 'Group updated', 'Group successfully updated', 'green', 'index.php?p=admin&c=groups');TabToReload();");
    } else
      $objResponse->addScript("ShowBox('Group updated', 'Group successfully updated', 'green', 'index.php?p=admin&c=groups');TabToReload();");
    $log = new CSystemLog("m", "Group updated", "Group ($name) has been updated");
    return $objResponse;
  }

  $objResponse->addScript("ShowBox('Group updated', 'Group successfully updated', 'green', 'index.php?p=admin&c=groups');TabToReload();");
  $log = new CSystemLog("m", "Group updated", "Group ($name) has been updated");
  return $objResponse;
}


function SendRcon($sid, $command, $output)
{
  global $userbank, $username;
  $objResponse = new xajaxResponse();
  if(!$userbank->HasAccess(SM_RCON . SM_ROOT))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to send RCON command, with no permission.");
    return $objResponse;
  }
  if(empty($command))
  {
    $objResponse->addScript("$('cmd').value=''; $('cmd').disabled='';$('rcon_btn').disabled=''");
    return $objResponse;
  }
  if($command == "clr")
  {
    $objResponse->addAssign("rcon_con", "innerHTML",  "<div class='lv-item media'><div class='lv-avatar bgm-red pull-left'>R</div><div class='media-body'><div class='ms-item' style='display: block;max-width: 100%;'>************************************************************<br />*&nbsp;SourceBans RCON Console<br />*&nbsp;Type command below and then press Enter<br />*&nbsp;Type 'clr' to clear console<br />************************************************************</div></div></div>");
    $objResponse->addScript("scroll.toBottom(); $('cmd').value=''; $('cmd').disabled='';$('rcon_btn').disabled=''");
    return $objResponse;
  }
    
    if(stripos($command, "rcon_password") !== false)
  {
        $objResponse->addAppend("rcon_con", "innerHTML",  "<div class='lv-item media p-b-5 p-t-5'><div class='lv-avatar bgm-red pull-left'>R</div><div class='media-body'><div class='ms-item' style='display: block;max-width: 100%;'> > Error: You are using console. Do not try to guess RCON password!</div></div></div>");
    $objResponse->addScript("scroll.toBottom(); $('cmd').value=''; $('cmd').disabled='';$('rcon_btn').disabled=''");
    return $objResponse;
  }
    
  $sid = (int)$sid;
    
  $rcon = $GLOBALS['db']->GetRow("SELECT ip, port, rcon FROM `".DB_PREFIX."_servers` WHERE sid = ".$sid." LIMIT 1");
  if(empty($rcon['rcon']))
  {
    $objResponse->addAppend("rcon_con", "innerHTML", "<div class='lv-item media p-b-5 p-t-5'><div class='lv-avatar bgm-red pull-left'>R</div><div class='media-body'><div class='ms-item' style='display: block;max-width: 100%;'> > Error: No RCON password!<br />You must add the RCON password for this server on the 'edit servers' page <br /> to use the console!</div></div></div>");
    $objResponse->addScript("scroll.toBottom(); $('cmd').value='Set RCON password.'; $('cmd').disabled=true; $('rcon_btn').disabled=true");
    return $objResponse;
  }
    if(!$test = @fsockopen($rcon['ip'], $rcon['port'], $errno, $errstr, 2))
    {
        @fclose($test);
    $objResponse->addAppend("rcon_con", "innerHTML", "<div class='lv-item media p-b-5 p-t-5'><div class='lv-avatar bgm-red pull-left'>R</div><div class='media-body'><div class='ms-item' style='display: block;max-width: 100%;'> > Error: cannot connect with server!</div></div></div>");
    $objResponse->addScript("scroll.toBottom(); $('cmd').value=''; $('cmd').disabled='';$('rcon_btn').disabled=''");
    return $objResponse;
  }
    @fclose($test);
  
  $r = new CServerControl(intval($GLOBALS['config']['gamecache.enabled']) == 1);
  $r->Connect($rcon['ip'], $rcon['port']);
  
  if(!$r->AuthRcon($rcon['rcon']))
  {
    $GLOBALS['db']->Execute("UPDATE ".DB_PREFIX."_servers SET rcon = '' WHERE sid = '".$sid."';");
    $objResponse->addAppend("rcon_con", "innerHTML", "<div class='lv-item media p-b-5 p-t-5'><div class='lv-avatar bgm-red pull-left'>R</div><div class='media-body'><div class='ms-item' style='display: block;max-width: 100%;'> > Error: incorrect RCON!<br />You must change the RKON password for this server. <br /> If you continue to use the console with an incorrect RKON password, the server will block the connection!</div></div></div>");
    $objResponse->addScript("scroll.toBottom(); $('cmd').value='Change RCON password.'; $('cmd').disabled=true; $('rcon_btn').disabled=true");
    return $objResponse;
  }
  $ret = $r->SendCommand($command);


  $textAppend = "<div class='lv-item media right p-b-5 p-t-5'><div class='lv-avatar bgm-orange pull-right'><img src='".GetUserAvatar($userbank->getProperty("authid"))."' /></div><div class='media-body'><div class='ms-item'> $command </div><small class='ms-date'><i class='zmdi zmdi-time'></i> ".date("d/m/Y at H:i")."</small></div></div>";
  $ret = str_replace("\n", "<br />", $ret);
  if(empty($ret))
  {
    if($output)
    {
      //$objResponse->addAppend("rcon_con", "innerHTML",  "-> $command<br />");
      //$objResponse->addAppend("rcon_con", "innerHTML",  "Command sent.<br />");
      $textAppend .= "<div class='lv-item media p-b-5 p-t-5'><div class='lv-avatar bgm-red pull-left'>R</div><div class='media-body'><div class='ms-item' style='display: block;max-width: 100%;'> The command was sent, but there was no response... :C </div></div></div>";
    }
  }
  else
  {
    if($output)
    {
      //$objResponse->addAppend("rcon_con", "innerHTML",  "-> $command<br />");
      //$objResponse->addAppend("rcon_con", "innerHTML",  "$ret<br />");
      $textAppend .= "<div class='lv-item media p-b-5 p-t-5'><div class='lv-avatar bgm-red pull-left'>R</div><div class='media-body'><div class='ms-item' style='display: block;max-width: 100%;'> $ret </div></div></div>";
    }
  }
  $objResponse->addAppend("rcon_con", "innerHTML", $textAppend);
  $objResponse->addScript("scroll.toBottom(); $('cmd').value=''; $('cmd').disabled=''; $('rcon_btn').disabled=''");
  $log = new CSystemLog("m", "RCON sent", "RCON sent to server (".$rcon['ip'].":".$rcon['port']."). Command: $command", true, true);
  return $objResponse;
}


function SendMail($subject, $message, $type, $id)
{
  $objResponse = new xajaxResponse();
    global $userbank, $username;
  
  $id = (int)$id;
  
    if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_BAN_PROTESTS|ADMIN_BAN_SUBMISSIONS))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to send e-mail, with no permission.");
    return $objResponse;
  }
  
  // Don't mind wrong types
  if($type != 's' && $type != 'p')
  {
    return $objResponse;
  }
  
  // Submission
  $email = "";
  if($type == 's')
  {
    $email = $GLOBALS['db']->GetOne('SELECT email FROM `'.DB_PREFIX.'_submissions` WHERE subid = ?', array($id));
  }
  // Protest
  else if($type == 'p')
  {
    $email = $GLOBALS['db']->GetOne('SELECT email FROM `'.DB_PREFIX.'_protests` WHERE pid = ?', array($id));
  }
  
  if(empty($email))
  {
    $objResponse->addScript("ShowBox('Error', 'E-mail not choosed..', 'red', 'index.php?p=admin&c=bans');");
    return $objResponse;
  }
  
  $headers = "From: noreply@" . $_SERVER['HTTP_HOST'] . "\n" . 'X-Mailer: PHP/' . phpversion();
  $m = @EMail($email, '[SourceBans] ' . $subject, $message, $headers);

  
  if($m)
  {
    $objResponse->addScript("ShowBox('E-mail sent', 'E-mail sent succesfully.', 'green', 'index.php?p=admin&c=bans');");
    $log = new CSystemLog("m", "E-mail sent", $username . " sent e-mail to ".htmlspecialchars($email).".<br />Subject: '[SourceBans] " . htmlspecialchars($subject) . "'<br />Message: '" . nl2br(htmlspecialchars($message)) . "'");
  }
  else
    $objResponse->addScript("ShowBox('Error', 'Failed to send e-mail.', 'red', '');");
  
  return $objResponse;
}

function AddComment($bid, $ctype, $ctext, $page)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->is_admin())
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried add comment, with no permission.");
    return $objResponse;
  }
  
  $bid = (int)$bid;
  $page = (int)$page;
  
  $pagelink = "";
  if($page != -1)
    $pagelink = "&page=".$page;
    
  if($ctype=="B")
    $redir = "?p=banlist".$pagelink;
  elseif($ctype=="C")
    $redir = "?p=commslist".$pagelink;
  elseif($ctype=="S")
    $redir = "?p=admin&c=bans#^2";
  elseif($ctype=="P")
    $redir = "?p=admin&c=bans#^1";
  else
  {
    $objResponse->addScript("ShowBox('Error', 'Bad comment type.', 'red');");
    return $objResponse;
  }

  $ctext = trim($ctext);

  $pre = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_comments(bid,type,aid,commenttxt,added) VALUES (?,?,?,?,UNIX_TIMESTAMP())");
  $GLOBALS['db']->Execute($pre,array($bid,
                     $ctype,
                     $userbank->GetAid(),
                     $ctext));

  $objResponse->addScript("ShowBox('Comment added', 'Comment published', 'green', 'index.php$redir');");
  $objResponse->addScript("TabToReload();");
  $log = new CSystemLog("m", "Comment added", $username."added comment to ban №".$bid);
  return $objResponse;
}

function EditComment($cid, $ctype, $ctext, $page)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->is_admin())
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to edit comment, with no permission.");
    return $objResponse;
  }

  $cid = (int)$cid;
  $page = (int)$page;
  
  $pagelink = "";
  if($page != -1)
    $pagelink = "&page=".$page;
  
  if($ctype=="B")
    $redir = "?p=banlist".$pagelink;
  elseif($ctype=="C")
    $redir = "?p=commslist".$pagelink;
  elseif($ctype=="S")
    $redir = "?p=admin&c=bans#^2";
  elseif($ctype=="P")
    $redir = "?p=admin&c=bans#^1";
  else
  {
    $objResponse->addScript("ShowBox('Error', 'Bad comment type.', 'red');");
    return $objResponse;
  }

  $ctext = trim($ctext);

  $pre = $GLOBALS['db']->Prepare("UPDATE ".DB_PREFIX."_comments SET `commenttxt` = ?, `editaid` = ?, `edittime`= UNIX_TIMESTAMP() WHERE cid = ?");
  $GLOBALS['db']->Execute($pre,array($ctext,
                     $userbank->GetAid(),
                     $cid));

  $objResponse->addScript("ShowBox('Comment edited', 'Комментарий №".$cid." successfully edited', 'green', 'index.php$redir');");
  $objResponse->addScript("TabToReload();");
  $log = new CSystemLog("m", "Comment edited", $username." edited comment №".$cid);
  return $objResponse;
}

function RemoveComment($cid, $ctype, $page)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if (!$userbank->HasAccess(ADMIN_OWNER))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to delete comment, with no permission.");
    return $objResponse;
  }

  $cid = (int)$cid;
  $page = (int)$page;
  
  $pagelink = "";
  if($page != -1)
    $pagelink = "&page=".$page;

  $res = $GLOBALS['db']->Execute("DELETE FROM `".DB_PREFIX."_comments` WHERE `cid` = ?",
                array( $cid ));
  if($ctype=="B")
    $redir = "?p=banlist".$pagelink;
  elseif($ctype=="C")
    $redir = "?p=commslist".$pagelink;
  else
    $redir = "?p=admin&c=bans";
  if($res)
  {
    $objResponse->addScript("ShowBox('Comment deleted', 'Comment successfully deleted from database', 'green', 'index.php$redir', true);");
    $log = new CSystemLog("m", "Comment deleted", $username." deleted comment №".$cid);
  }
  else
    $objResponse->addScript("ShowBox('Error', 'Error deleting comment. Check logs for more information', 'red', 'index.php$redir', true);");
  return $objResponse;
}

function Maintenance($type) {
    global $userbank, $username, $theme;
    
    $objResponse = new xajaxResponse();
    if (!$userbank->HasAccess(ADMIN_OWNER|ADMIN_WEB_SETTINGS)) {
        ShowBox_ajx("Error", "You are not authorized to perform this action!", "red", "", true, $objResponse);
        new CSystemLog("w", "Hacking attempt", $usernake . " tried to perform a system maintenance operation, with no permission.");
        return $objResponse;
    }
    
    switch($type) {
        case "themecache": {
            $theme->clear_compiled_tpl();
            ShowBox_ajx("Success", "Theme cache removed.", "green", "", true, $objResponse);
            break;
        }
        
        case "avatarcache": {
            $GLOBALS['db']->Execute(sprintf("TRUNCATE `%s_avatars`", DB_PREFIX));
            ShowBox_ajx("Success", "Avatar cache removed.", "green", "", true, $objResponse);
            break;
        }
    
        case 'adminsexpired': {
            $admins = $GLOBALS['db']->GetAll(sprintf("SELECT `aid` FROM `%s_admins` WHERE `expired` != 0 AND `expired` < %d;", DB_PREFIX, time()));
            foreach ($admins as $admin) {
                $aid = intval($admin['aid']);

                $GLOBALS['db']->Execute(sprintf("DELETE FROM `%s_admins` WHERE `aid` = %d;", DB_PREFIX, $aid));
                $GLOBALS['db']->Execute(sprintf("DELETE FROM `%s_admins_servers_groups` WHERE `admin_id` = %d;", DB_PREFIX, $aid));
            }
            ShowBox_ajx("Success", sprintf("Successfully removed %d admins.", count($admins)), "green", "", true, $objResponse);
            break;
        }

        case "bansexpired": {
            $GLOBALS['db']->Execute(sprintf("DELETE FROM `%s_bans` WHERE `RemoveType` IS NOT NULL", DB_PREFIX));
            ShowBox_ajx("Success", "Expired bans removed.", "green", "", true, $objResponse);
            break;
        }
        
        case "commsexpired": {
            $GLOBALS['db']->Execute(sprintf("DELETE FROM `%s_comms` WHERE `RemoveType` IS NOT NULL", DB_PREFIX));
            ShowBox_ajx("Success", "Expire dmutes removed.", "green", "", true, $objResponse);
            break;
        }
        
        case "optimizebd": {
            $tables = $GLOBALS['db']->GetAll("SHOW TABLES;");
            foreach ($tables as &$table)
                $GLOBALS['db']->Execute(sprintf("OPTIMIZE TABLE `%s`;", $table[0]));
            
            ShowBox_ajx("Success", "Optimization of tables completed.", "green", "", true, $objResponse);
            break;
        }
        
        case "cleancountrycache": {
            $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_bans` SET `country` = NULL;");
            ShowBox_ajx("Success", "Banlist country cache cleared.<br /><br /><span style=\"color: #f00;\">Warning!</span> This can adversely affect the first load of every page of your banlist. We recommend to perform the operation \"Update country cache on banlist\".", "green", "", true, $objResponse);
            break;
        }
        
        case "rehashcountries": {
            $bans = $GLOBALS['db']->GetAll("SELECT `bid`, `ip` FROM `" . DB_PREFIX . "_bans` WHERE `country` IS NULL or `country` = 'zz'");
            foreach ($bans as $ban) {
                $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_bans` SET `country` = " . $GLOBALS['db']->qstr(FetchIp($ban['ip'])) . " WHERE `bid` = " . (int)$ban['bid'] . ";");
            }
            
            ShowBox_ajx("Success", "Banlist country cache updated.", "green", "", true, $objResponse);
            break;
        }
        
        case "updatecountries": {
            if (!function_exists("zlib_decode")) {
                ShowBox_ajx("Error", "Unable to update GeoIP base: function is not available <em>gzuncompress</em>.", "red", "", true, $objResponse);
                return $objResponse;
            }
            
            $CountryFile = INCLUDES_PATH . '/IpToCountry.csv';
            if (@is_writable($CountryFile)) {
                file_put_contents($CountryFile, zlib_decode(file_get_contents("http://software77.net/geo-ip/?DL=1&x=Download")));
                ShowBox_ajx("Success", "GeoIP database file updated.", "green", "", true, $objResponse);
            } else
                ShowBox_ajx("Error", "Unable to update the GeoIP database: writing to the file <em> /includes/IpToCountry.csv </em> is prohibited. Set the rights <b> 777 </b> to the file <em>/includes/IpToCountry.csv</em>", "red", "", true, $objResponse);
            break;
        }
        
        case "warningsexpired": {
            $GLOBALS['db']->Execute(sprintf("DELETE FROM `%s_warns` WHERE `expires` < %d", DB_PREFIX, time()));
            ShowBox_ajx("Success", "All expired and cleared warnings have been successfully removed.", "green", "", true, $objResponse);
            break;
        }
        
        case "avatarupdate": {
            Maintenance("avatarcache");
            $users = $GLOBALS['db']->GetAll(sprintf("SELECT `authid` FROM `%s_admins`", DB_PREFIX));
            foreach ($users as &$user)
                GetUserAvatar($user['authid']);
            ShowBox_ajx("Success", "Administrator avatar cache has been updated.", "green", "", true, $objResponse);
            break;
        }
        
        case "commentsclean": {
            $GLOBALS['db']->Execute(sprintf("TRUNCATE `%s_comments`;", DB_PREFIX));
            ShowBox_ajx("Success", "All comments successfully deleted.", "green", "", true, $objResponse);
            break;
        }
        
        case "banlogclean": {
            $GLOBALS['db']->Execute(sprintf("TRUNCATE `%s_banlog`;", DB_PREFIX));
            ShowBox_ajx("Success", "The history of blocked connections to servers has been cleared successfully.", "green", "", true, $objResponse);
            break;
        }
        
        case "protests": {
            $GLOBALS['db']->Execute(sprintf("TRUNCATE `%s_protests`;", DB_PREFIX));
            ShowBox_ajx("Success", "Protests removed.", "green", "", true, $objResponse);
            break;
        }
        
        case "reports": {
            $GLOBALS['db']->Execute(sprintf("TRUNCATE `%s_submissions`;", DB_PREFIX));
            ShowBox_ajx("Success", "Ban submissions (reports) removed.", "green", "", true, $objResponse);
            break;
    }

    case "vouchers": {
      $GLOBALS['db']->Execute(sprintf("DELETE FROM `%s_vay4er` WHERE `activ` != 1", DB_PREFIX));
      ShowBox_ajx("Success", "All used Promokeys has been removed.", "green", "", true, $objResponse);
      break;
    }
        
        default: {
            ShowBox_ajx("Error", "Unknown operation", "red", "", true, $objResponse);
            break;
        }
    }
    
    return $objResponse;
}

function RefreshServer($sid)
{
  $objResponse = new xajaxResponse();
  $sid = (int)$sid;
  session_start();
  $data = $GLOBALS['db']->GetRow("SELECT ip, port FROM `".DB_PREFIX."_servers` WHERE sid = ?;", array($sid));
  if (isset($_SESSION['getInfo.' . $data['ip'] . '.' . $data['port']]) && is_array($_SESSION['getInfo.' . $data['ip'] . '.' . $data['port']]))
    unset($_SESSION['getInfo.' . $data['ip'] . '.' . $data['port']]);
  $objResponse->addScript("xajax_ServerHostPlayers('".$sid."');");
  return $objResponse;
}

function RehashAdmins_pay($server, $do=0, $card)
{
  $card = RemoveCode($card);
  $card = preg_replace("/[^0-9]/", "", $card);
  
  
  $wfr = $GLOBALS['db']->GetRow("SELECT * FROM `" . DB_PREFIX . "_vay4er` WHERE `value` = '".$card."'");
  if($wfr == "" || $wfr == "0" || $card == ""){
    exit();
  }
  $objResponse = new xajaxResponse();
    global $userbank, $username;
  $do = (int)$do;

  $servers = explode(",",$server);
  if(sizeof($servers)>0) {
    if(sizeof($servers)-1 > $do)
      $objResponse->addScriptCall("xajax_RehashAdmins_pay", $server, $do+1, $card);

    $serv = $GLOBALS['db']->GetRow("SELECT ip, port, rcon FROM ".DB_PREFIX."_servers WHERE sid = '".(int)$servers[$do]."';");
    if(empty($serv['rcon'])) {
      $objResponse->addAppend("rehashDiv", "innerHTML", "".$serv['ip'].":".$serv['port']." (".($do+1)."/".sizeof($servers).") <font color='red'>Error: RCON password not seted</font>.<br />");
      if($do >= sizeof($servers)-1) {
        $objResponse->addAppend("rehashDiv", "innerHTML", "<b>Done, redirecting....</b>");
        $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
        $objResponse->addScript("setTimeout(\"window.location = 'index.php';\", 1800);");
      }
      return $objResponse;
    }

    $test = @fsockopen($serv['ip'], $serv['port'], $errno, $errstr, 2);
    if(!$test) {
      $objResponse->addAppend("rehashDiv", "innerHTML", "".$serv['ip'].":".$serv['port']." (".($do+1)."/".sizeof($servers).") <font color='red'>Error: no connection</font>.<br />");
      if($do >= sizeof($servers)-1) {
        $objResponse->addAppend("rehashDiv", "innerHTML", "<b>Done, redirecting....</b>");
        $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
        $objResponse->addScript("setTimeout(\"window.location = 'index.php';\", 1800);");
      }
      return $objResponse;
    }
    
    $r = new CServerControl(intval($GLOBALS['config']['gamecache.enabled']) == 1);
    $r->Connect($serv['ip'], $serv['port']);
    
    if(!$r->AuthRcon($serv['rcon']))
    {
      $GLOBALS['db']->Execute("UPDATE ".DB_PREFIX."_servers SET rcon = '' WHERE sid = '".$serv['sid']."';");
      $objResponse->addAppend("rehashDiv", "innerHTML", "".$serv['ip'].":".$serv['port']." (".($do+1)."/".sizeof($servers).") <font color='red'>Error: incorrect RCON password</font>.<br />");
      if($do >= sizeof($servers)-1) {
        $objResponse->addAppend("rehashDiv", "innerHTML", "<b>Done, redirecting....</b>");
        $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
        $objResponse->addScript("setTimeout(\"window.location = 'index.php';\", 1800);");
      }
      return $objResponse;
    }

    if ($GLOBALS['config']['feature.old_serverside'] == "1") {
      $r->SendCommand("sm_rehash");
      sleep(1);
      $r->SendCommand("sm_reloadadmins");
    } else
      $r->SendCommand("ma_rehashadm");

    $objResponse->addAppend("rehashDiv", "innerHTML", "".$serv['ip'].":".$serv['port']." (".($do+1)."/".sizeof($servers).") <font color='green'>success</font>.<br />");
    if($do >= sizeof($servers)-1) {
      $objResponse->addAppend("rehashDiv", "innerHTML", "<b>Done, redirecting....</b>");
      $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
      $objResponse->addScript("setTimeout(\"window.location = 'index.php';\", 1800);");
    }
  } else {
    $objResponse->addAppend("rehashDiv", "innerHTML", "Server not chosen.");
    $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
  }
  return $objResponse;
}

function RehashAdmins($server, $do=0, $redirUrl = '')
{
  if (empty($redirUrl))
    $redirUrl = 'index.php?p=admin&c=admins';

  $objResponse = new xajaxResponse();
    global $userbank, $username;
  $do = (int)$do;
  if (!$userbank->HasAccess(ADMIN_OWNER|ADMIN_EDIT_ADMINS|ADMIN_EDIT_GROUPS|ADMIN_ADD_ADMINS))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried reload admins, with no permission.");
    return $objResponse;
  }
  $servers = explode(",",$server);
  if(sizeof($servers)>0) {
    if(sizeof($servers)-1 > $do)
      $objResponse->addScriptCall("xajax_RehashAdmins", $server, $do+1, $redirUrl);

    $serv = $GLOBALS['db']->GetRow("SELECT ip, port, rcon FROM ".DB_PREFIX."_servers WHERE sid = '".(int)$servers[$do]."';");
    if(empty($serv['rcon'])) {
      $objResponse->addAppend("rehashDiv", "innerHTML", "".$serv['ip'].":".$serv['port']." (".($do+1)."/".sizeof($servers).") <font color='red'>Error: RCON password not seted</font>.<br />");
      if($do >= sizeof($servers)-1) {
        $objResponse->addAppend("rehashDiv", "innerHTML", "<b>Done, redirecting....</b>");
        $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
        $objResponse->addScript("setTimeout(\"window.location = '{$redirUrl}';\", 1800);");
      }
      return $objResponse;
    }

    $test = @fsockopen($serv['ip'], $serv['port'], $errno, $errstr, 2);
    if(!$test) {
      $objResponse->addAppend("rehashDiv", "innerHTML", "".$serv['ip'].":".$serv['port']." (".($do+1)."/".sizeof($servers).") <font color='red'>Error: no connection</font>.<br />");
      if($do >= sizeof($servers)-1) {
        $objResponse->addAppend("rehashDiv", "innerHTML", "<b>Done, redirecting....</b>");
        $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
        $objResponse->addScript("setTimeout(\"window.location = '{$redirUrl}';\", 1800);");
      }
      return $objResponse;
    }
    
    $r = new CServerControl(intval($GLOBALS['config']['gamecache.enabled']) == 1);
    $r->Connect($serv['ip'], $serv['port']);
    
    if(!$r->AuthRcon($serv['rcon']))
    {
      $GLOBALS['db']->Execute("UPDATE ".DB_PREFIX."_servers SET rcon = '' WHERE sid = '".$serv['sid']."';");
      $objResponse->addAppend("rehashDiv", "innerHTML", "".$serv['ip'].":".$serv['port']." (".($do+1)."/".sizeof($servers).") <font color='red'>Error: incorrect RCON</font>.<br />");
      if($do >= sizeof($servers)-1) {
        $objResponse->addAppend("rehashDiv", "innerHTML", "<b>Done, redirecting....</b>");
        $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
        $objResponse->addScript("setTimeout(\"window.location = '{$redirUrl}';\", 1800);");
      }
      return $objResponse;
    }

    if ($GLOBALS['config']['feature.old_serverside'] == "1") {
      $r->SendCommand("sm_rehash");
      sleep(1);
      $r->SendCommand("sm_reloadadmins");
    } else
      $r->SendCommand("ma_rehashadm");

    $objResponse->addAppend("rehashDiv", "innerHTML", "".$serv['ip'].":".$serv['port']." (".($do+1)."/".sizeof($servers).") <font color='green'>success</font>.<br />");
    if($do >= sizeof($servers)-1) {
      $objResponse->addAppend("rehashDiv", "innerHTML", "<b>Done, redirecting....</b>");
      $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
      $objResponse->addScript("setTimeout(\"window.location = '{$redirUrl}';\", 1800);");
    }
  } else {
    $objResponse->addAppend("rehashDiv", "innerHTML", "Server not choosed.");
    $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
  }
  return $objResponse;
}

function GroupBan($groupuri, $isgrpurl="no", $queue="no", $reason="", $last="")
{
  $objResponse = new xajaxResponse();
  if($GLOBALS['config']['config.enablegroupbanning']==0)
    return $objResponse;
    global $userbank, $username;
    if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_ADD_BAN))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to ban group '".htmlspecialchars(addslashes(trim($groupuri)))."', with no permission.");
    return $objResponse;
  }
  if($isgrpurl=="yes")
    $grpname = $groupuri;
  else {
    $url = parse_url($groupuri, PHP_URL_PATH);
    $url = explode("/", $url);
    $grpname = $url[2];
  }
  if(empty($grpname)) {
    $objResponse->addAssign("groupurl.msg", "innerHTML", "Group URL conversion error.");
    $objResponse->addScript("$('groupurl.msg').setStyle('display', 'block');");
    return $objResponse;
  }
  else {
    $objResponse->addScript("$('groupurl.msg').setStyle('display', 'none');");
  }

  if($queue=="yes")
    $objResponse->addScript("ShowBox('Wait...', 'All members of the selected group are banned ... <br> Please wait ... <br> Note: This may take 15 minutes or longer, depending on the number of members in the group!', 'info', '', false);");
  else
    $objResponse->addScript("ShowBox('Wait...', 'All members of group are banning ".$grpname."...<br>Wait...<br>Note: This may take 15 minutes or longer, depending on the number of members in the group!!', 'info', '', false);");
  $objResponse->addScript("$('dialog-control').setStyle('display', 'none');");
  $objResponse->addScriptCall("xajax_BanMemberOfGroup", $grpname, $queue, htmlspecialchars(addslashes($reason)), $last);
  return $objResponse;

}

function BanMemberOfGroup($grpurl, $queue, $reason, $last)
{
  set_time_limit(0);
  $objResponse = new xajaxResponse();
  if($GLOBALS['config']['config.enablegroupbanning']==0)
    return $objResponse;
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_ADD_BAN))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to ban group '".$grpurl."', with no permission.");
    return $objResponse;
  }
  $bans = $GLOBALS['db']->GetAll("SELECT CAST(MID(authid, 9, 1) AS UNSIGNED) + CAST('76561197960265728' AS UNSIGNED) + CAST(MID(authid, 11, 10) * 2 AS UNSIGNED) AS community_id FROM ".DB_PREFIX."_bans WHERE RemoveType IS NULL;");
  foreach($bans as $ban) {
    $already[] = $ban["community_id"];
  }
  $doc = new DOMDocument();
  // This could be changed to use the memberlistxml
  // https://partner.steamgames.com/documentation/community_data
  // http://steamcommunity.com/groups/<GroupName>/memberslistxml/?xml=1
  // but we'd need to open every single profile of every member to get the name..
  $raw = file_get_contents("https://steamcommunity.com/groups/".$grpurl."/members"); // get the members page
  @$doc->loadHTML($raw); // load it into a handy object so we can maintain it
  // the memberlist is paginated, so we need to check the number of pages
  $pagetag = $doc->getElementsByTagName('div');
  foreach($pagetag as $pageclass) {
    if($pageclass->getAttribute('class') == "pageLinks") { //search for the pageLinks div
      $pageclasselmt = $pageclass;
      break;
    }
  }
  $pagelinks = $pageclasselmt->getElementsByTagName('a'); // get all page links
  $pagenumbers = array();
  $pagenumbers[] = 1; // add at least one page for the loop. if the group doesn't have 50 members -> no paginating
  foreach($pagelinks as $pagelink) {
    $pagenumber = str_replace("?p=", "", $pagelink->childNodes->item(0)->nodeValue); // remove the get variable stuff so we only have the pagenumber
    if(strpos($pagenumber, ">") === false) // don't want the "next" button ;)
      $pagenumbers[] = $pagenumber;
  }
  $members = array();
  $total = 0;
  $bannedbefore = 0;
  $error = 0;
  for($i=1;$i<=max($pagenumbers);$i++) { // loop through all the pages
    if($i!=1) { // if we are on page 1 we don't need to reget the content as we did above already.
      $raw = file_get_contents("https://steamcommunity.com/groups/".$grpurl."/members?p=".$i); // open the memberpage
      @$doc->loadHTML($raw);
    }
    $tags = $doc->getElementsByTagName('a');
    foreach ($tags as $tag) {
      // search for the member profile links
      if((strstr($tag->getAttribute('href'), "https://steamcommunity.com/id/") || strstr($tag->getAttribute('href'), "https://steamcommunity.com/profiles/")) && $tag->hasChildNodes() && $tag->childNodes->length == 1 && $tag->childNodes->item(0)->nodeValue != "") {
        $total++;
        $url = parse_url($tag->getAttribute('href'), PHP_URL_PATH);
        $url = explode("/", $url);
        if(in_array($url[2], $already)) {
          $bannedbefore++;
          continue;
        }
        if(strstr($tag->getAttribute('href'), "https://steamcommunity.com/id/")) {
          // we don't have the friendid as this player is using a custom id :S need to get the friendid
          if($tfriend = GetFriendIDFromCommunityID($url[2])) {
            if(in_array($tfriend, $already)) {
              $bannedbefore++;
              continue;
            }
            $cust = $url[2];
            $steamid = FriendIDToSteamID($tfriend);
            $urltag = $tfriend;
          } else {
            $error++;
            continue;
          }
        } else {
          // just a normal friendid profile =)
          $cust = NULL;
          $steamid = FriendIDToSteamID($url[2]);
          $urltag = $url[2];
        }
        $pre = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_bans(created,type,ip,authid,name,ends,length,reason,aid,adminIp ) VALUES
                  (UNIX_TIMESTAMP(),?,?,?,?,UNIX_TIMESTAMP(),?,?,?,?)");
        $GLOBALS['db']->Execute($pre,array(0,
                           "",
                           $steamid,
                           utf8_decode($tag->childNodes->item(0)->nodeValue),
                           0,
                           "Steam Community Group Ban (".$grpurl.") ".$reason,
                           $userbank->GetAid(),
                           $_SERVER['REMOTE_ADDR']));
      }
    }
  }
  if($queue=="yes") {
    $objResponse->addScript("$('steamGroupStatus').setStyle('display', 'block');");
    $objResponse->addAppend("steamGroupStatus", "innerHTML", "<p>Banned ".($total-$bannedbefore-$error)." from ".$total." group members '".$grpurl."'. <br/> ".$bannedbefore." banned before. <br /> ".$error." errors.</p>");
    if($grpurl==$last) {
      $objResponse->addScript("ShowBox('Groups successfully banned', 'The selected groups have been successfully banned. Ban details are displayed in a green window.', 'green', '', true);");
      $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
    }
  } else {
    $objResponse->addScript("ShowBox('Group banned', 'Banned ".($total-$bannedbefore-$error)." from ".$total." group members \'".$grpurl."\'.<br>".$bannedbefore." banned before.<br>".$error." errors.', 'green', '', true);");
    $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
  }
  $log = new CSystemLog("m", "Group banned", "Banned ".($total-$bannedbefore-$error)." from ".$total." group members \'".$grpurl."\'.<br>".$bannedbefore." banned before.<br>".$error." errors.");
  return $objResponse;
}

function GetGroups($friendid)
{
  set_time_limit(0);
  $objResponse = new xajaxResponse();
  if($GLOBALS['config']['config.enablegroupbanning']==0 || !is_numeric($friendid))
    return $objResponse;
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_ADD_BAN))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to list groups '".$friendid."', with no permission.");
    return $objResponse;
  }
  // check if we're getting redirected, if so there is $result["Location"] (the player uses custom id)  else just use the friendid. !We can't get the xml with the friendid url if the player has a custom one!
  $result = get_headers("http://steamcommunity.com/profiles/".$friendid."/", 1);
  $raw = file_get_contents((!empty($result["Location"])?$result["Location"]:"http://steamcommunity.com/profiles/".$friendid."/")."?xml=1");
  preg_match("/<privacyState>([^\]]*)<\/privacyState>/", $raw, $status);
  if(($status && $status[1] != "public") || strstr($raw, "<groups>")) {
    $raw = str_replace("&", "", $raw);
    $raw = strip_31_ascii($raw);
    $raw = utf8_encode($raw);
    $xml = simplexml_load_string($raw); // parse xml
    $result = $xml->xpath('/profile/groups/group'); // go to the group nodes
    $i = 0;
    while(list( , $node) = each($result)) {
      // Steam only provides the details of the first 3 groups of a players profile. We need to fetch the individual groups seperately to get the correct information.
      if(empty($node->groupName)) {
        $memberlistxml = file_get_contents("http://steamcommunity.com/gid/".$node->groupID64."/memberslistxml/?xml=1");
        $memberlistxml = str_replace("&", "", $memberlistxml);
        $memberlistxml = strip_31_ascii($memberlistxml);
        $memberlistxml = utf8_encode($memberlistxml);
        $groupxml = simplexml_load_string($memberlistxml); // parse xml
        $node = $groupxml->xpath('/memberList/groupDetails');
        $node = $node[0];
      }
      
      // Checkbox & Groupname table cols
      $objResponse->addScript('var e = document.getElementById("steamGroupsTable");
                          var tr = e.insertRow("-1");
                            var td = tr.insertCell("-1");
                              td.className = "listtable_1";
                              td.style.padding = "0px";
                              td.style.width = "3px";
                                var input = document.createElement("input");
                                input.setAttribute("type","checkbox");
                                input.setAttribute("id","chkb_'.$i.'");
                                input.setAttribute("value","'.$node->groupURL.'");
                              td.appendChild(input);
                            var td = tr.insertCell("-1");
                              td.className = "listtable_1";
                              var a = document.createElement("a");
                                a.href = "http://steamcommunity.com/groups/'.$node->groupURL.'";
                                a.setAttribute("target","_blank");
                                  var txt = document.createTextNode("'.utf8_decode($node->groupName).'");
                                a.appendChild(txt);
                              td.appendChild(a);
                                var txt = document.createTextNode(" (");
                              td.appendChild(txt);
                                var span = document.createElement("span");
                                span.setAttribute("id","membcnt_'.$i.'");
                                span.setAttribute("value","'.$node->memberCount.'");
                                  var txt3 = document.createTextNode("'.$node->memberCount.'");
                                span.appendChild(txt3);
                              td.appendChild(span);
                                var txt2 = document.createTextNode(" Members)");
                              td.appendChild(txt2);
                            ');
      $i++;
    }
  } else {
    $objResponse->addScript("ShowBox('Error', 'Error getting group information. <br> Perhaps this is a member of another group, or is his profile hidden?<br><a href=\"http://steamcommunity.com/profiles/".$friendid."/\" title=\"Member profile\" target=\"_blank\">Member profile</a>', 'red', 'index.php?p=banlist', true);");
    $objResponse->addScript("$('steamGroupsText').innerHTML = '<i>No groups...</i>';");
    return $objResponse;
  }
  $objResponse->addScript("$('steamGroupsText').setStyle('display', 'none');");
  $objResponse->addScript("$('steamGroups').setStyle('display', 'block');");
  return $objResponse;
}

function BanFriends($friendid, $name)
{
  set_time_limit(0);
  $objResponse = new xajaxResponse();
  if($GLOBALS['config']['config.enablefriendsbanning']==0 || !is_numeric($friendid))
    return $objResponse;
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_ADD_BAN))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to ban friend '".RemoveCode($friendid)."', with no permission.");
    return $objResponse;
  }
  $bans = $GLOBALS['db']->GetAll("SELECT CAST(MID(authid, 9, 1) AS UNSIGNED) + CAST('76561197960265728' AS UNSIGNED) + CAST(MID(authid, 11, 10) * 2 AS UNSIGNED) AS community_id FROM ".DB_PREFIX."_bans WHERE RemoveType IS NULL;");
  foreach($bans as $ban) {
    $already[] = $ban["community_id"];
  }
  $doc = new DOMDocument();
  $result = get_headers("http://steamcommunity.com/profiles/".$friendid."/", 1);
  $raw = file_get_contents(($result["Location"]!=""?$result["Location"]:"http://steamcommunity.com/profiles/".$friendid."/")."friends"); // get the friends page
  @$doc->loadHTML($raw);
  $divs = $doc->getElementsByTagName('div');
  foreach($divs as $div) {
    if($div->getAttribute('id') == "memberList") {
      $memberdiv = $div;
      break;
    }
  }

  $total = 0;
  $bannedbefore = 0;
  $error = 0;
  $links = $memberdiv->getElementsByTagName('a');
  foreach ($links as $link) {
    if(strstr($link->getAttribute('href'), "http://steamcommunity.com/id/") || strstr($link->getAttribute('href'), "http://steamcommunity.com/profiles/"))
    {
      $total++;
      $url = parse_url($link->getAttribute('href'), PHP_URL_PATH);
      $url = explode("/", $url);
      if(in_array($url[2], $already)) {
        $bannedbefore++;
        continue;
      }
      if(strstr($link->getAttribute('href'), "http://steamcommunity.com/id/")) {
        // we don't have the friendid as this player is using a custom id :S need to get the friendid
        if($tfriend = GetFriendIDFromCommunityID($url[2])) {
          if(in_array($tfriend, $already)) {
            $bannedbefore++;
            continue;
          }
          $cust = $url[2];
          $steamid = FriendIDToSteamID($tfriend);
          $urltag = $tfriend;
        } else {
          $error++;
          continue;
        }
      } else {
        // just a normal friendid profile =)
        $cust = NULL;
        $steamid = FriendIDToSteamID($url[2]);
        $urltag = $url[2];
      }
      
      // get the name
      $friendName = $link->parentNode->childNodes->item(5)->childNodes->item(0)->nodeValue;
      $friendName = str_replace("&#13;", "", $friendName);
      $friendName = trim($friendName);
      
      $pre = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_bans(created,type,ip,authid,name,ends,length,reason,aid,adminIp ) VALUES
                  (UNIX_TIMESTAMP(),?,?,?,?,UNIX_TIMESTAMP(),?,?,?,?)");
      $GLOBALS['db']->Execute($pre,array(0,
                         "",
                         $steamid,
                         utf8_decode($friendName),
                         0,
                         "Steam Community Friend Ban (".htmlspecialchars($name).")",
                         $userbank->GetAid(),
                         $_SERVER['REMOTE_ADDR']));
    }
  }
  if($total==0) {
    $objResponse->addScript("ShowBox('Error choosing friends', 'Error fetching friends from STEAM profile. Perhaps his profile is hidden, or he has no friends!', 'red', 'index.php?p=banlist', true);");
    $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
    return $objResponse;
  }
  $objResponse->addScript("ShowBox('Friends banned', 'Banned ".($total-$bannedbefore-$error)." from ".$total." friends of \'".htmlspecialchars($name)."\'.<br>".$bannedbefore." banned before.<br>".$error." errors.', 'green', 'index.php?p=banlist', true);");
  $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
  $log = new CSystemLog("m", "Friends banned", "Banned ".($total-$bannedbefore-$error)." from ".$total." friends of \'".htmlspecialchars($name)."\'.<br>".$bannedbefore." banned before.<br>".$error." errors.");
  return $objResponse;
}

function ViewCommunityProfile($sid, $name)
{
  $objResponse = new xajaxResponse();
    global $userbank, $username;
  if(!$userbank->is_admin())
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to view profile '".htmlspecialchars($name)."', with no permission.");
    return $objResponse;
  }
  $sid = (int)$sid;
  
  //get the server data
  $data = $GLOBALS['db']->GetRow("SELECT ip, port, rcon FROM ".DB_PREFIX."_servers WHERE sid = '".$sid."';");
  if(empty($data['rcon'])) {
    $objResponse->addScript("ShowBox('Error', 'Failed to get info about players ".addslashes(htmlspecialchars($name)).". RCON password not seted!', 'red', '', true);");
    return $objResponse;
  }
  
  $r = new CServerControl(intval($GLOBALS['config']['gamecache.enabled']) == 1);
  $r->Connect($data['ip'], $data['port']);

  if(!$r->AuthRcon($data['rcon']))
  {
    $GLOBALS['db']->Execute("UPDATE ".DB_PREFIX."_servers SET rcon = '' WHERE sid = '".$sid."';");
    $objResponse->addScript("ShowBox('Error', 'Failed to get info about player ".addslashes(htmlspecialchars($name)).". Incorrect RCON password!', 'red', '', true);");
    return $objResponse;
  }
  // search for the playername
  $ret = $r->SendCommand("status");
  $search = preg_match_all(STATUS_PARSE,$ret,$matches,PREG_PATTERN_ORDER);
  $i = 0;
  $found = false;
  $index = -1;
  foreach($matches[2] AS $match) {
    if($match == $name) {
      $found = true;
      $index = $i;
      break;
    }
    $i++;
  }
  if($found) {
    $steam = $matches[3][$index];
    // Hack to support steam3 [U:1:X] representation.
    if(strpos($steam, "[U:") === 0) {
      $steam = renderSteam2(getAccountId($steam), 0);
    }
        $objResponse->addScript("ShowBox('Profile', 'Link to profile \"".addslashes(htmlspecialchars($name))."\", successfully created: <a href=\"http://www.steamcommunity.com/profiles/".SteamIDToFriendID($steam)."/\" title=\"".addslashes(htmlspecialchars($name))."\'s Profile\" target=\"_blank\">Open</a>', 'green', '', true);");
    $objResponse->addScript("window.open('http://www.steamcommunity.com/profiles/".SteamIDToFriendID($steam)."/', 'Community_".$steam."');");
  } else {
    $objResponse->addScript("ShowBox('Error', 'Failed to get info about player ".addslashes(htmlspecialchars($name)).". Player left server!', 'red', '', true);");
  }
  return $objResponse;
}

function SendMessage($sid, $name, $message)
{
  $objResponse = new xajaxResponse();
    global $userbank, $username;
  if(!$userbank->is_admin())
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to send message '".addslashes(htmlspecialchars($name))."' (\"".RemoveCode($message)."\"), with no permission.");
    return $objResponse;
  }
  $sid = (int)$sid;
  //get the server data
  $data = $GLOBALS['db']->GetRow("SELECT ip, port, rcon FROM ".DB_PREFIX."_servers WHERE sid = '".$sid."';");
  if(empty($data['rcon'])) {
    $objResponse->addScript("ShowBox('Error', 'Failed to send message ".addslashes(htmlspecialchars($name)).". RCON password not seted!', 'red', '', true);");
    return $objResponse;
  }
  
  $r = new CServerControl(intval($GLOBALS['config']['gamecache.enabled']) == 1);
  $r->Connect($data['ip'], $data['port']);
  
  if(!$r->AuthRcon($data['rcon']))
  {
    $GLOBALS['db']->Execute("UPDATE ".DB_PREFIX."_servers SET rcon = '' WHERE sid = '".$sid."';");
    $objResponse->addScript("ShowBox('Error', 'Failed to send message ".addslashes(htmlspecialchars($name)).". Incorrect RCON password!', 'red', '', true);");
    return $objResponse;
  }
  $ret = $r->SendCommand('sm_psay "'.$name.'" "'.addslashes($message).'"');
  new CSystemLog("m", "Message sent", "Message has been sent " . addslashes(htmlspecialchars($name)) . " on server " . $data['ip'] . ":" . $data['port'] . ": " . RemoveCode($message));
  $objResponse->addScript("ShowBox('Message sent', 'Message for player \'".addslashes(htmlspecialchars($name))."\' successfully sent!', 'green', '', true);$('dialog-control').setStyle('display', 'none');");
  return $objResponse;
}
function AddBlock($nickname, $type, $steam, $length, $reason)
{
  $objResponse = new xajaxResponse();
  global $userbank, $username;
  if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_ADD_BAN))
  {
    $objResponse->redirect("index.php?p=login&m=no_access", 0);
    $log = new CSystemLog("w", "Hacking attempt", $username . " tried to add comms block, with no permission.");
    return $objResponse;
  }
  
  $steam = trim($steam);
  
  $error = 0;
  // If they didnt type a steamid
  if(empty($steam))
  {
    $error++;
    $objResponse->addAssign("steam.msg", "innerHTML", "Enter STEAM ID");
    $objResponse->addScript("$('steam.msg').setStyle('display', 'block');");
  }
  else if((!is_numeric($steam) 
  && !validate_steam($steam))
  || (is_numeric($steam) 
  && (strlen($steam) < 15
  || !validate_steam($steam = FriendIDToSteamID($steam)))))
  {
    $error++;
    $objResponse->addAssign("steam.msg", "innerHTML", "Enter valid STEAM ID");
    $objResponse->addScript("$('steam.msg').setStyle('display', 'block');");
  }
  else
  {
    $objResponse->addAssign("steam.msg", "innerHTML", "");
    $objResponse->addScript("$('steam.msg').setStyle('display', 'none');");
  }
  
  if($error > 0)
    return $objResponse;

  $nickname = RemoveCode($nickname);
  $reason = RemoveCode($reason);
  if(!$length)
    $len = 0;
  else
    $len = $length*60;

  // prune any old bans
  PruneComms();

  $typeW = "";
  switch ((int)$type)
  {
    case 1:
      $typeW = "type = 1";
      break;
    case 2:
      $typeW = "type = 2";
      break;
    case 3:
      $typeW = "(type = 1 OR type = 2)";
      break;
    default:
      $typeW = "";
      break;
  }

  // Check if the new steamid is already banned
  $chk = $GLOBALS['db']->GetRow("SELECT count(bid) AS count FROM ".DB_PREFIX."_comms WHERE authid = ? AND (length = 0 OR ends > UNIX_TIMESTAMP()) AND RemovedBy IS NULL AND ".$typeW, array($steam));
  
  if(intval($chk[0]) > 0)
  {
    $objResponse->addScript("ShowBox('Error', 'SteamID: $steam already blocked.', 'red', '', true);");
    return $objResponse;
  }

  // Check if player is immune
  $admchk = $userbank->GetAllAdmins();
  foreach($admchk as $admin)
  if($admin['authid'] == $steam && $userbank->GetProperty('srv_immunity') < $admin['srv_immunity'])
    {
      $objResponse->addScript("ShowBox('Error', 'SteamID: Admin ".$admin['user']." ($steam) have immunity.', 'red', '');");
      return $objResponse;
    }

  if((int)$type == 1 || (int)$type == 3)
  {
    $pre = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_comms(created,type,authid,name,ends,length,reason,aid,adminIp ) VALUES
                    (UNIX_TIMESTAMP(),1,?,?,(UNIX_TIMESTAMP() + ?),?,?,?,?)");
    $GLOBALS['db']->Execute($pre,array($steam,
                       $nickname,
                       $length*60,
                       $len,
                       $reason,
                       $userbank->GetAid(),
                       $_SERVER['REMOTE_ADDR']));
  }
  if ((int)$type == 2 || (int)$type ==3)
  {
    $pre = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_comms(created,type,authid,name,ends,length,reason,aid,adminIp ) VALUES
                    (UNIX_TIMESTAMP(),2,?,?,(UNIX_TIMESTAMP() + ?),?,?,?,?)");
    $GLOBALS['db']->Execute($pre,array($steam,
                       $nickname,
                       $length*60,
                       $len,
                       $reason,
                       $userbank->GetAid(),
                       $_SERVER['REMOTE_ADDR']));
  }

  $objResponse->addScript("ShowBox('Block added', 'Block successfully added', 'green', 'index.php?p=admin&c=comms');");
  $objResponse->addScript("TabToReload();");
  $log = new CSystemLog("m", "Block added", "Block (" . $steam . ") has been added, reason: $reason, length: $length", true, $kickit);
  return $objResponse;
}

function PrepareReblock($bid)
{
  $objResponse = new xajaxResponse();

  $ban = $GLOBALS['db']->GetRow("SELECT name, authid, type, length, reason FROM ".DB_PREFIX."_comms WHERE bid = '".$bid."';");

  // clear any old stuff
  $objResponse->addScript("$('nickname').value = ''");
  $objResponse->addScript("$('steam').value = ''");
  $objResponse->addScript("$('txtReason').value = ''");
  $objResponse->addAssign("txtReason", "innerHTML",  "");

  // add new stuff
  $objResponse->addScript("$('nickname').value = '" . $ban['name'] . "'");
  $objResponse->addScript("$('steam').value = '" . $ban['authid']. "'");
  $objResponse->addScriptCall("selectLengthTypeReason", $ban['length'], $ban['type']-1, addslashes($ban['reason']));

  $objResponse->addScript("SwapPane(0);");
  return $objResponse;
}

function PrepareBlockFromBan($bid)
{
  $objResponse = new xajaxResponse();

  // clear any old stuff
  $objResponse->addScript("$('nickname').value = ''");
  $objResponse->addScript("$('steam').value = ''");
  $objResponse->addScript("$('txtReason').value = ''");  
  $objResponse->addAssign("txtReason", "innerHTML",  "");

  $ban = $GLOBALS['db']->GetRow("SELECT name, authid FROM ".DB_PREFIX."_bans WHERE bid = '".$bid."';");

  // add new stuff
  $objResponse->addScript("$('nickname').value = '" . $ban['name'] . "'");
  $objResponse->addScript("$('steam').value = '" . $ban['authid']. "'");
  
  $objResponse->addScript("SwapPane(0);");
  return $objResponse;
}

function PastePlayerData($sid, $name) {
    global $userbank, $username;
    $objResponse = new xajaxResponse();

    if (!$userbank->HasAccess(ADMIN_OWNER|ADMIN_ADD_BAN)) {
        $objResponse->redirect("index.php?p=login&m=no_access", 0);
        $log = new CSystemLog("w", "Hacking attempt", $username . " tried to get player data to add a ban / block , with no permission.");
        return $objResponse;
    }
    
    sleep(1); // костыль против быстрого "пролёта" окошка о том, что игрок не найден
    
    $sid = (int) $sid;
    $data = $GLOBALS['db']->GetRow("SELECT ip, port, rcon FROM ".DB_PREFIX."_servers WHERE sid = ?;", array($sid));
    if (empty($data['rcon'])) {
        $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
        $objResponse->addScript("ShowBox('Error', 'No RCON password <b>".$data['ip'].":".$data['port']."</b>! Cannot get player details!', 'red', '', true);");
        return $objResponse;
    }
    
    $CSInstance = new CServerControl(intval($GLOBALS['config']['gamecache.enabled']) == 1);
    $CSInstance->Connect($data['ip'], $data['port']);
    if (!$CSInstance->AuthRcon($data['rcon'])) {
        $GLOBALS['db']->Execute("UPDATE ".DB_PREFIX."_servers SET rcon = '' WHERE sid = ?;", array($sid));
        $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
        $objResponse->addScript("ShowBox('Error', 'Incorrect RCON password ".$data['ip'].":".$data['port']."!', 'red', '', true);");
        return $objResponse;
    }
    
    $client = getClientByName($CSInstance, $name);
    if (!$client) {
        $objResponse->addScript("ShowBox('Error', 'Cannot get player information ".addslashes(htmlspecialchars($name)).". Player left server! (".$data['ip'].":".$data['port'].") ', 'red', '', true);");
        $objResponse->addScript("$('dialog-control').setStyle('display', 'block');");
        return $objResponse;
    }
    
    // nickname, steam, ip
    $objResponse->addAssign("nickname", "value", $client['name']);
    $objResponse->addAssign("steam",    "value", $client['steam']);
    $objResponse->addAssign("ip",       "value", $client['ip']);
    $objResponse->addScript("swal.close();");
    
    return $objResponse;
}

function AddWarning($id, $days, $reason) {
  global $userbank;

  $objResponse = new xajaxResponse();
  if (!$userbank->HasAccess(ADMIN_OWNER|ADMIN_DELETE_ADMINS) || $userbank->GetProperty("srv_immunity", $admin['id']) > $userbank->GetProperty("srv_immunity")) {
    ShowBox_ajx("Error", "Permission denied.", "red", "", true, $objResponse);
    new CSystemLog("w", "Unsanctioned access attempt", "The administrator tried to issue a warning, with no permission.");
    return $objResponse;
  }
  
  if ((int) $days <= 0) {
        ShowBox_ajx("Error", "Please enter a number of days greater than zero.", "red", "", true, $objResponse);
        return $objResponse;
  }

  $removedAccess = false;

  $GLOBALS['db']->Execute("INSERT INTO `" . DB_PREFIX . "_warns` (`arecipient`, `afrom`, `expires`, `reason`) VALUES(" . (int) $id . ", " . (int) $userbank->GetAid() . ", " . (time() + (86400 * (int) $days)) . ", " . $GLOBALS['db']->qstr($reason) . ");");
  new CSystemLog("m", "Warning added", "Admin added warning to admin " . $userbank->getProperty('user', $id));

  if ($GLOBALS['db']->GetOne("SELECT COUNT(*) FROM `" . DB_PREFIX . "_warns` WHERE `arecipient` = " . (int) $id) >= (int) $GLOBALS['config']['admin.warns.max']) {
    $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_admins` SET `expired` = 1 WHERE `aid` = " . (int) $id . ";");
    new CSystemLog("m", "Admin account disabled", "Due to exceeding the limit of the maximum active warnings, Admin " . $userbank->getProperty('user', $id) . " removed from Duty.");
    $removedAccess = true;
  }
  $msg = "Warning with reason \"<em>".$reason."</em>\" added for ".$days." days.";
  if ($removedAccess)
    $msg .= "<br /><br />Because the Administrator has exceeded the maximum active alert limit, he <span style=\"color: #f00;\">removed from duty</span>.";

  ShowBox_ajx("Success", $msg, "green", "", true, $objResponse);
  return $objResponse;
}

function RemoveWarning($warningId) {
    global $userbank;

    $objResponse = new xajaxResponse();
    if (!$userbank->HasAccess(ADMIN_OWNER|ADMIN_DELETE_ADMINS)) {
        ShowBox_ajx("Error", "Access denied.", "red", "", true, $objResponse);
        new CSystemLog("w", "Unsanctioned access attempt", "The administrator tried to clear the warning, with no permission.");
        return $objResponse;
    }

    if ((int) $GLOBALS['db']->GetOne("SELECT COUNT(*) FROM `" . DB_PREFIX . "_warns` WHERE `expires` > " . time() . " AND `id` = ". (int) $warningId) == 1) {
        ShowBox_ajx("Success", "Warning removed", "green", "", true, $objResponse);
        new CSystemLog("m", "Warning removed", "Admin removed warning from admin " . $userbank->getProperty('user', $GLOBALS['db']->GetOne("SELECT `arecipient` FROM `" . DB_PREFIX . "_warns` WHERE `id` = " . (int) $warningId)) . " with id " . $warningId);
        $GLOBALS['db']->Execute("UPDATE `" . DB_PREFIX . "_warns` SET `expires` = -1 WHERE `id` = " . (int) $warningId);
    } else
        ShowBox_ajx("Error", "Valid warning with ID " . $warningId . " not found. Maybe it is already expired??", "red", "", true, $objResponse);
    
    return $objResponse;
}
?>
