{if $IN_SERVERS_PAGE}
{if $IN_SERVERS_PAGE && $access_bans}<div class="alert alert-info servers_pg" role="alert"><h4>Tips:</h4><span class="p-l-10">Click on <mark><!--<img src="theme/img/inn.png" style="width: 20px;height: 20px;" />-->&nbsp;<i class="zmdi zmdi-label c-white" style="font-size: 17px;"></i>&nbsp;</mark> next to player name, to kick, ban or contact the player directly.</span></div>{/if}
	<div class="card">
		<!--<div class="card-header">
			<h2>Servers list</h2>
		</div>-->
		<div class="card-body table-responsive">
			<table class="table table-striped">
				<tbody>
					<tr>
						<th class="text-center">Game</th>
						<th class="text-center">OC</th>
						<th class="text-center">VAC</th>
						<th class="text-left">Server name</th>
						<th class="text-right">Players</th>
						<th class="text-right">Currentmap</th>
					</tr>
					{foreach from=$server_list item=server}
						<tr id="opener_{$server.sid}" class="opener" style="cursor:pointer;" onmouseout="this.className=''" onmouseover="this.className='active'">
							<td class="text-center"><img src="images/games/{$server.icon}" border="0" /></td>
							<td class="text-center" id="os_{$server.sid}"></td>
							<td class="text-center" id="vac_{$server.sid}"></td>
							<td id="host_{$server.sid}"><i>Getting server info...</i></td>
							<td class="text-right" id="players_{$server.sid}">N/A</td>
							<td class="text-right" id="map_{$server.sid}">N/A</td>
						</tr>
						<tr>
							<td colspan="7" align="center" style="padding: 0px;border-top: 0px solid #FFFFFF;">
								<div class="opener" style="visibility: hidden; zoom: 1; opacity: 0; height: 0px;">
									<div id="serverwindow_{$server.sid}" class="p-20">
											<div id="sinfo_{$server.sid}">
												<table width="90%" border="0" class="listtable">
													<tr>
														<td valign="top" class="table-responsive p-b-10">
															<table width="100%" border="0" id="playerlist_{$server.sid}" name="playerlist_{$server.sid}" align="center">
															</table>
														</td>
														<td width="355px" class="listtable_2 opener" valign="top">
															<img id="mapimg_{$server.sid}" height='255' width='100%' src='images/maps/nomap.jpg'>
															<br />
															<br />
															<div align='center'>
																<b>IP : Port - {$server.ip}:{$server.port}</b> <br><br>
																<button type='submit' onclick="document.location = 'steam://connect/{$server.ip}:{$server.port}'" name='button' class='btn bgm-teal btn-icon-text waves-effect' id='button'><i class='zmdi zmdi-input-hdmi'></i> Connect</button>
																<button type='button' onclick="ShowBox('refreshing..','<b>Refreshing server details...</b><br><i>Wait!</i>', 'blue', '', true, 1000);document.getElementById('dialog-control').setStyle('display', 'none');xajax_RefreshServer({$server.sid});" name='button' class='btn bgm-amber btn-icon-text waves-effect' id='button' value='Refresh'><i class='zmdi zmdi zmdi-refresh-alt'></i>Refresh status</button>
															</div>
															<br />
														</td>
													</tr>
												</table>
											</div>
											<div id="noplayer_{$server.sid}" name="noplayer_{$server.sid}" style="display:none;">
												<table width="90%" border="0" class="listtable">
													<tr>
														<td align="center" width="90%">
															<h3>No players in server! :(</h3>
														</td>
														<td>
															<div align='center'>
																<img height='255' width='340' src='images/maps/nomap.jpg'>
																<br />
																<br />
																<b>IP : Port - {$server.ip}:{$server.port}</b><br><br>
																<!--<button type='submit' onclick="document.location = 'steam://connect/{$server.ip}:{$server.port}'" name='button' class='btn bgm-teal btn-icon-text waves-effect' id='button'><i class='zmdi zmdi-input-hdmi'></i> Connect</button>-->
																<button type='button' onclick="ShowBox('refreshing..','<b>Refreshing server details...</b><br><i>Please Wait!</i>', 'blue', '', true, 1000);document.getElementById('dialog-control').setStyle('display', 'none');xajax_RefreshServer({$server.sid});" name='button' class='btn bgm-amber btn-icon-text waves-effect' id='button'><i class='zmdi zmdi zmdi-refresh-alt'></i>Refresh status</button>
																<br />
																<br />
															</div>
														</td>
													</tr>
												</table>
												<br><br>
											</div>
									</div>
								</div>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
{else}
	<div class="card">
		<div class="card-header">
			<h2>Our servers <small>List of active game servers at the moment.</small></h2>
		</div>

		<div class="card-body table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th class="text-center">Game</th>
						<th class="text-center hidden-xs">OC</th>
						<th class="text-center hidden-xs">VAC</th>
						<th>Server name</th>
						<th class="text-right">Players</th>
						<th class="text-right hidden-xs">Current map</th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$server_list item=server}
						<tr id="opener_{$server.sid}" style="cursor:pointer;" onmouseout="this.className=''" onmouseover="this.className='active'" onclick="{$server.evOnClick}">
							<td class="text-center"><img src="images/games/{$server.icon}" border="0" /></td>
							<td class="text-center hidden-xs" id="os_{$server.sid}"></td>
							<td class="text-center hidden-xs" id="vac_{$server.sid}"></td>
							<td id="host_{$server.sid}"><i>Getting server details...</i></td>
							<td class="text-right" id="players_{$server.sid}">N/A</td>
							<td class="text-right hidden-xs" id="map_{$server.sid}">N/A</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
{/if}



{if $IN_SERVERS_PAGE}
	<script type="text/javascript">
		InitAccordion('tr.opener', 'div.opener', 'content');
	</script>
{/if}
