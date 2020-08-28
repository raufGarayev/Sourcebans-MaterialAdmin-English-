{if NOT $permission_addgroup}
	Access denied!
{else}
	<div class="card" id="add-group">
		<div class="form-horizontal" role="form" id="group.details">
			<div class="card-header">
				<h2>Add Group <small>You can create here new server or web groups.</small></h2>
			</div>
			<div class="card-body card-padding p-b-0">
				<div class="form-group m-b-5">
					<label for="groupname" class="col-sm-3 control-label">{help_icon title="Group Name" message="Type name for new group."} Group name</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="groupname" name="groupname" placeholder="Type details">
						</div>
						<div id="name.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="grouptype" class="col-sm-3 control-label">{help_icon title="Group Type" message="Choose group type. This will help to specify them and share on categories."} Group Type</label>
					<div class="col-sm-3 p-t-5">
						<select class="selectpicker" onchange="UpdateGroupPermissionCheckBoxes()" name="grouptype" id="grouptype">
							<option value="0">Choose...</option>
							<option value="1">Web Admin Groups</option>
							<option value="2">Server admin groups</option>
							<option value="3">Server groups</option>
						</select>
						<div id="type.msg" class="badentry"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="grouptype" class="col-sm-3 control-label"></label>
					<div class="col-sm-9 p-t-5 p-l-0">
						<div id="perms"></div>
					</div>
				</div>
			</div>
				
			<div class="card-body card-padding text-center">
				{sb_button text="Save" onclick="ProcessGroup();" icon="<i class='zmdi zmdi-check-all'></i>" class="bgm-green btn-icon-text" id="agroup" submit=false}
				&nbsp;
				{sb_button text="Back" onclick="history.go(-1)" icon="<i class='zmdi zmdi-undo'></i>" class="bgm-red btn-icon-text" id="aback"}
			</div>
		</div>
	</div>
{/if}
