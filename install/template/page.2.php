<?php
	if(!defined("IN_SB")){echo "You should not be here. Only follow links!";die();}
	if(isset($_POST['postd']))
	{
		if(empty($_POST['server']) ||empty($_POST['port']) ||empty($_POST['username']) ||empty($_POST['database']) ||empty($_POST['prefix']))
		{
			echo "<script>setTimeout(\"ShowBox('Warning!', 'Fill in the required fields.', 'blue', '', true)\", 1000);</script>";
		}
		else
		{
			require(ROOT . "../includes/adodb/adodb.inc.php");
			include_once(ROOT . "../includes/adodb/adodb-errorhandler.inc.php");
			$server = "mysqli://" . $_POST['username'] . ":" . $_POST['password'] . "@" . $_POST['server'] . ":" . $_POST['port'] . "/" . $_POST['database'];
			$db = ADONewConnection($server);
			if(!$db) {
				echo "<script>setTimeout(\"ShowBox('Error', 'Error connecting to database. <br />Check the entered data', 'red', '', true);\", 1200);</script>";
			} else if(strlen($_POST['prefix']) > 9) {
				echo "<script>setTimeout(\"ShowBox('Error', 'Table prefix cannot be longer than 9 characters.<br />Fix it.', 'red', '', true);\", 1200);</script>";
			} else {
				?>
				<form action="index.php?step=3" method="post" name="send" id="send">
					<input type="hidden" name="username" value="<?php echo $_POST['username']?>">
					<input type="hidden" name="password" value="<?php echo $_POST['password']?>">
					<input type="hidden" name="server" value="<?php echo $_POST['server']?>">
					<input type="hidden" name="database" value="<?php echo $_POST['database']?>">
					<input type="hidden" name="port" value="<?php echo $_POST['port']?>">
					<input type="hidden" name="prefix" value="<?php echo $_POST['prefix']?>">
					<input type="hidden" name="apikey" value="<?php echo $_POST['apikey']?>">
					<input type="hidden" name="sb-wp-url" value="<?php echo $_POST['sb-wp-url']?>">
				</form>
				<script>
				$('send').submit();
				</script> <?php
			}
		}
	}
	?>



