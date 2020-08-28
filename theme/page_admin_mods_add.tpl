{if NOT $permission_add}
	Access denied!
{else}
	<div class="form-horizontal" role="form">
		{display_header title="Add MOD" text="For more information move your mouse on question mark."}
		<div class="card-body card-padding clearfix p-b-0">
			{display_material_input name="name" help_title="Mod name" help_text="Type mod name." placeholder="Counter-Strike: Source"}
			<p id="name.msg" style="color:#CC0000;"></p>

			{display_material_input name="folder" help_title="Folder name" help_text="Type mod folder name. E.g. for Counter-Strike: Source folder name is 'cstrike'" placeholder="cstrike"}
			<p id="folder.msg" style="color:#CC0000;"></p>

			{display_material_input name="steam_universe" help_title="Steam universe number" help_text="(STEAM_<b>X</b>:Y:Z) Some games have steamid which differs from others. Type first number of SteamID (<b>X</b>) depending on your mod. (Default: 0)." placeholder="0"}
			{display_material_checkbox name="enabled" help_title="MOD Activation" help_text="Choose to enable MOD"}

			<div class="form-group m-b-5">
				<label for="icon" class="col-sm-3 control-label">{help_icon title="Upload Icon" message="Upload icon" message="Click here to upload icon for MOD."}Upload icon</label>
				<div class="col-sm-9">
					{sb_button text="Upload MOD icon" onclick="childWindow=open('pages/admin.uploadicon.php','upload','resizable=yes,width=300,height=130');" class="save" id="upload"}
				</div>
				<p id="icon.msg" style="color:#CC0000;"></p>
				<input type="hidden" id="icon_hid" name="icon_hid" />
			</div>

			<p class="text-center">{sb_button text="Add MOD" icon="<i class='zmdi zmdi-check-all'></i>" class="bgm-green btn-icon-text" onclick="ProcessMod();" id="amod"}</p>
		</div>
	</div>
{/if}
