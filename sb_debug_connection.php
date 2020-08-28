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
/**
 * SourceBans "Error Connecting()" Debug
 * Checks for the ports being forwarded correctly
 */

/** 
 * Конфиг
 * Смените IP и порт, если хотите протестировать соединение.
 */
$serverip = "";
$serverport = 27015;
$serverrcon = ""; // Указывайте RCON-пароль, если хотите проверить так же возможность управления сервером из веб-панели SourceBans


/******* Ничего не изменяйте после этой линии *******/
header("Content-Type: text/plain; charset=utf8");

if(empty($serverip) || empty($serverport))
	die('[-] Server information is not specified. Open this file with a text editor, write down the IP and port in it, save and upload back to the server.');

echo '[+] SourceBans "DebugConnection()" launched for server ' . $serverip . ':' . $serverport . "\n\n";

// Попытаемся установить соединение
echo '[+] Открываю UDP-сокет...'.PHP_EOL;
$sock = @fsockopen("udp://" . $serverip, $serverport, $errno, $errstr, 2);

$isBanned = false;

if(!$sock)
    echo '[-] Error connecting. #' . $errno . ': ' . $errstr . PHP_EOL;
else {
    echo '[+] UDP connection successfull!'.PHP_EOL;

    stream_set_timeout($sock, 1);

    // Попытаемся получить информацию у сервера
    echo '[+] Writing a request to a socket..'.PHP_EOL;
    if(fwrite($sock, "\xFF\xFF\xFF\xFF\x54Source Engine Query\0") === false)
        echo '[-] Error writing to socket.'.PHP_EOL;
    else {
        echo '[+] The request was successfully written to the socket. (This does not mean that the connection is okay.) Reading answer...'.PHP_EOL;
        $packet = fread($sock, 1480);

        if(empty($packet))
            echo '[-] Error retrieving server information. Unable to read UDP connection. The port is blocked.'.PHP_EOL;
        else {
            if(substr($packet, 5, (strpos(substr($packet, 5), "\0")-1)) == "Banned by server") {
                printf('[-] A response was received, but the web server is blocked. Remove the lock from the server (removeip %s), and try again.%s', $_SERVER['SERVER_ADDR'], PHP_EOL);
                $isBanned = true;
            } else {
                $packet = substr($packet, 6);
                $hostname = substr($packet, 0, strpos($packet, "\0"));
                echo '[+] Response received! Server: ' . $hostname . PHP_EOL;
            }
        }
    }
    fclose($sock);
}

echo PHP_EOL;

// Проверим на доступность и записываемость TCP-соединения
echo '[+] Trying to establish a TCP connection...'.PHP_EOL;
$sock = @fsockopen($serverip, $serverport, $errno, $errstr, 2);
if(!$sock)
    echo '[-] Error connecting. #' . $errno . ': ' . $errstr . PHP_EOL;
else
{
    echo '[+] TCP connection established successfully!'.PHP_EOL;
    if(empty($serverrcon))
        echo '[o] Interrupting work. RCON password not set.';
    else if($isBanned)
        echo '[o] Interrupting work. Server is locked.';
    else {
        stream_set_timeout($sock, 2);
        $data = pack("VV", 0, 03) . $serverrcon . chr(0) . '' . chr(0);
        $data = pack("V", strlen($data)) . $data;

        echo '[+] I am trying to write to a TCP socket and authorize...'.PHP_EOL;

        if(fwrite($sock, $data, strlen($data)) === false)
            echo '[-] Error writing to socket.'.PHP_EOL;
        else {
            echo '[+] The authorization request was successfully written. I read the answer...'.PHP_EOL;
            $size = fread($sock, 4);
            if(!$size)
                echo '[-] Error reading.'.PHP_EOL;
            else {
                echo '[+] Response received!'.PHP_EOL;
                $size = unpack('V1Size', $size);
                $packet = fread($sock, $size["Size"]);
                $size = fread($sock, 4);
                $size = unpack('V1Size', $size);
                $packet = fread($sock, $size["Size"]);
                $ret = unpack("V1ID/V1Reponse/a*S1/a*S2", $packet);
                if(empty($ret) || (isset($ret['ID']) && $ret['ID'] == -1))
                    echo '[-] RThe RCON password is incorrect ;) Do not try to keep trying, otherwise your web server will "fly away" to the ban.';
                else
                    echo '[+] Password is correct!';
            }
        }
    }
    fclose($sock);
}
?>
