<form action="" method="post">
	<div class="card" id="admin-page-content">
		<input type="hidden" name="Link" value="edit" />
		<div class="form-horizontal" role="form">
			<div class="card-header">
				<h2>Menu <small>Here you can manage link on sidebar of Sourcebans.</small></h2>
			</div>
			<div class="alert alert-info" role="alert">You can add or replace icons of sidebar links! Icons used from <i>Material Design Iconic Font</i>. Available icons you can view on <a href="http://zavoloklom.github.io/material-design-iconic-font/examples.html" target="_blank">here</a>.
			{if $system}<br /><br />This link is <i>system link</i>. You do not have permission <i>to edit this part of menu</i> and <i>remove it from system permanently</i>.{/if}</div>
			<div class="card-body card-padding p-b-0">
				<div class="form-group m-b-5">
					<label for="names_link" class="col-sm-3 control-label">{help_icon title="Name" message="Type name of link"} Заголовок</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="names_link" name="names_link" value="{$text|escape:'html'}" placeholder="Type details" />
						</div>
						<div id="names_link.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="des_link" class="col-sm-3 control-label">{help_icon title="Description" message="Description of link."} Description</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="des_link" name="des_link" value="{$des}" placeholder="Type details" />
						</div>
						<div id="des_link.msg"></div>
					</div>
				</div>
				{if $system}<input type="hidden" name="url_link" value="{$url}" />{else}<div class="form-group m-b-5">
					<label for="url_link" class="col-sm-3 control-label">{help_icon title="Link" message="Link to redirect."} URL</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="url_link" name="url_link" value="{$url}" placeholder="Type details" />
						</div>
						<div id="url_link.msg"></div>
					</div>
				</div>{/if}
				<div class="form-group m-b-5">
					<label for="priora_link" class="col-sm-3 control-label">{help_icon title="Priority" message="Priority of link, to specify where it will be on sidebar, up or down."} Priority</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="priora_link" name="priora_link" value="{$prior}" placeholder="Type details" />
						</div>
						<div id="priora_link.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="on_link" class="col-sm-3 control-label"> Status</label>
					<div class="col-sm-9">
						<div class="checkbox m-b-15">
							<label for="on_link">
									<input type="checkbox" name="on_link" id="on_link" hidden="hidden" />
								<i class="input-helper"></i> Enable?
							</label>
						</div>
					</div>
				</div>
				{display_material_checkbox name="onNewTab" help_title="Open in new window" help_text="Link will be opened in new window of browser, if this marked."}
				
			</div>
			<div class="card-body card-padding text-center">
				{sb_button text="Save" icon="<i class='zmdi zmdi-check-all'></i>" class="bgm-green btn-icon-text" submit=true}
			    &nbsp;
			    {sb_button text="Back" onclick="history.go(-1)" icon="<i class='zmdi zmdi-undo'></i>" class="bgm-red btn-icon-text" id="back" submit=false}
			</div>
		</div>
	</div>
	
</form>
