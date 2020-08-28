<form action="" method="post">
	<input type="hidden" name="pay_card_admin" value="pay_card_add" />	
	<input type="hidden" id="card_gr_web" name="card_gr_web" />
	<input type="hidden" id="card_gr_srv" name="card_gr_srv" />
	<input type="hidden" id="srv_check_int" name="srv_check_int" />
	<div class="card">
		<div class="card-header">
		<h2>Promokeys <small>Promokeys activating adminship or vip automatically after typing.</small></h2>
		</div>
		
		<div class="alert alert-info" role="alert">Before filling blanks, move your mouse on <img border="0" align="absbottom" src="images/help.png" /> , to get more information about Promokeys!</div>
		<div class="form-horizontal" role="form">
		<div class="card-body card-padding p-b-0">
			<div class="form-group m-b-5">
				<label for="card_key" class="col-sm-3 control-label text-right">{help_icon title="Key" message="Maximum length of key: 16 symbols. Only numbers supported"} Key</label>
				<div class="col-xs-4">
					<div class="fg-line">
						<input type="text" TABINDEX=1 class="form-control input-mask" id="card_key" name="card_key" data-mask="0000000000000000" placeholder="Example: 2000209805000188" />
					</div>
				</div>
                    <button type="button" class="btn btn-primary waves-effect m-t-5 btn-icon-text" onclick="$('card_key').value = getPassword(16);"><i class="zmdi zmdi-refresh-alt"></i> Generate</button>
			</div>
			<div class="form-group m-b-5">
				<label for="card_exp" class="col-sm-3 control-label text-right">{help_icon title="Length" message="Type '0', to make length - permanently. Length specified in days."} Admin length</label>
				<div class="col-xs-4">
					<div class="fg-line">
						<input type="text" TABINDEX=1 class="form-control" id="card_exp" name="card_exp" placeholder="Type details" />
					</div>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label class="col-sm-3 control-label text-right">{help_icon title="Group" message="Choose group. This group will be added to admin who activate promokey."} Group(server)</label>
				<div class="col-sm-9 p-t-10">
						<table>
								{foreach from="$server_admin_group_list" item="server_wg"}
								<tr>
										<td>
											<label for="dd_{$server_wg.id}_dd" class="radio radio-inline m-r-20 p-t-0">
												<input type="radio" value="{$server_wg.name}" id="dd_{$server_wg.id}_dd" name="inlineRadioOptions_srv" hidden="hidden" onchange="$('card_gr_srv').value = this.value;" />
												<i class="input-helper"></i> {$server_wg.name}
											</label>
										</td>
								</tr>
								{/foreach}
								<tr>
										<td>
											<label for="no_group_web" class="radio radio-inline m-r-20 p-t-0">
												<input type="radio" value="" id="no_group_web" name="inlineRadioOptions_srv" hidden="hidden" onchange="$('card_gr_srv').value = this.value;" />
												<i class="input-helper"></i> <span class="c-red">No group</span>
											</label>
										</td>
								</tr>
						</table>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label class="col-sm-3 control-label text-right">{help_icon title="Group" message="Choose group. This group will be added to admin who activate promokey."} Group(web)</label>
				<div class="col-sm-9 p-t-10">
						<table>
								{foreach from="$server_group_list" item="server_g"}
								<tr>
										<td>
											<label for="dp_{$server_g.gid}_pd" class="radio radio-inline m-r-20 p-t-0">
												<input type="radio" value="{$server_g.name}" id="dp_{$server_g.gid}_pd" name="inlineRadioOptions_web" hidden="hidden" onchange="$('card_gr_web').value = this.value;" />
												<i class="input-helper"></i> {$server_g.name}
											</label>
										</td>
								</tr>
								{/foreach}
								<tr>
									<td>
										<label for="no_group_srv" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="0" id="no_group_srv" name="inlineRadioOptions_web" hidden="hidden" onchange="$('card_gr_web').value = this.value;" />
											<i class="input-helper"></i> <span class="c-red">No group</span>
										</label>
									</td>
								</tr>
						</table>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label class="col-sm-3 control-label text-right">{help_icon title="Server" message="Choose server where admin will have permissions. If do not choose server(enabling 'Without Server'), then member can choose server by his own on Promokey activation."} Server</label>
				<div class="col-sm-9 p-t-5">
						<table>
								{foreach from="$server_list" item="server"}
									<tr>
										<td>
											<div class="checkbox">
												<label for="s_{$server.sid}_s">
													<input type="checkbox" name="servers[]" id="s_{$server.sid}_s" value="s{$server.sid}" hidden="hidden" onchange="Check_cal();" />
													<i class="input-helper"></i> <span id="sa{$server.sid}"><i>Getting server name... {$server.ip}:{$server.port}</i></span>
												</label>
											</div>
										</td>
									</tr>
								{/foreach}
								<tr>
									<td>
										<div class="checkbox">
											<label for="s_no_srv">
												<input type="checkbox" name="servers[]" id="s_no_srv" name="s_no_srv" value="-1" hidden="hidden" onchange="Check_cal();" />
												<i class="input-helper"></i> <span class="c-red">Without Server</span>
											</label>
										</div>
									</td>
								</tr>
						</table>
				</div>
			</div>
		</div>
		</div>
		<div class="card-body card-padding text-center">
			{sb_button text="Add" icon="<i class='zmdi zmdi-check-all'></i>" class="bgm-green btn-icon-text" id="pay_key_send" submit=true}
			
			{sb_button text="Back" onclick="history.go(-1)" icon="<i class='zmdi zmdi-undo'></i>" class="bgm-red btn-icon-text" id="aback"}
		</div>
	</div>
</form>
{$server_script}