<form action="" method="post">
	<input type="hidden" name="cardGroup" value="card_form" />
	<div class="card">
		<div class="card-header">
		<h2>Promokey <small>Activation of the key with which the administrator is automatically added.</small></h2>
		</div>

		{if $param == "0"}
		<div class="card-body card-padding">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group fg-line">
						<label>Ваучер</label>
						<input type="text" class="form-control input-mask" id="pay_v4" name="pay_v4" data-mask="0000-0000-0000-0000" placeholder="Example: 2000 2098 0500 0188">
					</div>
				</div>
			</div>
		</div>
		{else}
		<div class="alert alert-info" role="alert">Your Promokey has been successfully accepted! Continue filling in all the fields and choosing a server. <br /> The activation of the term and administrator rights will start at the next step (activation). <br /> You are using a Promokey: <i><b>{$klu4ik}</b></i></div>
		<div class="form-horizontal" role="form">
			<div class="card-body card-padding p-b-0">
				<div class="form-group m-b-0">
					<label for="user_login" class="col-sm-3 control-label text-right">{help_icon title="Login" message="Type login for accessing Web panel"} Login</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="user_login" name="user_login" placeholder="Type details" />
						</div>
						<div id="name.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-0">
					<label for="password" class="col-sm-3 control-label text-right">{help_icon title="Password" message="Type password for accessing Web panek"} Password</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="password" TABINDEX=1 class="form-control" id="password" name="password" placeholder="Type details" />
						</div>
						<div id="password.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-0">
					<label for="password2" class="col-sm-3 control-label text-right">{help_icon title="Password" message="Confirm password"} Password(confirm)</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="password" TABINDEX=1 class="form-control" id="password2" name="password2" placeholder="Type details" />
						</div>
						<div id="password2.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-0">
					<label for="user_steamid" class="col-sm-3 control-label text-right">{help_icon title="STEAM" message="Enter your real Steam ID to identify and access the panel through the Steam API KEY"} STEAMID</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="user_steamid" name="user_steamid" placeholder="Type details" />
						</div>
						<div id="steam.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-0">
					<label for="user_email" class="col-sm-3 control-label text-right">{help_icon title="E-mail" message="Enter your e-mail. May be needed for password recovery"} E-MAIL</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="user_email" name="user_email" placeholder="Type details" />
						</div>
						<div id="email.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-0">
					<label for="skype" class="col-sm-3 control-label text-right">{help_icon title="Skype" message="Your Skype login"} Skype</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="skype" name="skype" placeholder="Type details" />
						</div>
					</div>
				</div>
				<div class="form-group m-b-0">
					<label for="vk" class="col-sm-3 control-label text-right">{help_icon title="vk" message="Instagram please"} Instagram name</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="vk" name="vk" placeholder="Type details" />
						</div>
					</div>
				</div>
				<div class="form-group m-b-0">
					<label class="col-sm-3 control-label text-right">{help_icon title="Length" message="The current length that is assigned to this Promokey."} Validity</label>
					<div class="col-sm-9 p-t-10">
						{$days}
					</div>
				</div>
				<div class="form-group m-b-0">
					<label class="col-sm-3 control-label text-right">{help_icon title="Group" message="Your Web group in Promokey activation."} Group(web)</label>
					<div class="col-sm-9 p-t-10">
						{$gr_web}
					</div>
				</div>
				<div class="form-group m-b-0">
					<label class="col-sm-3 control-label text-right">{help_icon title="Group" message="Your Server group in Promokey activation"} Group(server)</label>
					<div class="col-sm-9 p-t-10">
						{$gr_srv}
					</div>
				</div>
				{if $servers == ""}
					<div class="form-group m-b-0">
						<label class="col-sm-3 control-label text-right">Available servers</label>
						<div class="col-sm-9">
							<div class="checkbox">
								<table width="100%" valign="left" id="group.details">
										{foreach from="$server_list" item="server"}
											<tr>
												<td>
													<div class="checkbox m-b-15">
														<label for="s_{$server.sid}">
															<input type="checkbox" name="servers[]" id="s_{$server.sid}" value="s{$server.sid}" hidden="hidden" />
															<i class="input-helper"></i> <span id="sa{$server.sid}"><i>Getting server name... {$server.ip}:{$server.port}</i></span>
														</label>
													</div>
												</td>
											</tr>
										{/foreach}
								</table>
							</div>
						</div>
					</div>
				{/if}
			</div>
		</div>
		{$server_script}
		{/if}
		<div class="card-body card-padding text-center">
			{if $param == "0"}
				{sb_button text="Next" icon="<i class='zmdi zmdi-check-all'></i>" class="bgm-green btn-icon-text" id="pay_send" submit=true}
			{else}
				{sb_button text="Activate" onclick="AddAdmin_pay();" icon="<i class='zmdi zmdi-check-all'></i>" class="bgm-green btn-icon-text" id="pay_send_activ" submit=false}
			{/if}
		</div>
	</div>
</form>