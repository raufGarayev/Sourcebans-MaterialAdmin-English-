<div class="row">
<div class="card">
                        <form class="form-horizontal" role="form">
                            <div class="card-header">
                                <h2>Authorization <small>-{if $steam_allowed and $login_allowed}-Use your data to enter the control panel, or log in through Steam.-{else}--{if $steam_allowed}-Log in via Steam.-{elseif $login_allowed}-Use your data to log into the control panel.-{/if}--{/if}-</small></h2>
                            </div>
                            
                            <div class="card-body card-padding" >
								<div id="login-content">
									
									<div class="form-group">
										<label for="loginUsername" class="col-sm-2 control-label">Login</label>
										<div class="col-sm-10">
											<div class="fg-line">
												<input type="text" class="form-control input-sm" id="loginUsername" placeholder="Type details">
											</div>
											<div id="loginUsername.msg"></div>
										</div>
									</div>
									<div class="form-group">
										<label for="loginPassword" class="col-sm-2 control-label">Password</label>
										<div class="col-sm-10">
											<div class="fg-line">
												<input type="password" class="form-control input-sm" id="loginPassword" placeholder="Type details">
											</div>
											<div id="loginPassword.msg" class="badentry"></div>
										</div>
									</div>
									
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<div class="toggle-switch p-b-5" data-ts-color="green" id="loginRememberMeDiv">
												<input id="loginRememberMe" type="checkbox" name="remember" value="checked" hidden="hidden" />
												<label for="loginRememberMe" class="ts-helper checkbox-inline m-r-20" style="z-index:2;"></label>Remember?
											</div>
										</div>
									</div>

									
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10" id="loginSubmit">
											-{sb_button text="Sign in" onclick=$redir icon="<i class='zmdi zmdi-long-arrow-tab'></i>" class="btn bgm-blue btn-icon-text" id="alogin" submit=false}-
											-{sb_button text="Forgot password" onclick="window.location.href='index.php?p=lostpassword'" icon="<i class='zmdi zmdi-help-outline'></i>" class="btn-icon-text bgm-orange"}-
										</div>
									</div>
									-{if $steam_allowed}-
									<div class="form-group">
										-{if $login_allowed}-<label class="col-sm-2 control-label">Other methods</label>-{/if}-
										<div class="col-sm-10 p-t-10">
											-{sb_button text="Sign in via Steam" onclick="window.location.href='steam_auth.php?login'" icon="<i class='zmdi zmdi-steam'></i>" class="btn-icon-text bgm-bluegray"}-
										</div>
									</div>
									-{/if}-
								</div>
                        </form>
						</div>
</div>
</div>
					
<script>
	$E('html').onkeydown = function(event){
	    var event = new Event(event);
	    if (event.key == 'enter' ) -{$redir}-
	};$('loginRememberMeDiv').onkeydown = function(event){
	    var event = new Event(event);
	    if (event.key == 'space' ) $('loginRememberMeDiv').checked = true;
	};$('button1').onkeydown = function(event){
	    var event = new Event(event);
	    if (event.key == 'space' ) -{$redir}-
	};
</script>
