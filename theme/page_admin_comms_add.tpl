{if NOT $permission_addban}
	Access denied!
{else}


<div class="card">
	<div class="form-horizontal" role="form" id="add-group1">
		<div class="card-header">
			<h2>Add comms block <small>For more information move your mouse on question mark.</small></h2>
		</div>
		<div class="card-body card-padding p-b-0" id="group.details">
			<div class="form-group m-b-5">
				<label for="nickname" class="col-sm-3 control-label">{help_icon title="Nick" message="Type nick of player that you want to block."} Nick</label>
				<div class="col-sm-9">
					<div class="fg-line">
						<input type="hidden" id="fromsub" value="" />
						<input type="text" TABINDEX=1 class="form-control" id="nickname" name="nickname" placeholder="Type details">
					</div>
					<div id="nick.msg"></div>
				</div>
			</div>
			
			<div class="form-group m-b-5">
				<label for="steam" class="col-sm-3 control-label">{help_icon title="Steam ID" message="Steam ID of player that you want to block."} Steam ID</label>
				<div class="col-sm-9">
					<div class="fg-line">
						<input type="text" TABINDEX=1 class="form-control" id="steam" name="steam" placeholder="Type details">
					</div>
					<div id="steam.msg"></div>
				</div>
			</div>
			
			<div class="form-group m-b-5">
				<label for="type" class="col-sm-3 control-label">{help_icon title="Block type" message="Block chat or voice"}Block type </label>
				<div class="col-sm-2">
					<select class="selectpicker" id="type" name="type">
						<option value="1">Voice</option>
                        <option value="2">Chat</option>
                        <option value="3">Chat &amp; Voice</option>
					</select>
				</div>
			</div>
			
			<div class="form-group m-b-5">
				<label for="listReason" class="col-sm-3 control-label">{help_icon title="Block reason" message="Choose reason of block."} Block reason</label>
				<div class="col-sm-6" id="dreason" style="display:none;">
					<div class="fg-line">
						<input type="text" TABINDEX=4 class="form-control" id="txtReason" name="txtReason" placeholder="Type your own reason...">
					</div>
				</div>
				<div class="col-sm-3 p-t-5">
					<select class="selectpicker" id="listReason" name="listReason" onChange="changeReason(this[this.selectedIndex].value);">
						<option value="" selected> -- Choose reason -- </option>
						{if $customreason}
							{foreach from="$customreason" item="creason"}
								<option value="{$creason}">{$creason}</option>
							{/foreach}
						{/if}
						<option value="other">Own reason</option>
					</select>
				</div>
				<div id="reason.msg"></div>
			</div>
			
			<div class="form-group m-b-5">
				<label for="banlength" class="col-sm-3 control-label">{help_icon title="Block length" message="Choose how long you want to block player."} Block length</label>
				<div class="col-sm-3">
					<select id="banlength" TABINDEX=4 class="selectpicker">
						<option value="0">Permanently</option>
						<optgroup label="Minutes">
						  <option value="1">1 minute</option>
						  <option value="5">5 minutes</option>
						  <option value="10">10 minutes</option>
						  <option value="15">15 minutes</option>
						  <option value="30">30 minutes</option>
						  <option value="45">45 minutes</option>
						</optgroup>
						<optgroup label="Hours">
							<option value="60">1 hour</option>
							<option value="120">2 hours</option>
							<option value="180">3 hours</option>
							<option value="240">4 hours</option>
							<option value="480">8 hours</option>
							<option value="720">12 hours</option>
						</optgroup>
						<optgroup label="Days">
						  <option value="1440">1 day</option>
						  <option value="2880">2 days</option>
						  <option value="4320">3 days</option>
						  <option value="5760">4 days</option>
						  <option value="7200">5 days</option>
						  <option value="8640">6 days</option>
						</optgroup>
						<optgroup label="Weeks">
						  <option value="10080">1 week</option>
						  <option value="20160">2 weeks</option>
						  <option value="30240">3 weeks</option>
						</optgroup>
						<optgroup label="Months">
						  <option value="43200">1 month</option>
						  <option value="86400">2 months</option>
						  <option value="129600">3 months</option>
						  <option value="259200">6 months</option>
						  <option value="518400">12 months</option>
						</optgroup>
					</select>
				</div>
				<div id="length.msg"></div>
			</div>
			
		</div>
		<div class="card-body card-padding text-center">
			{sb_button text="Add block" onclick="ConvertSteamID_3to2('steam');ProcessBan();" icon="<i class='zmdi zmdi-shield-security'></i>" class="bgm-green btn-icon-text" id="aban" submit=false}
				  &nbsp;
			{sb_button text="Back" onclick="history.go(-1)" icon="<i class='zmdi zmdi-undo'></i>" class="bgm-red btn-icon-text" id="aback"}
		</div>
	</div>
</div>

{/if}