<div class="card m-b-0" id="messages-main">
	<form action="" method="post" name="submit" id="submit">
		<div class="ms-menu">
			<div class="ms-block p-10">
				<span class="c-black"><b>Progress</b></span>
			</div>

			<div class="listview lv-user" id="install-progress">
				<div class="lv-item media">
					<div class="lv-avatar bgm-orange pull-left">1</div>
					<div class="media-body">
						<div class="lv-title"><del>Step: Licence</del></div>
						<div class="lv-small"><i class="zmdi zmdi-timer-off zmdi-hc-fw c-red"></i> <del>Previous step</del></div>
					</div>
				</div>

				<div class="lv-item media active">
					<div class="lv-avatar bgm-red pull-left">2</div>
					<div class="media-body">
						<div class="lv-title">Step: Database</div>
						<div class="lv-small"><i class="zmdi zmdi-badge-check zmdi-hc-fw c-green"></i> Current Step</div>
					</div>
				</div>

				<div class="lv-item media">
					<div class="lv-avatar bgm-orange pull-left">3</div>
					<div class="media-body">
						<div class="lv-title">Step: System requirements</div>
						<div class="lv-small"><i class="zmdi zmdi-time zmdi-hc-fw c-blue"></i> Next step</div>
					</div>
				</div>

				<div class="lv-item media">
					<div class="lv-avatar bgm-orange pull-left">4</div>
					<div class="media-body">
						<div class="lv-title">Step: Creating tables</div>
						<div class="lv-small"><i class="zmdi zmdi-time zmdi-hc-fw c-blue"></i> Next step</div>
					</div>
				</div>

				<div class="lv-item media">
					<div class="lv-avatar bgm-orange pull-left">5</div>
					<div class="media-body">
						<div class="lv-title">Step: Install</div>
						<div class="lv-small"><i class="zmdi zmdi-time zmdi-hc-fw c-blue"></i> Next step</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="ms-body">
			<div class="listview lv-message">
				<div class="lv-header-alt clearfix">
					<div class="lvh-label">
						<span class="c-black">Info</span>
					</div>
				</div>

				<div class="lv-body p-15">                                    
					Hover your mouse over the icon <img border="0" src="../images/help.png" /> for more information.
				</div>

				<div class="lv-header-alt clearfix">
					<div class="lvh-label">
						<span class="c-black" id="submit-main-full">MySQL Information</span>
					</div>
				</div>
				<div class="lv-body p-15" id="group.details">
					<div class="col-sm-12">
						<div class="form-group col-sm-12">
							<label for="server" class="col-sm-3 control-label"><?php echo HelpIcon("Host", "Enter the IP or address of the MySQL server");?> Server adress</label>
							<div class="col-sm-9">
								<div class="fg-line">
									<input type="text" class="form-control input-sm" id="server" name="server" placeholder="Enter details" value="<?php echo isset($_POST['server'])?$_POST['server']:'localhost';?>" />
								</div>
								<div id="server.msg"></div>
							</div>
						</div>
						
						<div class="form-group col-sm-12">
							<label for="port" class="col-sm-3 control-label"><?php echo HelpIcon("Server port", "Enter the port that MySQL is running on");?> Server port</label>
							<div class="col-sm-9">
								<div class="fg-line">
									<input type="text" class="form-control input-sm" id="port" name="port" placeholder="Enter details" value="<?php echo isset($_POST['port'])?$_POST['port']:3306;?>" />
								</div>
								<div id="port.msg"></div>
							</div>
						</div>
						
						<div class="form-group col-sm-12">
							<label for="username" class="col-sm-3 control-label"><?php echo HelpIcon("Username", "Enter MySQL username");?> Username</label>
							<div class="col-sm-9">
								<div class="fg-line">
									<input type="text" class="form-control input-sm" id="username" name="username" placeholder="Enter details" value="<?php echo isset($_POST['username'])?$_POST['username']:'';?>" />
								</div>
								<div id="user.msg"></div>
							</div>
						</div>
						
						<div class="form-group col-sm-12">
							<label for="password" class="col-sm-3 control-label"><?php echo HelpIcon("Password", "Enter MySQL user password");?> Password</label>
							<div class="col-sm-9">
								<div class="fg-line">
									<input type="password" class="form-control input-sm" id="password" name="password" placeholder="Enter details" value="<?php echo isset($_POST['password'])?$_POST['password']:'';?>" />
								</div>
								<div id="password.msg"></div>
							</div>
						</div>
						
						<div class="form-group col-sm-12">
							<label for="database" class="col-sm-3 control-label"><?php echo HelpIcon("Database", "Enter Database name");?> Database</label>
							<div class="col-sm-9">
								<div class="fg-line">
									<input type="text" class="form-control input-sm" id="database" name="database" placeholder="Enter details" value="<?php echo isset($_POST['database'])?$_POST['database']:'';?>" />
								</div>
								<div id="database.msg"></div>
							</div>
						</div>
						
						<div class="form-group col-sm-12">
							<label for="prefix" class="col-sm-3 control-label"><?php echo HelpIcon("Prefix", "Enter table prefix");?> Table prefix</label>
							<div class="col-sm-9">
								<div class="fg-line">
									<input type="text" class="form-control input-sm" id="prefix" name="prefix" placeholder="Enter details" value="<?php echo isset($_POST['prefix'])?$_POST['prefix']:'sb';?>" />
								</div>
								<div id="database.msg"></div>
							</div>
						</div>
						
						<div class="form-group col-sm-12">
							<label for="apikey" class="col-sm-3 control-label"><?php echo HelpIcon("Steam API key", "Copy and paste your Steam API Key here. It is needed to authorize administrators through Steam.");?> Steam API key (optional)</label>
							<div class="col-sm-9">
								<div class="fg-line">
									<input type="text" class="form-control input-sm" id="apikey" name="apikey" placeholder="Enter details" value="<?php echo isset($_POST['apikey'])?$_POST['apikey']:'';?>" />
								</div>
								<div id="database.msg"></div>
							</div>
						</div>
						
						<div class="form-group col-sm-12">
							<label for="sb-wp-url" class="col-sm-3 control-label"><?php echo HelpIcon("Sourcebans url", "SourceBans system installation address. Example: http://mysite.com/bans/");?> Sourcebans URL</label>
							<div class="col-sm-9">
								<div class="fg-line">
									<input type="text" class="form-control input-sm" id="sb-wp-url" name="sb-wp-url" placeholder="Enter details" value="<?php echo isset($_POST['sb-wp-url'])?$_POST['sb-wp-url']:TryAutodetectURL();?>" />
								</div>
								<div id="database.msg"></div>
							</div>
						</div>
						<div class="p-10" align="center">
							<button onclick="checkAccept()" class="btn btn-primary waves-effect" id="button" name="button">Next</button>
						</div>
						<input type="hidden" name="postd" value="1">
					</div>
				</div>
			</div>
		</div>
	</form>
</div>



<script type="text/javascript">
	$E('html').onkeydown = function(event){
	    var event = new Event(event);
	    if (event.key == 'enter' ) $('submit').submit();
	}
</script>
