<div class="card">
	<div class="form-horizontal" role="form" id="submit-main">
		<div class="card-header">
			<h2>Report player</h2>
		</div>
		<div class="alert alert-info" role="alert">Here you can apply to ban a player violating the server rules. When submitting an application, fill out all the fields and convey your comment as informative as possible. This will serve as a guarantee of the earliest possible consideration of your application.
		Short instruction about recording demo <a href="javascript:void(0)" onclick="ShowBox('How to record Demo?', 'At the moment when you are watching the desired player, press <b>~</b> (</b>`</b>/<b>`</b>) on your keyboard. In the console that opens, enter <b>record [demoname]</b> and press <b>Enter</b>. Either type <b>status</b> to get more information about server. For stopping recording demo, type <b>stop</b>. Demo file will be located in folder <b>csgo</b>.', 'red', '', true);">here</a>
		</div>
			<form action="index.php?p=submit" method="post" enctype="multipart/form-data">
			<input type="hidden" name="subban" value="1">
		<div class="card-body card-padding p-b-0">
			<div class="form-group m-b-5">
				<label for="SteamID" class="col-sm-3 control-label">Players STEAM ID:</label>
				<div class="col-sm-9">
					<div class="fg-line">
					<input type="text" class="form-control" value="{$STEAMID}">
					</div>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label for="BanIP" class="col-sm-3 control-label">Players IP:</label>
				<div class="col-sm-9">
					<div class="fg-line">
						<input type="text" TABINDEX=1 class="form-control" name="BanIP" placeholder="Type details">
					</div>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label for="PlayerName" class="col-sm-3 control-label">Players nickname<span class="mandatory">*</span>:</label>
				<div class="col-sm-9">
					<div class="fg-line">
					<input type="text" class="form-control" name="PlayerName" placeholder="Type details{$player_name}">
					</div>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label for="BanReason" class="col-sm-3 control-label">Comment<span class="mandatory">*</span>:</label>
					<div class="col-sm-9">
					<div class="fg-line">
					<textarea class="form-control auto-size" name="BanReason" placeholder="Please write informative comments. Comments like 'cheater' are not considered {$ban_reason}" style="overflow: hidden; word-wrap: break-word; height: 43px;"></textarea>
					</div>
				</div>
			</div>
			<div class="form-group m-b-5">
					<label for="SubmitName" class="col-sm-3 control-label">Your nick:</label>
				<div class="col-sm-9">
					<div class="fg-line">
					<input type="text" class="form-control" name="SubmitName" placeholder="Type details{$subplayer_name}">
					</div>
				</div>
			</div>
			<div class="form-group m-b-5">
				<label for="EmailAddr" class="col-sm-3 control-label">Your Email<span class="mandatory">*</span>:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="EmailAddr" placeholder="Type details{$player_email}">
				</div>
			</div>
			<div class="form-group m-b-5">
				<label for="server" class="col-sm-3 control-label">Server<span class="mandatory">*</span>:</label>
				<div class="col-sm-3">
				<select class="selectpicker" id="server" name="server">
						<option value="-1">Choose server</option>
						{foreach from="$server_list" item="server}
							<option value="{$server.sid}" {if $server_selected == $server.sid}selected{/if}>{$server.HostName}</option>
						{/foreach}
						<option value="0">Another server not shown here</option>
					</select> 
				</div>
			</div>
			<div class="form-group m-b-5">
				<label class="col-sm-3 control-label">Upload demo:</label>
				<div class="fileinput fileinput-new" data-provides="fileinput">
					<span class="btn btn-primary btn-file m-r-10">
						<span class="fileinput-new">Choose file</span>
							<input type="file" name="...">
					</span>
					<span class="fileinput-filename"></span>
					<a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>
				</div>
			</div>
			<div class="card-body card-padding">
					<p>Notice: File format should be only .dem, <a href="http://www.winzip.com" target="_blank">.zip</a>, <a href="http://www.rarlab.com" target="_blank">.rar</a>, <a href="http://www.7-zip.org" target="_blank">.7z</a>, <a href="http://www.bzip.org" target="_blank">.bz2</a> or <a href="http://www.gzip.org" target="_blank">.gz</a>.</p>
				<p><span class="mandatory">*</span> = Required fields</p>
			</div>
		<div class="card-body card-padding text-center">
			{sb_button text=Send onclick="" icon="<i class='zmdi zmdi-shield-security'></i>" class="bgm-green btn-icon-text" id=save submit=true}
		</div>
		</div>
		<div class="alert alert-info" role="alert">What happens if someone gets banned?</b><br />
		If someone gets banned, his / her unique STEAMID or IP is entered into the SourceBans Database, and every time a player tries to connect to the server, he / she will be blocked with a ban notification.
		</div>
	</div>
</div>
