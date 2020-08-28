<div class="card" id="lostpassword">
	<div class="form-horizontal" role="form" id="login-content">
		<div class="card-header">
			<h2>Password reset <small>Enter your E-mail in the field so that a password reset confirmation will be sent to it.</small></h2>
		</div>
		<div class="alert alert-success" role="alert" id="msg-blue" style="display:none;">Please check your inbox (and spam folder) for a link to help you reset your password.</div>
		<div class="alert alert-danger" role="alert" id="msg-red" style="display:none;">Email address not registered in the system.</div>
		<div class="card-body card-padding p-b-0">
			<div class="form-group m-b-5" id="loginPasswordDiv">
				<label for="email" class="col-sm-3 control-label">E-Mail</label>
				<div class="col-sm-9">
					<div class="fg-line">
						<input type="text" TABINDEX=1 class="form-control" id="email" name="email" placeholder="Type details">
					</div>
				</div>
			</div>
		</div>
		
		<div class="card-body card-padding text-center" id="loginSubmit">
			{sb_button text="Reset" onclick="xajax_LostPassword($('email').value);" icon="<i class='zmdi zmdi-key'></i>" class="bgm-green btn-icon-text" id=alogin submit=false}
		</div>
		
	</div>
</div>
