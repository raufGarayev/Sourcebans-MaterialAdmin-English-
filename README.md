# Sourcebans-MaterialAdmin-English-

This is english version of Material Admin which reforked from Sourcebans++. I made a little bit CSS edits too for better view of site ;)

Original version (russian): https://github.com/SB-MaterialAdmin/Web

Server plugin that works with this web script: https://github.com/SB-MaterialAdmin/NewServer

##  Difference from Sourcebans++

- *Adding admin with time period*

- *Additional fields for Administrators (VK, Skype, Personal comment aka Position)* - Here i tried to replace VK with Instagram as VK is not really popular in other countries except Russia, but i failed it.

- *Login to your account via Steam OpenID*

- *A customizable template directly from the system settings.*

- *Built-in module for the list of Administrators divided by server. Included in the settings.*

- *Support for sending e-mails by the system via SMTP, which allows you to configure sending e-mails through popular free mail services, if mail () is disabled on the server, not configured, or there is simply no desire to send e-mails through it. The ability to switch to mail () was added in version 1.1.5*

- *The ability to load several map images at once, and not one by one, as it is implemented in the original.*

- *Ability to add admins(staffs) to the sidebar on the right.*

- *The ability to allow Administrators to manually specify their contact information (VK, Skype) in their Account.*

- *The ability to hide more detailed information about the Administrator who issued the Ban in the Banlist.*

- *Ability to add and remove blocks from the main page of the system (mutations, bans, locks).*

- *"Promokey system".*
   + Allows Administrators to "manually" register in the system using a special one-time code that can be issued by the Chief Administrator. The server to which the Administrator will bind and its groups are specified when creating a one-time code.

   + There is a captcha to protect against auto-selection by bots.
   + The link to go to the promokey activation page is located in the same place as the authorization buttons.
   + After activating the promokey, the Administrator is automatically logged into his account.
   
- And more functions that not listed on this list.

## How to install

- Download and unpack all files.

- Rename /config.php.temple to /config.php

- Upload all files to the web server.

- Set 0777 permissions on the / images / games /, / images / maps /, / themes_c / folders and on the /config.php file

- Go to the system installer (as a rule, it has an address in the style of httр: //mуsite.com/sourcebans/install/) and follow the instructions on the screen.

- Go to the system updater (as a rule, it has an address in the style of httр: //mуsite.com/sourcebans/updater/) after successful installation.

- Remove the / install / and / updater / folders from the web server

IMPORTANT NOTE: I could not translate /updater. But you shouldn't even worry about that, because there is nothing really important to understand. Just wait for updates to finish and then remove folder /updater.

Demo site:

https://progaming.ba/csgo/bans
