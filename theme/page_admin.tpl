<div class="card" id="cpanel">
	<div class="card-header">
		<h2>Settings Panel
			<small>
				Choose management options
			</small>
		</h2>
	</div>

	<div class="card-body">
		<div class="col-sm-12">
			{if $access_admins}
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body bgm-amber card-padding c-white">
						Here you can manage admins of SourceBans system. You can show current admins, add new one and specify overrides
					</div>
					<div class="card-body c-white">
						<button class="btn btn-primary btn-block waves-effect"
							onclick="window.location.href='index.php?p=admin&amp;c=admins'">Admins Management</button>
					</div>
				</div>
			</div>
			{/if}
			{if $access_servers}
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body bgm-teal card-padding c-white">
						Here you can manage servers of SourceBans system. You can add new server, delete and edit current servers.
					</div>
					<div class="card-body c-white">
						<button class="btn btn-primary btn-block waves-effect"
							onclick="window.location.href='index.php?p=admin&amp;c=servers'">Servers Management</button>
					</div>
				</div>
			</div>
			{/if}
			{if $access_groups}
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body card-padding bgm-pink c-white">
						Here you can manage SourceBans groups. You can add new one, edit or delete groups.<br>
					</div>
					<div class="card-body c-white">
						<button class="btn btn-primary btn-block waves-effect"
							onclick="window.location.href='index.php?p=admin&amp;c=groups'">Groups Management</button>
					</div>
				</div>
			</div>
			{/if}
		</div>
		<div class="col-sm-12">
			{if $access_bans}
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body card-padding bgm-lime c-white">
						You want to show, add or remove ban? This section is exactly for that. Either you can view here report or even regards. Ban imports made here also
					</div>
					<div class="card-body c-white">
						<button class="btn btn-primary btn-block waves-effect"
							onclick="window.location.href='index.php?p=admin&amp;c=bans'">Bans Management</button>
					</div>
				</div>
			</div>
			{/if}
			{if $access_comms}
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body card-padding bgm-indigo c-white">
						Here you can view, add, edit or remove mutes/гаги<br><br>
					</div>
					<div class="card-body c-white">
						<button class="btn btn-primary btn-block waves-effect"
							onclick="window.location.href='index.php?p=admin&amp;c=comms'">Mutes/Gags Management</button>
					</div>
				</div>
			</div>
			{/if}
			{if $access_menu}
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body card-padding bgm-cyan c-white">
						Here you can edit, add or remove menus from sidebar<br><br>
					</div>
					<div class="card-body c-white">
						<button class="btn btn-primary btn-block waves-effect"
							onclick="window.location.href='index.php?p=admin&amp;c=menu'">Menu Management</button>
					</div>
				</div>
			</div>
			{/if}
		</div>


		<div class="col-sm-12">
			{if $access_settings}
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body card-padding bgm-brown c-white">
						This section contains main settings. Here you can edit SourceBans view,
						change description, view system log and etc.
					</div>
					<div class="card-body c-white">
						<button class="btn btn-primary btn-block waves-effect"
							onclick="window.location.href='index.php?p=admin&amp;c=settings'">Settings Management</button>
					</div>
				</div>
			</div>
			{/if}
			{if $access_mods}
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body card-padding bgm-gray c-white">
						This section is for adding/editing/removing game MODs<br><br>
					</div>
					<div class="card-body c-white">
						<button class="btn btn-primary btn-block waves-effect"
							onclick="window.location.href='index.php?p=admin&amp;c=mods'">MOD's Management</button>
					</div>
				</div>
			</div>
			{/if}
		</div>

	</div>

	<div class="card-body card-padding p-b-0">
		<div class="form-group m-b-5 col-sm-6">
			<label class="col-sm-5 control-label">Total admins:</label>
			<div class="col-sm-5 control-label" style="text-align: left;">
				{$total_admins}
			</div>
		</div>
		<div class="form-group m-b-5 col-sm-6">
			<label class="col-sm-5 control-label">Total bans:</label>
			<div class="col-sm-5 control-label" style="text-align: left;">
				{$total_bans}
			</div>
		</div>
		<div class="form-group m-b-5 col-sm-6">
			<label class="col-sm-5 control-label">Blocked connections:</label>
			<div class="col-sm-5 control-label" style="text-align: left;">
				{$total_blocks}
			</div>
		</div>
		<div class="form-group m-b-5 col-sm-6">
			<label class="col-sm-5 control-label">Total demo size:</label>
			<div class="col-sm-5 control-label" style="text-align: left;">
				<strong>{$demosize}</strong>
			</div>
		</div>
		<div class="form-group m-b-5 col-sm-6">
			<label class="col-sm-5 control-label">Total servers:</label>
			<div class="col-sm-5 control-label" style="text-align: left;">
				{$total_servers}
			</div>
		</div>
		<div class="form-group m-b-5 col-sm-6">
			<label class="col-sm-5 control-label">Ban protests:</label>
			<div class="col-sm-5 control-label" style="text-align: left;">
				{$total_protests}
			</div>
		</div>
		<div class="form-group m-b-5 col-sm-6">
			<label class="col-sm-5 control-label">Reports:</label>
			<div class="col-sm-5 control-label" style="text-align: left;">
				{$total_submissions}
			</div>
		</div>
		<div class="form-group m-b-5 col-sm-6">
			<label class="col-sm-5 control-label">Protests in archieve:</label>
			<div class="col-sm-5 control-label" style="text-align: left;">
				{$archived_protests}
			</div>
		</div>
		<div class="form-group m-b-5 col-sm-6">
			<label class="col-sm-5 control-label">Reports in archieve:</label>
			<div class="col-sm-5 control-label" style="text-align: left;">
				{$archived_submissions}
			</div>
		</div>
		&nbsp;<br />
	</div>
	&nbsp;
</div>
<br />