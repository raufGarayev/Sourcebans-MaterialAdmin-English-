<form action="" method="post">
    <input type="hidden" name="settingsGroup" value="features" />
    <div class="card" id="group.features">
		<div class="form-horizontal" role="form">
			<div class="card-header">
				<h2>Options<small>For more information move your mouse on question mark.</small></h2>
			</div>
			<div class="card-body card-padding p-b-0">
			
				<div class="form-group m-b-5">
					<label for="export_public" class="col-sm-3 control-label">{help_icon title="Enable banlist for public" message="Enable mark, to show ban list for public."} Allow ban export</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="export_public">
								<input type="checkbox" name="export_public" id="export_public" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="enable_kickit" class="col-sm-3 control-label">{help_icon title="Enable kick" message="Enable this feature to kick player when he added to ban list."} Enable kick</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="enable_kickit">
								<input type="checkbox" name="enable_kickit" id="enable_kickit" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="enable_groupbanning" class="col-sm-3 control-label">{help_icon title="Enable group bans" message="Enable this feature if you want to enable group bans."} Enable group bans</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="enable_groupbanning">
								<input type="checkbox" name="enable_groupbanning" id="enable_groupbanning" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
							<div id="enable_groupbanning.msg"></div>
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="enable_friendsbanning" class="col-sm-3 control-label">{help_icon title="Enable friends banning" message="Enable this feature if you want ban all friends of player."} Enable friends banning</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="enable_friendsbanning">
								<input type="checkbox" name="enable_friendsbanning" id="enable_friendsbanning" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
							<div id="enable_friendsbanning.msg"></div>
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="enable_adminrehashing" class="col-sm-3 control-label">{help_icon title="Enable reloading admins list" message="Enable this feature if you want to reload admins on every group changes."} Enable reloading admins list</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="enable_adminrehashing">
								<input type="checkbox" name="enable_adminrehashing" id="enable_adminrehashing" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
							<div id="enable_adminrehashing.msg"></div>
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="enable_admininfo" class="col-sm-3 control-label">{help_icon title="Admin Information" message="Showing information(skype,insta, STEAMID) about admin that banned on ban info."} Admin information</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="enable_admininfo">
								<input type="checkbox" name="enable_admininfo" id="enable_admininfo" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="allow_admininfo" class="col-sm-3 control-label">{help_icon title="Information change by admin" message="Allow admin to change IG or Skype by himself?"} Own information changes</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="allow_admininfo">
								<input type="checkbox" name="allow_admininfo" id="allow_admininfo" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
						</div>
					</div>
				</div>
				
				<div class="form-group m-b-5">
					<label for="moder_group_st" class="col-sm-3 control-label">{help_icon title="Moderate groups" message="This feature allow admins to edit all bans(only he have access of editing all bans), but only in server where he have admin rights."} Moderate groups</label>
					<div class="col-sm-3 p-t-5">
						<select class="selectpicker" name="moder_group_st" id="moder_group_st">
							<option value="0">Disable</option>
							{foreach from=$wgroups item=gr}
								<option value="{$gr.gid}"{if $gr.gid == $config_modergroup} selected="selected"{/if}>{$gr.name}</option>
							{/foreach}
						</select>
					</div>
				</div>
				
				{display_material_checkbox name="old_serverside" help_title="Compatibility mod with SB plugins" help_text="Toggles web in compatibility mod with old Sourcebans server plugins."}
				{display_material_checkbox name="demoEnabled" help_title="Demos" help_text="Allows uploading demos to site."}
				
				<div class="form-group form-inline m-b-5">
					<label for="admin_warns" class="col-sm-3 control-label">{help_icon title="Warnings" message="Allows to enable warning system for admins."} Warnings</label>
					
					<div class="col-sm-1 p-t-10">
						<div class="toggle-switch p-b-5" data-ts-color="red">
							<input type="checkbox" id="admin_warns" name="admin_warns" hidden="hidden" /> 
							<label for="admin_warns" class="ts-helper checkbox-inline m-r-20" style="z-index:2;"></label>
						</div>
					</div>
					
					<div class="col-sm-3">
						<div class="fg-line">
							<input type="text" class="form-control" id="admin_warns_max" name="admin_warns_max" placeholder="Maximum warnings" value="{$maxWarnings}" style="width: 100%;" />
						</div>
					</div>
				</div>
			</div>

			<div class="card-body card-padding text-center">
				{sb_button text="Save" icon="<i class='zmdi zmdi-check-all'></i>" class="bgm-green btn-icon-text" id="fsettings" submit=true}
				&nbsp;
				{sb_button text="Back" icon="<i class='zmdi zmdi-undo'></i>" class="bgm-red btn-icon-text" id="fback"}
			</div>
		</div>
	</div>
</form>

{if $old_serverside}<script>$('old_serverside').checked = true;</script>{/if}
{if $warnings_enabled}<script>$('admin_warns').checked = true;</script>{/if}
{if $demoEnabled}<script>$('demoEnabled').checked = true;</script>{/if}

{literal}
<script>$('admin_warns').onclick = function() {
    $('admin_warns_max').disabled = !$('admin_warns').checked;
}
$('admin_warns').onclick();</script>
{/literal}
