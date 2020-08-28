{if not $permission_addserver}
	Access denied
{else}

<div class="card">
	<div class="form-horizontal" role="form" id="add-group1">
		<div class="card-header">
			<h2>{$submit_text} <small>For more information move your mouse on question mark.</small></h2>
		</div>
		<input type="hidden" name="insert_type" value="add">
		<div class="card-body card-padding p-b-0" id="group.details">
			<div class="form-group m-b-5">
				<label for="address" class="col-sm-3 control-label">{help_icon title="Server adress" message="IP adress of server. Either can use domain."} IP/Domain of server:</label>
				<div class="col-sm-9">
					<div class="fg-line">
						<input type="hidden" id="fromsub" value="" />
						<input type="text" TABINDEX=1 class="form-control" id="address" name="address" value="{$ip}" placeholder="Type details">
					</div>
					<div id="address.msg"></div>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label for="port" class="col-sm-3 control-label">{help_icon title="Server Port" message="This is the port that server is running off. Default: 27015"} Server port:</label>
				<div class="col-sm-9">
					<div class="fg-line">
						<input type="hidden" id="fromsub" value="" />
						<input type="text" TABINDEX=1 class="form-control" id="port" name="port" value="{if $port}{$port}{else}{27015}{/if}" placeholder="Type details">
					</div>
					<div id="port.msg"></div>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label for="rcon" class="col-sm-3 control-label">{help_icon title="RCON password" message="RCON password of server. This can be found on server.cfg file next to rcon_password. This will allow admins to adminstrate server from Web Interface."} RCON password:</label>
				<div class="col-sm-9">
					<div class="fg-line">
						<input type="hidden" id="fromsub" value="" />
						<input type="text" TABINDEX=1 class="form-control" id="rcon" name="rcon" value="{$rcon}" placeholder="Type details">
					</div>
					<div id="rcon.msg"></div>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label for="rcon2" class="col-sm-3 control-label">{help_icon title="RCON Password" message="Repeat RCON password"} Confirm RCON:</label>
				<div class="col-sm-9">
					<div class="fg-line">
						<input type="hidden" id="fromsub" value="" />
						<input type="text" TABINDEX=1 class="form-control" id="rcon2" name="rcon2" value="{$rcon}" placeholder="Type details">
					</div>
					<div id="rcon2.msg"></div>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label for="type" class="col-sm-3 control-label">{help_icon title="Server mod" message="Choose server mod."} Server mod:</label>
				<div class="col-sm-4" id="admingroup">
					<select name="mod" TABINDEX=5 onchange="" id="mod" class="selectpicker">
						{if !$edit_server}
		        		<option value="-2">Choose from list...</option>
						{/if}
							{foreach from="$modlist" item="mod"}
								<option value='{$mod.mid}'>{$mod.name}</option>
							{/foreach}
		        	</select>
					<div id="mod.msg"></div>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label for="rcon2" class="col-sm-3 control-label">{help_icon title="Visibility" message="Enabling server on main page."} Visibility:</label>
				<div class="col-sm-9">
					<div class="checkbox m-b-15">
						<label for="enabled">
							<input type="checkbox" id="enabled" name="enabled" checked="checked"  hidden="hidden" />
							<i class="input-helper"></i>
						</label>
					</div>
					<div id="enabled.msg"></div>
				</div>
			</div>
            <div class="form-group m-b-5">
				<label for="priority" class="col-sm-3 control-label">{help_icon title="Priority" message="How much lower number, that much server will be showed up."} Priority:</label>
				<div class="col-sm-9">
					<div class="fg-line">
						<input type="hidden" id="fromsub" value="" />
						<input type="text" TABINDEX=1 class="form-control" id="priority" name="priority" value="{if $priority}{$priority}{else}0{/if}" placeholder="Type">
					</div>
					<div id="priority.msg"></div>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label class="col-sm-3 control-label">{help_icon title="Server groups" message="Choose server groups."} Server groups:</label>
				<div class="col-sm-9">
							<table width="100%" valign="left" id="group.details">
								{foreach from="$grouplist" item="group"}
									<tr>
										<td>
											<div class="checkbox m-b-15">
												<label for="g_{$group.gid}">
													<input type="checkbox" value="{$group.gid}" id="g_{$group.gid}" name="groups[]" hidden="hidden" /> 
													<i class="input-helper"></i> {$group.name}<b><i> (Server group)</i></b></span>
												</label>
											</div>
										</td>
									</tr>
								{/foreach}
								<tr id="nsgroup" valign="top" class="badentry"> 		
								</tr>
							</table>
				</div>
			</div>
		</div>
		<div class="card-body card-padding text-center">
			{if $edit_server}
				{sb_button text=$submit_text onclick="process_edit_server();" icon="<i class='zmdi zmdi-check-all'></i>" class="bgm-green btn-icon-text" id="aserver" submit=true}
			{else}
				{sb_button text=$submit_text onclick="process_add_server();" icon="<i class='zmdi zmdi-plus'></i>" class="bgm-green btn-icon-text" id="aserver" submit=true}
			{/if}
			    &nbsp;
				{sb_button text="Back" onclick="history.go(-1)" icon="<i class='zmdi zmdi-undo'></i>" class="bgm-red btn-icon-text" id="aback"}
		</div>
	</div>
</div>


{/if}
