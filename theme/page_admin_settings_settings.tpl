<form action="" method="post">
	<input type="hidden" name="settingsGroup" value="mainsettings" />
	<div class="card" id="group.details">
		<div class="form-horizontal" role="form">
			<div class="card-header">
				<h2>General Settings<small>For more information move your mouse on question mark.</small></h2>
			</div>
			<div class="card-body card-padding p-b-0">
				<div class="form-group m-b-5">
					<label for="template_title" class="col-sm-3 control-label">{help_icon title="Name" message="Give name for windows that shows on browser."} Name</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="template_title" name="template_title" placeholder="Type details" value="{$config_title}" />
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="template_logo" class="col-sm-3 control-label">{help_icon title="Path to logo" message="Here you can define new path for your logo."} Path to logo</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="template_logo" name="template_logo" placeholder="Type details" value="{$config_logo}" />
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="config_password_minlength" class="col-sm-3 control-label">{help_icon title="Password length" message="Define the shortest length for password."} Min. password length</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="config_password_minlength" name="config_password_minlength" placeholder="Type details" value="{$config_min_password}" />
						</div>
						<div id="minpasslength.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="config_dateformat" class="col-sm-3 control-label">{help_icon title="Date format" message="Here you can define date format, displayed on banlist and other pages."} Date format in details</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="config_dateformat" name="config_dateformat" placeholder="Type details" value="{$config_dateformat}" />
						</div>
						<a href="http://www.php.net/date" target="_blank">See.: PHP date</a>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="config_dateformat2" class="col-sm-3 control-label">{help_icon title="Date format" message="Date format for pages"} Format date for blocks</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="config_dateformat2" name="config_dateformat2" placeholder="Type details" value="{$config_dateformat_ver2}" />
						</div>
						<a href="http://www.php.net/date" target="_blank">See: PHP date</a>
					</div>
				</div>

				{display_material_input name="nulladmin_name" help_title="Unknown admin name" help_text="Here you can define name of admin that doesn't exist on Sourcebans." placeholder="CONSOLE" value=$nulladmin_name}

				<div class="form-group m-b-5 form-inline">
					<label for="sel_timezoneoffset" class="col-sm-3 control-label">{help_icon title="Time zone" message="Define time zone."} Time zone</label>
					<div class="col-sm-5 p-t-5">
						<select class="selectpicker" name="timezoneoffset" id="sel_timezoneoffset">
							{foreach from=$timezones key=tz item=name}
								<option value="{$tz}">{$name|escape:'html'}</option>
							{/foreach}
						</select>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="config_debug" class="col-sm-3 control-label">{help_icon title="Debug mode" message="Enable debugging."} Debug mode</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="config_debug">
								<input type="checkbox" name="config_debug" id="config_debug" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
						</div>
					</div>
				</div>
				{display_material_checkbox name="footer_gendata" help_title="Generation time" help_text="I have no idea what is this :)."}
				
				<div class="form-group m-b-5 form-inline">
					<label for="maintenance" class="col-sm-3 control-label">{help_icon title="System maintenance" message="Choose option for maintenance, then click 'Enable'."} System maintenance</label>
					<div class="col-sm-4 p-t-5">
						<select class="selectpicker" name="maintenance" id="maintenance">
							<option value="themecache">Clear theme cache</option>
							<option value="avatarcache">Clear avatar cache</option>
							<option value="cleancountrycache">Clear country cache</option>
							<option value="bansexpired">Remove expired bans</option>
							<option value="commsexpired">Remove expired comms blocks</option>
							<option value="adminsexpired">Remove expired admins</option>
							<option value="commentsclean">Remove all comments</option>
							<option value="protests">Remove all ban protests</option>
							<option value="reports">Remove all ban submissions(repors)</option>
							<option value="banlogclean">Clear history of blocked connections</option>
							<option value="warningsexpired">Remove expired warnings</option>
							<option value="rehashcountries">Rehash countries on banlist</option>
							<option value="updatecountries">Update GeoIP file</option>
							<option value="optimizebd">Optimize DB</option>
							<option value="avatarupdate">Update avatar cache</option>
							<option value="vouchers">Remove used promokeys</option>
						</select>
					</div>
					<div class="col-sm-2 p-t-5">
						{sb_button text="Execute" icon="<i class='zmdi zmdi-check-all'></i>" class="bgm-green btn-icon-text" id="asettings" onclick="xajax_Maintenance($('maintenance').value);" submit=false}
					</div>
				</div>
			</div>
			
			<div class="card-header">
				<h2>Welcome settings</h2>
			</div>
			<div class="card-body card-padding p-b-0">
				
				<div class="form-group m-b-5">
					<label class="col-sm-3 control-label">{help_icon title="Welcome text" message="Type welcome texts that shows on main page."} Welcome</label>
					<div class="col-sm-9">
						<textarea TABINDEX=6 cols="80" rows="20" id="dash_intro_text" name="dash_intro_text" class="html-editor">{$config_dash_text}</textarea>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="dash_nopopup" class="col-sm-3 control-label">{help_icon title="Disable pop-ups" message="Check this box to disable log pop-up and use direct links."} Disable pop-ups</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="dash_nopopup">
								<input type="checkbox" name="dash_nopopup" id="dash_nopopup" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
						</div>
					</div>
				</div>
				
			</div>
			
			
			<div class="card-header">
				<h2>Page settings</h2>
			</div>
			<div class="card-body card-padding p-b-0">
				
				<div class="form-group m-b-5">
					<label for="enable_protest" class="col-sm-3 control-label">{help_icon title="Enable ban protests" message="Mark to enable ban protests."} Enable ban protests</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="enable_protest">
								<input type="checkbox" name="enable_protest" id="enable_protest" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="admin_list_t" class="col-sm-3 control-label">{help_icon title="Enable admin list" message="Mark to enable admin list."} Enable admin list</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="admin_list_t">
								<input type="checkbox" name="admin_list_t" id="admin_list_t" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="vay4_t" class="col-sm-3 control-label">{help_icon title="Enable Promokeys" message="Mark to enable Promokeys."} Enable Promokeys</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="vay4_t">
								<input type="checkbox" name="vay4_t" id="vay4_t" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="protest_emailonlyinvolved" class="col-sm-3 control-label">{help_icon title="Only send e-mail" message="Check this box to send only one notification to admin who banned the protesting player."} Only send one E-mail</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="protest_emailonlyinvolved">
								<input type="checkbox" name="protest_emailonlyinvolved" id="protest_emailonlyinvolved" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="enable_submit" class="col-sm-3 control-label">{help_icon title="Ban submission" message="Mark to enable ban submissions."} Ban submission</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="enable_submit">
								<input type="checkbox" name="enable_submit" id="enable_submit" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="default_page" class="col-sm-3 control-label">{help_icon title="Main Page" message="Choose main page of Sourcebans."} Main page</label>
					<div class="col-sm-3 p-t-5">
						<select class="selectpicker" name="default_page" id="default_page">
							<option value="0">Home</option>
							<option value="1">Banlist</option>
							<option value="2">Servers</option>
							<option value="3">Ban submission</option>
							<option value="4">Ban protest</option>
						</select>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="block_home" class="col-sm-3 control-label">{help_icon title="Blocks" message="Mark to show blocks on page."} Blocks on main</label>
					<div class="col-sm-3 p-t-5">
						<select class="selectpicker" name="block_home" id="block_home">
							<option value="0">Hide all</option>
							<option value="1">Only Bans</option>
							<option value="2">Only Mutes/Gages</option>
							<option value="3">Show all</option>
						</select>
					</div>
				</div>
				
			</div>
			
			
			<div class="card-header">
				<h2>Banlist settings</h2>
			</div>
			<div class="card-body card-padding p-b-0">
				
				<div class="form-group m-b-5">
					<label for="banlist_bansperpage" class="col-sm-3 control-label">{help_icon title="Bans on page" message="Total bans on page."} Bans on page</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="banlist_bansperpage" name="banlist_bansperpage" placeholder="Type details" value="{$config_bans_per_page}" />
						</div>
						<div id="bansperpage.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="banlist_hideadmname" class="col-sm-3 control-label">{help_icon title="Hide admin name" message="Mark to hide admin name."} Hide admin name</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="banlist_hideadmname">
								<input type="checkbox" name="banlist_hideadmname" id="banlist_hideadmname" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
						</div>
						<div id="banlist_hideadmname.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="banlist_nocountryfetch" class="col-sm-3 control-label">{help_icon title="Do not show country" message="Mark to hide country."}Do not show country</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="banlist_nocountryfetch">
								<input type="checkbox" name="banlist_nocountryfetch" id="banlist_nocountryfetch" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
						</div>
						<div id="banlist_nocountryfetch.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="banlist_hideplayerips" class="col-sm-3 control-label">{help_icon title="Hide IP adress" message="Mark to hide IP adress."}Hide IP adress</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="banlist_hideplayerips">
								<input type="checkbox" name="banlist_hideplayerips" id="banlist_hideplayerips" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
						</div>
						<div id="banlist_hideplayerips.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="banlist_bansperpage" class="col-sm-3 control-label">{help_icon title="Own ban reasons" message="Type your own ban reasons."} Own ban reasons <a href="javascript:void(0)" onclick="MoreFields();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add field" class="f-16 p-l-5"><i class="zmdi zmdi-plus-circle"></i></a></label>
					<div class="col-sm-9">
						{foreach from="$bans_customreason" item="creason"}
							<div class="fg-line">
								<input type="text" TABINDEX=1 class="form-control" placeholder="Type details" name="bans_customreason[]" id="bans_customreason[]" value="{$creason}" />
							</div>
						{/foreach}
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" placeholder="Type details" name="bans_customreason[]" id="bans_customreason[]" />
						</div>
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" placeholder="Type details" name="bans_customreason[]" id="bans_customreason[]" />
						</div>
						<div id="custom.reasons" name="custom.reasons">
						
						</div>
						<div id="bans_customreason.msg"></div>
					</div>
				</div>
				
			</div>
			
			<div class="card-header">
				<h2>E-mail settings</h2>
			</div>
			<div class="card-body card-padding p-b-0">
				<p><span style="color: red;">Give attention!</span><br />If <i>mail()</i> feature is not seted on your web-server, then it is <strong>recommended</strong> to enable and set  SMTP for workable e-mail system.</p>
				
				<!-- SMTP settings start -->
				{display_material_checkbox name="smtp_enabled" help_title="Use SMTP" help_text="Enabling using SMTP instead of mail()"}
				<div id='smtp'>
					{display_material_input name="smtp_host" help_title="Mail server adress" help_text="Here is the address to the SMTP mail server." placeholder="ssl://smtp.yandex.ru" value=$smtp_host}
					{display_material_input name="smtp_port" help_title="Mail server port" help_text="Here is the port to the SMTP mail server. You can ask about port from support of your mail server." placeholder="465" value=$smtp_port}
					{display_material_input name="smtp_username" help_title="Mail account login" help_text="Type name of your e-mail" placeholder="primer@yandex.ru" value=$smtp_username}
					{display_material_input name="smtp_password" help_title="Mail account password" help_text="Password of your account on SMPT server." value="*Hide*" placeholder=""}
					{display_material_input name="smtp_charset" help_title="Message encoding" help_text="Define message encoding. As a rule, UTF-8 or Windows-1251" placeholder="UTF-8" value=$smtp_charset}
					{display_material_input name="smtp_from" help_title="Sender name" help_text="Define 'from who' name of mail." placeholder="[SourceBans] SMTP-sender" value=$smtp_from}
				</div>
				<!-- SMTP settings  end  -->
			</div>
			
            <div class="card-header">
				<h2>Game Cache</h2>
			</div>
			<div class="card-body card-padding p-b-0">
				<p>Caching responses from the game server allows you to get rid of unnecessary load on the game server port, but it can also lead to problems with irrelevant data in the web panel..<br />All responses are saved on the FS of the web server, in the folder <em>data/gc</em><br /><b>Recommended value for storing responses</b>: 30</p>
				
				{display_material_checkbox name="gc_enabled" help_title="Use GC" help_text="Enabling cache"}
                {display_material_input name="gc_entrylf" help_title="Cache lifetime" help_text="Cache lifetime (in seconds)" placeholder="Recommended value: 30" value=$gc_entrylf}
			</div>
            
			<div class="card-body card-padding text-center">
				{sb_button text="Save" icon="<i class='zmdi zmdi-check-all'></i>" class="bgm-green btn-icon-text" id="asettings" submit=true}
				&nbsp;
				{sb_button text="Back" icon="<i class='zmdi zmdi-undo'></i>" class="bgm-red btn-icon-text" id="aback"}
			</div>
		</div>
	</div>
		
</form>
<script>$('sel_timezoneoffset').value = "{$config_time}";
{if $smtp_enabled}$('smtp_enabled').checked = true;{/if}
{if $gc_enabled}$('gc_enabled').checked = true;{/if}
{literal}
$('smtp_enabled').onclick = function() {
	if ($('smtp_enabled').checked == false)
		$('smtp').style.display = "none";
	else
		$('smtp').style.display = "";
}
{/literal}

$('smtp_enabled').onclick();
</script>
