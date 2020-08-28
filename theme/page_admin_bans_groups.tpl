{if NOT $permission_addban}
	Access denied!
{else}
	{if NOT $groupbanning_enabled}
		Feature disabled!
	{else}
<div class="card">
	<div class="form-horizontal" role="form" id="group.details">
		{if NOT $list_steam_groups}
		<div class="card-header">
		<h2>Add group ban
		<small>Here you can ban Steam group community. For example <code>http://steamcommunity.com/groups/interwavestudios</code></small></h2>
		</div>
		<div class="card-body card-padding p-b-0" id="group.details">
			<div class="form-group m-b-5">
				<label for="groupurl" class="col-sm-3 control-label">{help_icon title="Link to group" message="Type link of group community on Steam"}Link to group</label>
				<div class="col-sm-9">
					<div class="fg-line">
						<input type="text" TABINDEX=1 class="form-control" id="groupurl" name="groupurl" placeholder="Type details">
					</div>
				<div id="groupurl.msg"></div>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label for="groupreason" class="col-sm-3 control-label">{help_icon title="Group ban reason" message="Write reason why you want ban group."}Group ban reason</label>
					<div class="col-sm-9 p-t-10">
						<div class="fg-line">
							<textarea name="groupreason" id="groupreason" class="form-control p-t-5" placeholder="Be more clear please"></textarea>
						</div>
					</div>
				<div id="groupreason.msg"></div>
			</div>
		<div class="card-body card-padding text-center">
				{sb_button text="Ban group" onclick="ProcessGroupBan();" icon="<i class='zmdi zmdi-shield-security'></i>" class="bgm-green btn-icon-text" id="agban" submit=false}
					  &nbsp;
				{sb_button text="Back" onclick="history.go(-1)" icon="<i class='zmdi zmdi-undo'></i>" class="bgm-red btn-icon-text" id="aback"}
		</div>
		</div>
		{else}
		<div class="card-header">
		<h2>Player groups {$player_name}
		<small>Choose group that you want to ban.</small></h2>
		</div>
		<div class="alert alert-success" role="alert" id="steamGroupStatus" name="steamGroupStatus" style="display:none;"></div>
		<div class="card-body card-padding p-b-0" id="group.details">
		
			<div class="form-group m-b-5" id="steamGroups" name="steamGroups" >
				<label class="col-sm-3 control-label">Groups <mark style="cursor:pointer;" id="tickswitch" name="tickswitch" onclick="TickSelectAll();"> (mark) </mark></label>
					<div class="col-sm-9 p-t-10">
						<div id="steamGroupsText" name="steamGroupsText"> Loading groups...</div>
						<table id="steamGroupsTable" name="steamGroupsTable" border="0" width="500px">
						</table>
					</div>
			</div>
		
			<div class="form-group m-b-5">
				<label for="groupreason" class="col-sm-3 control-label">{help_icon title="Group ban reason" message="Write reason why you want ban group."}Group ban reason </label>
				<div class="col-sm-9 p-t-10">
					<div class="fg-line">
						<textarea name="groupreason" id="groupreason" class="form-control p-t-5" placeholder="Be more clear, please"></textarea>
					</div>
					<div id="groupreason.msg" class="badentry"></div>
				</div>
			</div>
		<script type="text/javascript">$('tickswitch').value = 0;xajax_GetGroups('{$list_steam_groups}');</script>
		</div>
		<div class="card-body card-padding text-center">
			{sb_button text="Ban group" onclick="CheckGroupBan();" icon="<i class='zmdi zmdi-shield-security'></i>" class="bgm-green btn-icon-text" id="gban" submit=false}
			&nbsp;
			{sb_button text="Back" onclick="history.go(-1)" icon="<i class='zmdi zmdi-undo'></i>" class="bgm-red btn-icon-text" id="aback"}
		</div>
		{/if}
	</div>
</div>
	{/if}
{/if}
