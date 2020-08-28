<form action="index.php?p=protest" method="post">
	<input type="hidden" name="subprotest" value="1">
	<div class="card">
		<div class="form-horizontal" role="form" id="add-group">
			<div class="card-header">
				<h2>Ban Protest 
					<small>
						<u>What happens when I submit a ban appeal?</u><br />
						The administration will be notified of your protest. Then they will definitely check the details and circumstances of the ban. Usually, the processing time for an application is 24 hours, but remember that for each application, the deadline is individual.<br />
						<u>Notice:</u> Sending applications to the Administration with threats or pleas for unbanning will only lead to the removal of your application. Respect the work and time of the Administration!
					</small>
				</h2>
			</div>
			<div class="card-body card-padding p-b-0">
				<div class="form-group m-b-5">
					<label class="col-sm-3 control-label">Protest details:</label>
					<div class="col-sm-9">
						<div class="col-xs-6 p-l-0" id="webgroup">
							<select onChange="changeType(this[this.selectedIndex].value);" id="Type" name="Type" class="selectpicker">
								<optgroup label="Type">
									<option value="0">Steam ID</option>
									<option value="1">IP adress</option>
								</optgroup>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group m-b-5" id="steam.row">
					<label for="SteamID" class="col-sm-3 control-label">Your SteamID</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" size="40" class="form-control" maxlength="64" value="{$steam_id}" name="SteamID" placeholder="Type details (required)">
						</div>
					</div>
				</div>
				<div class="form-group m-b-5" id="ip.row" style="display: none;">
					<label for="IP" class="col-sm-3 control-label">Your IP</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" size="40" class="form-control" maxlength="64" value="{$ip}" name="IP" placeholder="Type details (required)">
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="PlayerName" class="col-sm-3 control-label">Nick</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" size="40" class="form-control" maxlength="70" value="{$player_name}" name="PlayerName" placeholder="Type details (required)">
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="BanReason" class="col-sm-3 control-label">Reason</label>
					<div class="col-sm-9 p-t-10">
						<div class="fg-line">
							<textarea name="BanReason" cols="30" rows="5" class="form-control p-t-5" placeholder="Your unban depends on the information content / persuasiveness (required)" >{$reason}</textarea>
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="EmailAddr" class="col-sm-3 control-label">Your Email</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" size="40" class="form-control" maxlength="70" value="{$player_email}" name="EmailAddr" placeholder="Type details (required)">
						</div>
					</div>
				</div>
			</div>
			
			<div class="card-body card-padding p-t-10 p-b-10">
				Before proceeding, check <a href="index.php?p=banlist"> banlist </a> for your ban.
				If you think that the ban was issued falsely, then you can write a protest.
			</div>
			
			<div class="card-body card-padding text-center">
				{sb_button text="Отправить" class="bgm-green btn-icon-text" id=alogin icon="<i class='zmdi zmdi-account-add'></i>" submit=true}
			</div>
		</div>
	</div>
</form>
