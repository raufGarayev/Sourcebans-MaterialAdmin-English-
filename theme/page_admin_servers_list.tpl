{if NOT $permission_list}
	Access denied
{else}
	
<div class="card">
	<div class="form-horizontal" role="form">
		<div class="card-header">
			<h2>Servers Management ({$server_count}) <small>List of available servers.</small></h2>
		</div>
		<div class="card-body table-responsive">

			<table id="data-table-command" class="table table-striped table-vmiddle bootgrid-table" aria-busy="false">
				<thead>
					<td class="front-module-header" width="3%" height='16'><strong>ID</strong></td>
					<td class="front-module-header" width="54%" height='16'><strong>Server name</strong></td>
					<td class="front-module-header" width="6%" height='16'><strong>Players</strong></td>
					<td class="front-module-header" width="5%" height='16'><strong>MOD</strong></td>
					<td class="front-module-header" height='16'><strong>Action</strong></td>
				</thead>
				{foreach from="$server_list" item="server"}
				
				<script>xajax_ServerHostPlayers({$server.sid});</script>
				<tr id="sid_{$server.sid}" {if $server.enabled==0}style="background-color:#eaeaea" title="Disabled"{/if}>
					<td style="border-bottom: solid 1px #ccc" height='16'>{$server.sid}</td>
					<td style="border-bottom: solid 1px #ccc" height='16' id="host_{$server.sid}"><i>Getting server details...</i></td>
					<td style="border-bottom: solid 1px #ccc" height='16' id="players_{$server.sid}">N/A</td>
					<td style="border-bottom: solid 1px #ccc" height='16'><img src="images/games/{$server.icon}"></td>
					<td style="border-bottom: solid 1px #ccc" height='16'>
					
					{if $server.rcon_access}
						<a href="index.php?p=admin&c=servers&o=rcon&id={$server.sid}">RCON</a> -
					{/if}
				
					{if $permission_editserver}
						<a href="index.php?p=admin&c=servers&o=edit&id={$server.sid}">Edit</a> -
					{/if}
					
					{if $pemission_delserver}
						<a href="#" onclick="RemoveServer({$server.sid}, '{$server.ip}:{$server.port}');">Remove</a> -
					{/if}

					<a href="index.php?p=admin&c=servers" onclick="ShowRehashBox('{$server.sid}', 'Refreshing admin cache', 'Please, wait. Operation in progress...', 'green', 'index.php?p=admin&c=servers', false); return false;">Refresh admin cache</a>
					</td>
				</tr>
				
				{/foreach}
			</table>
		
		</div>
		<div class="card-body card-padding">
			{if $permission_addserver}
				<button class="btn bgm-orange waves-effect save" onclick="childWindow=open('pages/admin.uploadmapimg.php','upload','resizable=yes,width=300,height=130');" id="upload">Upload map image</button>
				<div id="mapimg1.msg" class="contacts c-profile clearfix p-t-20 p-l-0" style="display:none;">
					<div class="col-md-3 col-sm-4 col-xs-6 p-l-0 p-r-0">
						<div class="c-item">
							<div href="#" class="ci-avatar text-center f-20 p-t-10">
								<i class="zmdi zmdi-balance-wallet zmdi-hc-fw"></i>
							</div>
																
							<div class="c-info">
								<strong id="mapimg.msg"></strong>
							</div>
																
							<div class="c-footer c-green f-700 text-center p-t-5 p-b-5">
								Successfully uploaded
							</div>
						</div>
					</div>
				</div>
			{/if}

			<button class="btn bgm-green waves-effect" onclick="ShowRehashBox('{$servers_separated}', 'Refreshing admin cache in servers', 'Please, wait. Operation in progress...', 'green', 'index.php?p=admin&c=servers', false);">Refresh admin cache in servers</button>
		</div>
	</div>
</div>

{/if}