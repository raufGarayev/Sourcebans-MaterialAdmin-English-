{if NOT $permission_listmods}
	Access denied!
{else}
	{display_header title="Mod list ($mod_count)" text="List of all MODs added to SourceBans"}
	<div class="card-body card-padding">
		<table class="table table-striped">
			<tbody>
				<tr>
					<th width="35%" class="text-left">Name</th>
					<th width="20%" class="text-center">Folder</th>
					<th width="5%"  class="text-center">Icon</th>
					<th width="2%"  class="text-center">Universe STEAMID</th>{if $permission_editmods || $permission_deletemods}
					<th class="text-right">Actions</th>{/if}
				</tr>
				{foreach from="$mod_list" item="mod" name="gaben"}
				<tr id="mid_{$mod.mid}">
				<td class="text-left">{$mod.name|htmlspecialchars}</td>
				<td class="text-center">{$mod.modfolder|htmlspecialchars}</td>
				<td class="text-center"><img src="images/games/{$mod.icon}" width="16"></td>
				<td class="text-center">{$mod.steam_universe|htmlspecialchars}</td>{if $permission_editmods || $permission_deletemods}
				<td class="text-right">
					{if $permission_editmods}
					<a href="index.php?p=admin&c=mods&o=edit&id={$mod.mid}">Edit</a> / 
					{/if}
					{if $permission_deletemods}
					<a href="#" onclick="RemoveMod('{$mod.name|escape:'quotes'|htmlspecialchars}', '{$mod.mid}');">Remove</a>
					{/if}
				</td>
				{/if}
			</tr>
		{/foreach}
	</table>
	</div>
{/if}
