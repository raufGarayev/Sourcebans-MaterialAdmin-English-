<div class="row">
	<div class="col-sm-2">
	</div>
	<div class="col-sm-8">
		<div class="card">
			<div class="card-body table-responsive">
				
				<table width="100%" class="table">
					<thead>
						<tr>
							<th width="5%">#</th>
							<th width="25%">Properties</th>
							<th width="70%">Type</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="p-b-5">
								<div class="p-t-5">
									<label class="radio radio-inline m-r-20" for="name">
										<input id="name" name="search_type" type="radio" value="name" hidden="hidden" />
										<i class="input-helper"></i> 
									</label>
								</div>
							</td>
							<td class="p-b-5">
								<div class="p-t-5"><label for="nick" onclick="$('name').checked = true">Player nick</label></div>
							</td>
							<td class="p-b-5">
								<div class="fg-line">
									<input type="text" class="form-control" id="nick" value="" onmouseup="$('name').checked = true" placeholder="Type nick" />
								</div>
							</td>
						</tr>
						<tr>
							<td class="p-b-5">
								<div class="p-t-5">
									<label class="radio radio-inline m-r-20" for="steam_">
										<input id="steam_" name="search_type" type="radio" value="radiobutton" hidden="hidden" />
										<i class="input-helper"></i> 
									</label>
								</div>
							</td>
							<td class="p-b-5">
								<div class="p-t-5"><label for="steamid" onclick="$('steam_').checked = true">SteamID</label></div>
							</td>
							<td class="p-b-5">
								<div class="col-sm-6 p-0">
									<div class="fg-line">
										<input type="text" class="form-control" id="steamid" value="" onmouseup="$('steam_').checked = true" placeholder="Type SteamID" />
									</div>
								</div>
								<div class="col-sm-6 p-t-5 p-r-0">
									<select class="selectpicker" id="steam_match" onmouseup="$('steam_').checked = true">
										<option value="0" selected>Exact match</option>
										<option value="1">Approximate match</option>
									</select>
								</div>
							</td>
						</tr>
						{if !$hideplayerips}
							<tr>
								<td class="p-b-5">
									<div class="p-t-5">
										<label class="radio radio-inline m-r-20" for="ip_">
											<input id="ip_" name="search_type" type="radio" value="radiobutton" hidden="hidden" />
											<i class="input-helper"></i> 
										</label>
									</div>
								</td>
								<td class="p-b-5">
									<div class="p-t-5"><label for="ip" onclick="$('ip_').checked = true">IP adress</label></div>
								</td>
								<td class="p-b-5">
									<div class="fg-line">
										<input type="text" class="form-control" id="ip" value="" onmouseup="$('ip_').checked = true" placeholder="Type IP adress" />
									</div>
								</td>
							</tr>
						{/if}
						<tr>
							<td class="p-b-5">
								<div class="p-t-5">
									<label class="radio radio-inline m-r-20" for="reason_">
										<input id="reason_" name="search_type" type="radio" value="name" hidden="hidden" />
										<i class="input-helper"></i> 
									</label>
								</div>
							</td>
							<td class="p-b-5">
								<div class="p-t-5"><label for="ban_reason" onclick="$('reason_').checked = true">Reason</label></div>
							</td>
							<td class="p-b-5">
								<div class="fg-line">
									<input type="text" class="form-control" id="ban_reason" value="" onmouseup="$('reason_').checked = true" placeholder="Type ban reason" />
								</div>
							</td>
						</tr>
						<tr>
							<td class="p-b-5">
								<div class="p-t-5">
									<label class="radio radio-inline m-r-20" for="date">
										<input id="date" name="search_type" type="radio" value="name" hidden="hidden" />
										<i class="input-helper"></i> 
									</label>
								</div>
							</td>
							<td class="p-b-5">
								<div class="p-t-5"><label for="day" onclick="$('date').checked = true">Date</label></div>
							</td>
							<td class="p-b-5">
								<div class="row">
									<div class="col-sm-12 p-0">
										<div class="col-sm-4">
											<div class="fg-line">
												<input type="text" class="form-control" id="day" value="" onmouseup="$('date').checked = true" placeholder="Day" maxlength="2" />
											</div>
										</div>
										<div class="col-sm-4">
											<div class="fg-line">
												<input type="text" class="form-control" id="month" value="" onmouseup="$('date').checked = true" placeholder="Month" maxlength="2" />
											</div>
										</div>
										<div class="col-sm-4">
											<div class="fg-line">
												<input type="text" class="form-control" id="year" value="" onmouseup="$('date').checked = true" placeholder="Year" maxlength="4" />
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
						
						<tr>
							<td class="p-b-5">
								<div class="p-t-5">
									<label class="radio radio-inline m-r-20" for="length_">
										<input id="length_" name="search_type" type="radio" value="radiobutton" hidden="hidden" />
										<i class="input-helper"></i> 
									</label>
								</div>
							</td>
							<td class="p-b-5">
								<div class="p-t-5"><label onclick="$('length_').checked = true" for="length_type">Lenght</label></div>
							</td>
							<td class="p-b-5">
								<div class="col-sm-2 p-t-5 p-l-0 p-r-0">
									<select class="selectpicker" id="length_type" onmouseup="$('length_').checked = true">
										<option value="e" title="=">=</option>
										<option value="h" title=">">&gt;</option>
										<option value="l" title="<">&lt;</option>
										<option value="eh" title=">=">&gt;=</option>
										<option value="el" title="<=">&lt;=</option>
									</select>
								</div>
								<div class="col-sm-5 p-t-5">
									<div class="fg-line">
										<input type="text" class="form-control" id="other_length" name="other_length" value="" onmouseup="$('length_').checked = true" placeholder="Type lenght" />
									</div>
								</div>
								<div class="col-sm-5 p-t-5 p-r-0 select">
									<select class="form-control" id="length" onmouseup="$('length_').checked = true" onchange="switch_length(this);">
										<option value="0">Permanently</option>
										<optgroup label="минуты">
											<option value="1">  1 minute</option>
											<option value="5">  5 minutes</option>
											<option value="10">  10 minutes</option>
											<option value="15">  15 minutes</option>
											<option value="30">  30 minutes</option>
											<option value="45">  45 minutes</option>
										</optgroup>
										<optgroup label="часы">
											<option value="60">  1 hour</option>
											<option value="120">  2 hours</option>
											<option value="180">  3 hours</option>
											<option value="240">  4 hours</option>
											<option value="480">  8 hours</option>
											<option value="720">  12 hours</option>
										</optgroup>
										<optgroup label="дни">
											<option value="1440">  1 day</option>
											<option value="2880">  2 days</option>
											<option value="4320">  3 days</option>
											<option value="5760">  4 days</option>
											<option value="7200">  5 days</option>
											<option value="8640">  6 days</option>
										</optgroup>
										<optgroup label="недели">
											<option value="10080">  1 week</option>
											<option value="20160">  2 weeks</option>
											<option value="30240">  3 weeks</option>
										</optgroup>
										<optgroup label="месяцы">
											<option value="40320">  1 month</option>
											<option value="80640">  2 months</option>
											<option value="120960">  3 months</option>
											<option value="241920">  6 months</option>
											<option value="483840">  12 months</option>
										</optgroup>
										<option value="other">  Other length in minutes</option>
									</select>
								</div>
							</td>
						</tr>
						
						<tr>
							<td class="p-b-5">
								<div class="p-t-5">
									<label class="radio radio-inline m-r-20" for="ban_type_">
										<input id="ban_type_" name="search_type" type="radio" value="radiobutton" hidden="hidden" />
										<i class="input-helper"></i> 
									</label>
								</div>
							</td>
							<td class="p-b-5">
								<div class="p-t-5"><label for="ban_type" onclick="$('ban_type_').checked = true">Ban Type</label></div>
							</td>
							<td class="p-b-5">
								<div class="col-sm-12 p-r-0 p-l-0">
									<select class="selectpicker" id="ban_type" onmouseup="$('ban_type_').checked = true">
										<option value="0" selected>Steam ID</option>
										<option value="1">IP Adress</option>
									</select>
								</div>
							</td>
						</tr>
						{if !$hideadminname}
							<tr>
								<td class="p-b-5">
									<div class="p-t-5">
										<label class="radio radio-inline m-r-20" for="admin">
											<input id="admin" name="search_type" type="radio" value="radiobutton" hidden="hidden" />
											<i class="input-helper"></i> 
										</label>
									</div>
								</td>
								<td class="p-b-5">
									<div class="p-t-5"><label for="ban_admin" onclick="$('admin').checked = true">Admin</label></div>
								</td>
								<td class="p-b-5">
									<div class="col-sm-12 p-r-0 p-l-0 select">
										<select class="form-control" id="ban_admin" onmouseup="$('admin').checked = true">
											{foreach from="$admin_list" item="admin}
												<option label="{$admin.user}" value="{$admin.aid}">  {$admin.user}</option>
											{/foreach}
										</select>
									</div>
								</td>
							</tr>
						{/if}
						
						<tr>
							<td class="p-b-5">
								<div class="p-t-5">
									<label class="radio radio-inline m-r-20" for="where_banned">
										<input id="where_banned" name="search_type" type="radio" value="radiobutton" hidden="hidden" />
										<i class="input-helper"></i> 
									</label>
								</div>
							</td>
							<td class="p-b-5">
								<div class="p-t-5"><label for="server" onclick="$('where_banned').checked = true">Banned from</label></div>
							</td>
							<td class="p-b-5">
								<div class="col-sm-12 p-t-5 p-r-0 p-l-0 select">
									<select class="form-control" id="server" onmouseup="$('where_banned').checked = true">
										<option label="Web ban" value="0">Web ban</option>
										{foreach from="$server_list" item="server}
											<option value="{$server.sid}" id="ss{$server.sid}">  Getting adress... ({$server.ip}:{$server.port})</option>
										{/foreach}
									</select>
								</div>
							</td>
						</tr>
						{if $is_admin}
							<tr>
								<td class="p-b-5">
									<div class="p-t-5">
										<label class="radio radio-inline m-r-20" for="comment_">
											<input id="comment_" name="search_type" type="radio" value="radiobutton" hidden="hidden" />
											<i class="input-helper"></i> 
										</label>
									</div>
								</td>
								<td class="p-b-5">
									<div class="p-t-5"><label for="ban_comment" onclick="$('comment_').checked = true">Comment</label></div>
								</td>
								<td class="p-b-5">
									<div class="fg-line">
										<input type="text" class="form-control" id="ban_comment" value="" onmouseup="$('comment_').checked = true" placeholder="Type comment" />
									</div>
								</td>
							</tr>
						{/if}
						<tr>
							<td>
							</td>
							<td>
							</td>
							<td>
							</td>
						</tr>
						
					</tbody>
				</table>
				
			</div>
			<div class="card-body p-b-20 text-center">
				{sb_button text="Search" onclick="search_bans();" icon="<i class='zmdi zmdi-search'></i>" class="bgm-green btn-icon-text" id="searchbtn" submit=false}
			</div>
		</div>
	</div>
	<div class="col-sm-2">
	</div>
</div>
{$server_script}
<script>InitAccordion('tr.sea_open', 'div.panel', 'content');</script>
