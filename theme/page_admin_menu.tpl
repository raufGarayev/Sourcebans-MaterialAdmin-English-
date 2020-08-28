<div id="0">
	<div class="card">
		<div class="card-header">
		<h2>Menu <small>Here you can manage link on sidebar of Sourcebans.</small></h2>
		</div>

		<div class="card-body table-responsive">
				<table width="100%" class="table">
					<thead>
						<tr>
							<th width="5%">Active</th>
							<th width="15%">Name</th>
							<th width="25%">Description</th>
							<th width="15%">Link</th>
							<th width="18%">Action</th>
						</tr>
					</thead>
					<tbody>
						{foreach from=$list item=menu}
							<tr>
								<td>
									<b>{if $menu.enabled == "1"}Yes{else}No{/if}</b> / <mark data-toggle="tooltip" data-placement="right" title="" data-original-title="Priority"> {$menu.priority} </mark>
								</td>
								<td>
									{$menu.text|escape:'html'|stripslashes}
								</td>
								<td>
									{$menu.description|escape:'html'|stripslashes}
								</td>
								<td>
									<a href="{$menu.url}">{$menu.url}</a>
								</td>
								<td class="center">
									{if $menu.system != "1"}<a href="index.php?p=admin&c=menu&o=del&id={$menu.id}">Remove</a> / {/if}<a href="index.php?p=admin&c=menu&o=edit&id={$menu.id}">Edit</a> {if $menu.enabled != "1"}/ <a href="index.php?p=admin&c=menu&o=on&id={$menu.id}">Enable</a> {else}/ <a href="index.php?p=admin&c=menu&o=off&id={$menu.id}">Disable</a>{/if}
								</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
		</div>
	</div>
</div>

<form action="" method="post">
	<div class="card" id="admin-page-content">
		<div id="1" style="display:none;">
		<input type="hidden" name="Link" value="add" />
		<div class="form-horizontal" role="form" id="add-group">
			<div class="card-header">
				<h2>Menu <small>Here you can manage link on sidebar of Sourcebans.</small></h2>
			</div>
			<div class="alert alert-info" role="alert">You can add or replace icons of sidebar links! Icons used from <i>Material Design Iconic Font</i>. Available icons you can view on <a href="http://zavoloklom.github.io/material-design-iconic-font/examples.html" target="_blank">here</a>.</div>
			<div class="card-body card-padding p-b-0" id="group.details">
				<div class="form-group m-b-5">
					<label for="names_link" class="col-sm-3 control-label">{help_icon title="Name" message="Type name of link."} Name</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="names_link" name="names_link" placeholder="Type details" />
						</div>
						<div id="names_link.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="des_link" class="col-sm-3 control-label">{help_icon title="Description" message="Description of link that will be showed on mouse cursor."} Description</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="des_link" name="des_link" placeholder="Type details" />
						</div>
						<div id="des_link.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="url_link" class="col-sm-3 control-label">{help_icon title="Link" message="Link to redirect."} URL</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="url_link" name="url_link" placeholder="Type dtails" />
						</div>
						<div id="url_link.msg"></div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="priora_link" class="col-sm-3 control-label">{help_icon title="Priority" message="Priority of link, to specify where it will be on sidebar, up or down."} Priority</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" TABINDEX=1 class="form-control" id="priora_link" name="priora_link" placeholder="Type details" />
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
				{sb_button text="Add" icon="<i class='zmdi zmdi-check-all'></i>" class="bgm-green btn-icon-text" submit=true}
			    &nbsp;
			    {sb_button text="Back" onclick="history.go(-1)" icon="<i class='zmdi zmdi-undo'></i>" class="bgm-red btn-icon-text" id="back" submit=false}
			</div>
		</div>
		</div>
	</div>
	
</form>
