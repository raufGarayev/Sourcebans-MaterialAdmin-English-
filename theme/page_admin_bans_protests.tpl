{if NOT $permission_protests}
	Access denied!
{else}
<div class="card-header">
	<h2>Ban protests ({$protest_count})<small>Click on player to view more information</small></h2>
</div>
<div id="banlist-nav"> 
    {$protest_nav}
</div>
	<table class="table table-bordered">
		<tr>
        	<th width="20%" class="text-center">Nick</th>
      		<th width="20%" class="text-center">STEAM ID</th>
           	<th width="20%" class="text-center">Status</th>
		</tr>
		{foreach from="$protest_list" item="protest"}
		<tr>
            <td class="text-center"><a href="./index.php?p=banlist&advSearch={$protest.authid}&advType=steamid" title="Show ban">{$protest.name}</a></td>
            <td class="text-center">{if $protest.authid!=""}<a href="https://steamcommunity.com/profiles/{$protest.commid}">{$protest.authid}</a>{else}{$protest.ip}{/if}</td>
            <td class="text-center">
            {if $permission_editban}
            <a href="#" onclick="RemoveProtest('{$protest.pid}', '{if $protest.authid!=""}{$protest.authid}{else}{$protest.ip}{/if}', '1');">Remove</a> -
            {/if}
            <a href="index.php?p=admin&c=bans&o=email&type=p&id={$protest.pid}">Contacts</a>
            </td>
		</tr>
		{/foreach}
	</table>
{/if}

