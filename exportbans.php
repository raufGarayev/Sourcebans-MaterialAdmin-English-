<?php
include_once('init.php');

$type = filterInput(INPUT_GET, 'type', FILTER_SANITIZE_STRING);

if (!$userbank->HasAccess(ADMIN_OWNER) && !$GLOBALS['config']['config.exportpublic'])
  die('You don't have access for this.');
else if (is_null($type))
	die('Use only links on system!');

$cmd    = '';
$file   = '';
$type   = 0;
$column = '';
if ($type == 'steam') {
  $cmd    = 'banid';
  $file   = 'banned_user.cfg';
  $type   = 0;
  $column = 'authid';
} elseif ($type == 'ip') {
  $cmd    = 'addip';
  $file   = 'banned_ip.cfg';
  $type   = 1;
  $column = 'ip';
} else
  die("Unknown type $type");

$DB = \DatabaseManager::GetConnection();
$Result = $DB->Query("SELECT $column AS id FROM `{{prefix}}bans` WHERE `length` = 0 AND `RemoveType` IS NULL AND `type` = $type");

Header('Content-Type: text/plain; charset=UTF8');
Header("Content-Disposition: attachment; filename=$file");
foreach ($Result->All() as $ban)
  echo("$cmd 0 $ban[id]\r\n");