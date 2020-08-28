<div class="admin-content" id="admin-page-content">


<div id="0"> <!-- div ID 0 is the first 'panel' to be shown -->
	<div class="card">
		<div class="card-header">
			<h2>Privilegies <small>Below is a list of the permissions that are available to you.</small></h2>
		</div>
		<div class="card-body card-padding">
			<div class="table-responsive" id="banlist">
				<table cellspacing="0" cellpadding="0" class="table">
					<tr>
						<td width="-{if $warnings_enabled}-30-{else}-33-{/if}-%" valign="top">-{$web_permissions}-</td>
						<td width="-{if $warnings_enabled}-25-{else}-33-{/if}-%" valign="top">-{$server_permissions}-</td>
						<td width="-{if $warnings_enabled}-15-{else}-34-{/if}-%" valign="top"><p class="c-blue">Expire Time</p><ul class="clist clist-star"><li>-{$expired_time}-</li></ul></td>
						-{if $warnings_enabled}-
						<td width="25%" valign="top">
							<p class="c-blue">Warnings: -{$warnings|@count}- from -{$max_warnings}-</p>
							<ul class="clist clist-star">
							-{if $warnings|@count == 0}-
								<li><b>No</b> warnings.</li>
							-{else}-
								-{foreach from=$warnings item=warning}-
								<li>-{$warning.reason}- (active -{if $warning.expires != 0}-till <i>-{$warning.expires|date_format:"%d.%m.%Y"}-</i>-{else}-<i>permanently</i>-{/if}-)</li>
								-{/foreach}-
							-{/if}-
							</ul>
						</td>
						-{/if}-
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>

<div id="1" style="display:none;">
	<div class="card">
