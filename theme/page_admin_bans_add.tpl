{if NOT $permission_addban}
Access denied!
{else}

<div class="card">
	<div class="form-horizontal" role="form" id="add-group1">
		<div class="card-header">
			<h2>Add bans <small>For more information move your mouse on question mark.</small></h2>
		</div>
		<div class="alert alert-info" role="alert">Choose only one option on demo adding! If link for demo specified with "Demo Link" and will be "uploaded file", then "Demo Link" will be ignored on ban adding and "uploaded file" will be showen only.</div>
		<div class="card-body card-padding p-b-0" id="group.details">
			<div class="form-group m-b-5">
				<label for="nickname" class="col-sm-3 control-label">{help_icon title="Nick" message="Type nick of player that you want to ban."} Nick</label>
				<div class="col-sm-9">
					<div class="fg-line">
						<input type="hidden" id="fromsub" value="" />
						<input type="text" TABINDEX=1 class="form-control" id="nickname" name="nickname" placeholder="Type details">
					</div>
					<div id="nick.msg"></div>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label for="type" class="col-sm-3 control-label">{help_icon title="Ban type" message="STEAM ID or IP ban?"} Ban Type</label>
				<div class="col-sm-2">
					<select class="selectpicker" id="type"  name="type">
						<option value="0">Steam ID</option>
						<option value="1">IP adress</option>
					</select>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label for="steam" class="col-sm-3 control-label">{help_icon title="Steam ID / Community ID" message="Steam ID of player that you want to ban."} Steam ID</label>
				<div class="col-sm-9">
					<div class="fg-line">
						<input type="text" TABINDEX=1 class="form-control" id="steam" name="steam" placeholder="Type details">
					</div>
					<div id="steam.msg"></div>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label for="ip" class="col-sm-3 control-label">{help_icon title="IP adress" message="IP adress of player that you want to ban."} IP adress</label>
				<div class="col-sm-9">
					<div class="fg-line">
						<input type="text" TABINDEX=1 class="form-control" id="ip" name="ip" placeholder="Type details">
					</div>
					<div id="ip.msg"></div>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label for="txtReason" class="col-sm-3 control-label">{help_icon title="Ban reason" message="Why you want to ban him."} Ban Reason</label>
				<div class="col-sm-6" id="dreason" style="display:none;">
					<div class="fg-line">
						<input type="text" TABINDEX=4 class="form-control" id="txtReason" name="txtReason" placeholder="Write custom reason">
					</div>
				</div>
				<div class="col-sm-3 p-t-5">
					<select id="listReason" name="listReason" TABINDEX=4 class="selectpicker" onChange="changeReason(this[this.selectedIndex].value);">
						  <option value="" selected>-- Choose reason --</option>
						  {if $customreason}
						  {foreach from="$customreason" item="creason"}
							<option value="{$creason}">{$creason}</option>
						  {/foreach}
						  {/if}
						  <option value="other">Other reason</option>
					</select>
				</div>
				<div id="reason.msg"></div>
			</div>
			<div class="form-group m-b-5">
				<label for="banlength" class="col-sm-3 control-label">{help_icon title="Ban Lenght" message="Choose how long you want to ban."} Ban Lenght</label>
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
			<div class="form-group m-b-5">
				<label for="demo_link" class="col-sm-3 control-label">{help_icon title="Demo Link" message="Give download link of demo from GoogleDisk or YandexDisk or fro many another cloud"} Demo Link</label>
				<div class="col-sm-9">
					<div class="fg-line">
						<input type="text" TABINDEX=1 class="form-control" id="demo_link" name="demo_link" placeholder="Write link(If need)">
					</div>
					<div id="demo_link.msg"></div>
				</div>
			</div>
			{if $demoEnabled}
			<div class="form-group m-b-5">
				<label class="col-sm-3 control-label">{help_icon title="Upload demo" message="Click here to upload demo"} Upload demo</label>
				<div class="col-sm-9 p-t-10">
					{sb_button text="Upload demo" onclick="childWindow=open('pages/admin.uploaddemo.php','upload','resizable=no,width=300,height=130');" class="bgm-orange" id="udemo" submit=false}
					<div id="demo1.msg" class="contacts c-profile clearfix p-t-20 p-l-0" style="display:none;">
						<div class="col-md-3 col-sm-4 col-xs-6 p-l-0 p-r-0">
							<div class="c-item">
								<div href="#" class="ci-avatar text-center f-20 p-t-10">
									<i class="zmdi zmdi-balance-wallet zmdi-hc-fw"></i>
								</div>
																	
								<div class="c-info">
									<strong id="demo.msg"></strong>
								</div>
																	
								<div class="c-footer c-green f-700 text-center p-t-5 p-b-5">
									Successfully uploaded
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			{/if}
			
			
		</div>
		<div class="card-body card-padding text-center">
			{sb_button text="Add ban" onclick="ConvertSteamID_3to2('steam');ProcessBan();" icon="<i class='zmdi zmdi-shield-security'></i>" class="bgm-green btn-icon-text" id="aban" submit=false}
				  &nbsp;
			{sb_button text="Back" onclick="history.go(-1)" icon="<i class='zmdi zmdi-undo'></i>" class="bgm-red btn-icon-text" id="aback"}
		</div>
	</div>
</div>
{/if}
