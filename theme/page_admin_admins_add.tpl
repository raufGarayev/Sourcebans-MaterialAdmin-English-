{if NOT $permission_addadmin}
	Access denied!
{else}
	<div class="card">
		<div class="form-horizontal" role="form" id="add-group">
			<div class="card-header">
				<h2>Add New Admin <small>Fill blanks with admin details.</small></h2>
			</div>
			<div class="card-body card-padding p-b-0">
				<div class="form-group m-b-5">
					<label for="adminname" class="col-sm-3 control-label">Login</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="adminname" name="adminname" placeholder="Type details">
						</div>
						<div id="name.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="steam" class="col-sm-3 control-label">SteamID</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=2 class="form-control" id="steam" name="steam" placeholder="Type STEAM ID">
						</div>
						<div id="steam.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="email" class="col-sm-3 control-label">E-Mail</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=3 class="form-control" id="email" name="email" placeholder="Type E-mail">
						</div>
						<div id="email.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="password" class="col-sm-3 control-label">Password</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="password" TABINDEX=4 class="form-control" id="password" name="password" placeholder="Type password">
						</div>
						<div id="password.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="password2" class="col-sm-3 control-label">Repeat Password</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="password" TABINDEX=5 class="form-control" id="password2" name="password2" placeholder="Repeat password">
						</div>
						<div id="password.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="a_useserverpass" class="col-sm-3 control-label">Server Password</label>
					<div class="col-sm-9 p-t-10">
						<div class="toggle-switch p-b-5" data-ts-color="red">
							<input type="checkbox" id="a_useserverpass" name="a_useserverpass" TABINDEX=6 onclick="$('a_serverpass').disabled = !$(this).checked;" hidden="hidden" /> 
							<label for="a_useserverpass" class="ts-helper checkbox-inline m-r-20" style="z-index:2;"></label> Enable
						</div>
						<div class="fg-line">
							<input type="password" TABINDEX=7 class="form-control" id="a_serverpass" name="a_serverpass" placeholder="Not neccessary" disabled>
						</div>
						<div id="a_serverpass.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="a_foreverperiod" class="col-sm-3 control-label">{help_icon title="Period" message="For how many days to grant rights to the administrator."} Access</label>
					<div class="col-sm-9 p-t-10">
						<div class="toggle-switch p-b-5" data-ts-color="red">
							<input type="checkbox" id="a_foreverperiod" name="a_foreverperiod" TABINDEX=9 onclick="$('a_period').disabled = $(this).checked;" hidden="hidden" /> 
							<label for="a_foreverperiod" class="ts-helper checkbox-inline m-r-20" style="z-index:2;"></label>Permanently
						</div>
						<div class="fg-line">
							<input type="text" TABINDEX=8 class="form-control" id="a_period" name="a_period" value="30">
						</div>
						<div id="a_period.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="skype" class="col-sm-3 control-label">{help_icon title="Skype" message="Admin Skype contact."} Skype</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=9 class="form-control" id="skype" name="skype" placeholder="Not neccessary">
						</div>
						<div id="skype.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="comment" class="col-sm-3 control-label">{help_icon title="Comment" message="Type comment for admin."} Comment</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<textarea TABINDEX=10 class="form-control p-t-5" id="comment" name="comment" rows="3" placeholder="Type your text (not necessary). HTML supported."></textarea>
						</div>
						<div id="comment.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="vk" class="col-sm-3 control-label">{help_icon title="Instagram" message="Type instagram nickname"} Instagram</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=10 class="form-control" id="vk" name="vk" placeholder="IG nickname (not necessary)">
						</div>
						<div id="vk.msg"></div>
					</div>
				</div>
			</div>
				
				
			<div class="card-header">
				<h2>Server access <small>Choose server or server groups for access..</small></h2>
			</div>
			<div class="card-body card-padding p-b-0">
				<div class="form-group m-b-0">
					<label class="col-sm-3 control-label">Available servers</label>
					<div class="col-sm-9">
						<div class="checkbox">
							<table width="100%" valign="left" id="group.details">
								{foreach from="$group_list" item="group"}
									<tr>
										<td>
											<div class="checkbox m-b-15">
												<label for="g_{$group.gid}_g">
													<input type="checkbox" name="group[]" id="g_{$group.gid}_g" value="g{$group.gid}" hidden="hidden" />
													<i class="input-helper"></i> {$group.name}<b><i> (Server groups)</i></b></span>
												</label>
											</div>
										</td>
									</tr>
								{/foreach}
								{foreach from="$server_list" item="server"}
									<tr>
										<td>
											<div class="checkbox m-b-15">
												<label for="s_{$server.sid}_s">
													<input type="checkbox" name="servers[]" id="s_{$server.sid}_s" value="s{$server.sid}" hidden="hidden" />
													<i class="input-helper"></i> <span id="sa{$server.sid}"><i>Getting server name... {$server.ip}:{$server.port}</i></span>
												</label>
											</div>
										</td>
									</tr>
								{/foreach}
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="card-header">
				<h2>Admin permissions <small>Custom Permissions: Choose this option to give admin custom permissions. <br>New group: Choose this option for choosing custom permissions and saving them in new group. <br>Groups: Choose saved groups.</small></h2>
			</div>
			<div class="card-body card-padding p-b-0" id="group.details">
				<div class="form-group m-b-0">
					<label class="col-sm-3 control-label">Groups</label>
					<div class="col-sm-9">
						<table width="90%" style="border-collapse:collapse;" id="group.details">
							<tr>
								<td>
									<div class="col-xs-6 p-b-10" id="admingroup">
										<select class="selectpicker" TABINDEX=11 onchange="update_server()" name="serverg" id="serverg">
											<optgroup label="Basic">
												<option value="-2">Choose server group</option>
												<option value="-3">No permissions</option>
												<option value="c">Custom permissions</option>
												<option value="n">New group</option>
											</optgroup>
											<optgroup label="Groups">
												{foreach from="$server_admin_group_list" item="server_wg"}
													<option value='{$server_wg.id}'>{$server_wg.name}</option>
												{/foreach}
											</optgroup>
										</select>
									</div>
									<div id="server.msg" class="badentry"></div>
								</td>
							</tr>
							<tr>
								<td colspan="2" id="serverperm" valign="top" style="display: none;"></td>
							</tr>
							<tr>
								<td>
									<div class="col-xs-6 p-b-10" id="webgroup">
										<select TABINDEX=9 onchange="update_web()" name="webg" id="webg" class="selectpicker">
											<optgroup label="Основное">
												<option value="-2">Choose Web admin group</option>
												<option value="-3">No permission</option>
												<option value="c">Custom permissions</option>
												<option value="n">New group</option>
											</optgroup>
											<optgroup label="Groups">
												{foreach from="$server_group_list" item="server_g"}
													<option value='{$server_g.gid}'>{$server_g.name}</option>
												{/foreach}
											</optgroup>
										</select>
									</div>
									<div id="web.msg" class="badentry"></div>
								</td>
							</tr>
							<tr>
								<td colspan="2" id="webperm" valign="top" style="display: none;"></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			
			<div class="card-body card-padding text-center">
				{sb_button text="Add Admin" onclick="ConvertSteamID_3to2('steam');ProcessAddAdmin();" icon="<i class='zmdi zmdi-account-add'></i>" class="bgm-green btn-icon-text" id="aadmin" submit=false}
				&nbsp;
				{sb_button text="Back" onclick="history.go(-1)" icon="<i class='zmdi zmdi-undo'></i>" class="bgm-red btn-icon-text" id="aback"}
			</div>
        {$server_script}
		</div>
	</div>
{/if}
