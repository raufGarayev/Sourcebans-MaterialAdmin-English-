<form action="" method="post">
	<div class="card" id="admin-page-content">
		<div id="0">
		<div class="form-horizontal" role="form" id="add-group">
			<div class="card-header">
				<h2>Ban details <small>For more information move your mouse on question mark.</small></h2>
			</div>
			<input type="hidden" name="insert_type" value="add">
			<div class="card-body card-padding p-b-0" id="group.details">
				<div class="form-group m-b-5">
					<label for="name" class="col-sm-3 control-label">-{help_icon title="Nick of player" message="Nick of banned player."}- Nick of player</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="name" name="name" value="-{$ban_name}-" placeholder="Type details">
						</div>
						<div id="name.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="type" class="col-sm-3 control-label">-{help_icon title="Ban type" message="How to ban, STEAM ID or IP."}- Ban type</label>
					<div class="col-sm-2">
						<select class="selectpicker" id="type"  name="type">
							<option value="0">Steam ID</option>
							<option value="1">IP adress</option>
						</select>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="steam" class="col-sm-3 control-label">-{help_icon title="Steam ID" message="Steam ID of banned player."}- Steam ID</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="steam" name="steam" value="-{$ban_authid}-" placeholder="Type details">
						</div>
						<div id="steam.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="ip" class="col-sm-3 control-label">-{help_icon title="IP adress" message="IP adress of banned player"}- IP adress</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="ip" name="ip" value="-{$ban_ip}-" placeholder="Type details">
						</div>
						<div id="ip.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="txtReason" class="col-sm-3 control-label">-{help_icon title="Ban reason" message="Explan, why you ban."}- Ban reason</label>
					<div class="col-sm-6" id="dreason" style="display:none;">
						<div class="fg-line">
							<input type="text" TABINDEX=4 class="form-control" id="txtReason" name="txtReason" placeholder="Type your own reason...">
						</div>
					</div>
					<div class="col-sm-3 p-t-5">
						<select id="listReason" name="listReason" TABINDEX=4 class="selectpicker" onChange="changeReason(this[this.selectedIndex].value);">
							  <option value="" selected> -- Choose reason -- </option>
							  <optgroup label="Cheats">
								<option value="Aimbot">Aimbot</option>
								<option value="Antirecoil">Antirecoil</option>
								<option value="Wallhack">Wallhack</option>
								<option value="Spinhack">Spinhack</option>
								<option value="Multi-Hack">Multi-Hack</option>
								<option value="No Smoke">No Smoke</option>
								<option value="No Flash">No Flash</option>
							  </optgroup>
							  <optgroup label="Behavior">









								<option value="Teamkill">Убийство союзников</option>
								<option value="Team Flashing">Ослепление союзников</option>
								<option value="Chat/Voice Spam">Chat/Voice spam</option>
								<option value="Inappropriate Spray">Inappropriate Spray</option>
								<option value="Inappropriate Language">Inappropriate Language</option>
								<option value="Inappropriate Name">Inappropriate Name</option>
								<option value="Admin Ignore">Admin Ignore</option>
								<option value="Team Blocking">Team Blocking</option>
								<option value="Insulting">Insulting</option>
								<option value="Advertising">Advertising</option>
							  </optgroup>
							  -{if $customreason}-
								  <optgroup label="Custom">
								  -{foreach from="$customreason" item="creason"}-
									<option value="-{$creason}-">-{$creason}-</option>
								  -{/foreach}-
								  </optgroup>
							  -{/if}-
							  <option value="other">Other Reason</option>
						</select>
					</div>
					<div id="reason.msg"></div>
				</div>
				<div class="form-group m-b-5">
					<label for="banlength" class="col-sm-3 control-label">-{help_icon title="Ban Length" message="Choose ban length."}- Ban Length</label>
					<div class="col-sm-3">
						<select id="banlength" name="banlength" TABINDEX=4 class="selectpicker">
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
					<label for="demo_link" class="col-sm-3 control-label">-{help_icon title="Demo Link" message="Give link of demo from GoogleDisk or YandexDisk or from any another cloud."}- Demo Link</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="demo_link" name="demo_link" -{if $demo_link_val}- value="-{$demo_link_val}-" -{else}- placeholder="Give link(If needed)" -{/if}- />
						</div>
						<div id="demo_link.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label class="col-sm-3 control-label">-{help_icon title="Upload demo" message="Click here, to upload demo."}- Upload demo</label>
					<div class="col-sm-9 p-t-10">
						-{sb_button text="Upload demo" onclick="childWindow=open('pages/admin.uploaddemo.php','upload','resizable=no,width=300,height=130');" class="bgm-orange" id="udemo" submit=false}-
						<div id="demo1.msg" class="contacts c-profile clearfix p-t-20 p-l-0" -{if $ban_demo}- style="display:block;" -{else}- style="display:none;" -{/if}->
							<div class="col-md-3 col-sm-4 col-xs-6 p-l-0 p-r-0">
								<div class="c-item">
									<div href="#" class="ci-avatar text-center f-20 p-t-10">
										<i class="zmdi zmdi-balance-wallet zmdi-hc-fw"></i>
									</div>
																		
									<div class="c-info">
										<strong id="demo.msg">-{$ban_demo}-</strong>
									</div>
																		
									<div class="c-footer c-green f-700 text-center p-t-5 p-b-5">

										Successfully uploaded
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body card-padding text-center">
				<input type="hidden" name="did" id="did" value="" />
			    <input type="hidden" name="dname" id="dname" value="" /> 
				-{sb_button text="Save" icon="<i class='zmdi zmdi-check-all'></i>" class="bgm-green btn-icon-text" id="editban" submit=true}-
			    &nbsp;
			    -{sb_button text="Back" onclick="history.go(-1)" icon="<i class='zmdi zmdi-undo'></i>" class="bgm-red btn-icon-text" id="back" submit=false}-
			</div>
			<script type="text/javascript">
				var did = 0;
				var dname = "";
				function demo(id, name)
				{
					$('demo.msg').setHTML("<b>" + name + "</b>");
					$('demo1.msg').style.display = "block";
					$('did').value = id;
					$('dname').value = name;
				}
			</script>
		</div>
		</div>
	</div>
	
</form>