-{*
		<div class="form-horizontal" role="form">
			<div class="card-header">
				<h2>Change avatar <small>You can manually change the avatar in the system here.</small></h2>
			</div>

			 потом как-нибудь доделаю :D
			<div class="card-body card-padding">
				<div class="form-group">
					<label class="col-sm-3 control-label">-{help_ic
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label"></label>
					<div class="col-sm-9">
						<div class="fg-line">
							<button type="submit" onclick="xajax_UpdateCacheSteam();" name="button" class="btn btn-primary btn-sm waves-effect" id="button">Update from Steam</button>
						</div>
					</div>
				</div>
			</div>
		</div>
*}-

		<div class="form-horizontal" role="form">
			<div class="card-header">
				<h2>Change E-Mail <small>E-Mail allows you to restore access to your account in case of data loss.</small></h2>
			</div>
			<div class="card-body card-padding">
				
				<div class="form-group">
					<label class="col-sm-3 control-label">-{help_icon title="Current E-Mail" message="This is your current E-mail adress."}- Current E-Mail</label>
					<div class="col-sm-9 control-label" style="text-align: left;">
						-{$email}-
					</div>
				</div>
				
				<div class="form-group">
					<label for="pass1" class="col-sm-3 control-label">-{help_icon title="Current password" message="Type password."}- Password</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="password" onkeyup="checkYourSrvPass();" id="emailpw" value="" class="form-control input-sm" name="emailpw" placeholder="Type details" />
						</div>
						<div id="emailpw.msg"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label for="pass1" class="col-sm-3 control-label">-{help_icon title="New E-mail" message="Type your new e-mail."}- New E-mail</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" onkeyup="checkYourSrvPass();" id="email1" value="" class="form-control input-sm" name="email1" placeholder="Type details" />
						</div>
						<div id="email1.msg"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label for="pass1" class="col-sm-3 control-label">-{help_icon title="Confirm E-mail" message="Enter your e-mail address to exclude an error."}- Confirm E-mail</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" onkeyup="checkYourSrvPass();" id="email2" value="" class="form-control input-sm" name="email2" placeholder="Type details" />
						</div>
						<div id="email2.msg"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label"></label>
					<div class="col-sm-9">
						<div class="fg-line">
							<button type="submit" onclick="checkmail();" name="button" class="btn btn-primary btn-sm waves-effect" id="button">Save</button>
						</div>
					</div>
				</div>
					
				
			</div>
		</div>

		<div class="form-horizontal" role="form">
			<div class="card-header">
				<h2>Security <small>If your account is under threat, urgently change the password for your account!</small></h2>
			</div>
			<div class="card-body card-padding" id="group.details">
					<div class="form-group">
						<label for="current" class="col-sm-3 control-label">Current password</label>
						<div class="col-sm-9">
							<div class="fg-line">
								<input type="password" onblur="xajax_CheckPassword(-{$user_aid}-, $('current').value);" class="form-control input-sm" id="current" name="current" placeholder="Type details">
							</div>
							<div id="current.msg"></div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="pass1" class="col-sm-3 control-label">-{help_icon title="New password" message="Enter the new, desired password here. The minimum length must be: $min_pass_len"}- New password</label>
						<div class="col-sm-9">
							<div class="fg-line">
								<input type="password" onkeyup="checkYourAcctPass();" class="form-control input-sm" id="pass1" name="pass1" placeholder="Type details">
							</div>
							<div id="pass1.msg"></div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="pass2" class="col-sm-3 control-label">-{help_icon title="Repeat password" message="Enter the new, desired password again."}- Repeat password</label>
						<div class="col-sm-9">
							<div class="fg-line">
								<input type="password" onkeyup="checkYourAcctPass();" class="form-control input-sm" id="pass2" name="pass2" placeholder="Type details">
							</div>
							<div id="pass2.msg"></div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label"></label>
						<div class="col-sm-9">
							<div class="fg-line">
								<button type="submit" onclick="xajax_CheckPassword(-{$user_aid}-, $('current').value);dispatch();" name="button" class="btn btn btn-primary btn-sm waves-effect" id="button">Save</button>
							</div>
						</div>
					</div>
			</div>
		</div>

		<div class="form-horizontal" role="form">
			<div class="card-header">
				<h2>Change server password <small>You will need to provide a password on the game server before you can use your admin rights.<br />Click <a href="http://wiki.alliedmods.net/Adding_Admins_%28SourceMod%29#Passwords" title="Info about passwords on Sourcemod" target="_blank"><b>here</b></a> for more information.</small></h2>
			</div>
			<div class="card-body card-padding">
				-{if $srvpwset}-
					<div class="form-group">
						<label for="pass1" class="col-sm-3 control-label">-{help_icon title="Current password" message="Enter your current password so that we know that it is you."}- Current password</label>
						<div class="col-sm-9">
							<div class="fg-line">
								<input type="password" onblur="xajax_CheckSrvPassword(-{$user_aid}-, $('scurrent').value);" class="form-control input-sm" id="scurrent" name="scurrent" placeholder="Type details" />
							</div>
							<div id="scurrent.msg"></div>
						</div>
					</div>
				-{/if}-
				
					
				<div class="form-group">
					<label for="pass1" class="col-sm-3 control-label">-{help_icon title="New password" message="Enter the new server password. The minimum length must be: $min_pass_len"}- New password</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="password" onkeyup="checkYourSrvPass();" id="spass1" value="" class="form-control input-sm" name="spass1" placeholder="Type details" />
						</div>
						<div id="spass1.msg"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label for="pass1" class="col-sm-3 control-label">-{help_icon title="Confirm password" message="Confirm password, please."}- Confirm password</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="password" onkeyup="checkYourSrvPass();" id="spass2" value="" class="form-control input-sm" name="spass2" placeholder="Type details" />
						</div>
						<div id="spass2.msg"></div>
					</div>
				</div>
				
				-{if $srvpwset}-
					<div class="form-group">
						<label for="pass1" class="col-sm-3 control-label">-{help_icon title="Remove password from server" message="Check the box to remove the server password."}- Remove password</label>
						<div class="col-sm-9">
							<div class="fg-line">
								<input type="checkbox" id="delspass" name="delspass" />
							</div>
						</div>
					</div>
				-{/if}-
  
				<div class="form-group">
					<label class="col-sm-3 control-label"></label>
					<div class="col-sm-9">
						<div class="fg-line">
							<button type="submit" onclick="-{if $srvpwset}-xajax_CheckSrvPassword(-{$user_aid}-, $('scurrent').value);-{/if}-srvdispatch();" name="button" class="btn btn btn-primary btn-sm waves-effect" id="button">Save</button>
						</div>
					</div>
				</div>
					
					
			</div>
		</div>

		-{if $allow_change_inf}-
		<div class="form-horizontal" role="form">
			<div class="card-header">
				<h2>Contact <small>Your contact information to contact you.</small></h2>
			</div>
			<div class="card-body card-padding" id="group.details">
					<div class="form-group">
						<label for="current_vk" class="col-sm-3 control-label">Instagram</label>
						<div class="col-sm-9">
							<div class="fg-line">
								<input type="text" class="form-control input-sm" id="current_vk" name="current_vk" -{if NOT $vk}- placeholder="Instagram (only nickname)" -{else}- value="-{$vk}-"-{/if}->
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="current_skype" class="col-sm-3 control-label">Skype</label>
						<div class="col-sm-9">
							<div class="fg-line">
								<input type="text" class="form-control input-sm" id="current_skype" name="current_skype" -{if NOT $skype}- placeholder="Skype login"-{else}-value="-{$skype}-"-{/if}->
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label"></label>
						<div class="col-sm-9">
							<div class="fg-line">
								<button type="submit" onclick="xajax_ChangeAdminsInfos(-{$user_aid}-, $('current_vk').value, $('current_skype').value);" name="button" class="btn btn btn-primary btn-sm waves-effect" id="button">Save</button>
							</div>
						</div>
					</div>
			</div>
		</div>
		-{/if}-
	</div>
</div>

<script>
var error = 0;
	function set_error(count)
	{
		error = count;
	}
function checkYourAcctPass()
	{
		var err = 0;
		
		if($('pass1').value.length < -{$min_pass_len}-)
		{
			$('pass1.msg').setStyle('display', 'block');
			$('pass1.msg').setHTML('Password must be at least -{$min_pass_len}- symbols');
			err++;
		}
		else
		{
			$('pass1.msg').setStyle('display', 'none');
		}
		if($('pass2').value != "" && $('pass2').value != $('pass1').value)
		{	
			$('pass2.msg').setStyle('display', 'block');
			$('pass2.msg').setHTML('Passwords does not match');
			err++;
		}else{
			$('pass2.msg').setStyle('display', 'none');
		}
		if(err > 0)
		{
			set_error(1);
			return false;
		}
		else
		{
			set_error(0);
			return true;
		}	
	}
	function dispatch()
	{
		if($('current.msg').innerHTML == "Invalid password.")
		{
			alert("Incorrect Password");
			return false;
		}
		if(checkYourAcctPass() && error == 0)
		{
			xajax_ChangePassword(-{$user_aid}-, $('pass2').value);
		}
	}
	function checkYourSrvPass()
	{
		if(!$('delspass') || $('delspass').checked == false)
		{
			var err = 0;
			
			if($('spass1').value.length < -{$min_pass_len}-)
			{
				$('spass1.msg').setStyle('display', 'block');
				$('spass1.msg').setHTML('Password must be at least -{$min_pass_len}- symbols');
				err++;
			}
			else
			{
				$('spass1.msg').setStyle('display', 'none');
			}
			if($('spass2').value != "" && $('spass2').value != $('spass1').value)
			{	
				$('spass2.msg').setStyle('display', 'block');
				$('spass2.msg').setHTML('Passwords does not match');
				err++;
			}else{
				$('spass2.msg').setStyle('display', 'none');
			}
			if(err > 0)
			{
				set_error(1);
				return false;
			}
			else
			{
				set_error(0);
				return true;
			}	
		}
		else
		{
			set_error(0);
			return true;
		}	
	}
	function srvdispatch()
	{
		-{if $srvpwset}-
		if($('scurrent.msg').innerHTML == "Invalid password.")
		{
			alert("Неверный пароль");
			return false;
		}
		-{/if}-
		if(checkYourSrvPass() && error == 0 && (!$('delspass') || $('delspass').checked == false))
		{
			xajax_ChangeSrvPassword(-{$user_aid}-, $('spass2').value);
		}
		if($('delspass').checked == true)
		{
			xajax_ChangeSrvPassword(-{$user_aid}-, 'NULL');
		}
	}
	function checkmail()
	{
		var err = 0;
        if($('email1').value == "")
        {
            $('email1.msg').setStyle('display', 'block');
			$('email1.msg').setHTML('Enter new E-mail.');
			err++;
		}else{
			$('email1.msg').setStyle('display', 'none');
		}
        
        if($('email2').value == "")
        {
            $('email2.msg').setStyle('display', 'block');
			$('email2.msg').setHTML('Confirm new E-mail.');
			err++;
		}else{
			$('email2.msg').setStyle('display', 'none');
		}
         
		if(err == 0 && $('email2').value != $('email1').value)
		{	
			$('email2.msg').setStyle('display', 'block');
			$('email2.msg').setHTML('E-mail adresses does not match.');
			err++;
		}
        
        if($('emailpw').value == "")
        {
            $('emailpw.msg').setStyle('display', 'block');
			$('emailpw.msg').setHTML('Enter password.');
			err++;
		}else{
			$('emailpw.msg').setStyle('display', 'none');
		}
        
		if(err > 0)
		{
			set_error(1);
			return false;
		}
		else
		{
			set_error(0);
		}
		if(error == 0)
		{
			xajax_ChangeEmail(-{$user_aid}-, $('email2').value, $('emailpw').value);
		}
	}
</script>
</div>	
