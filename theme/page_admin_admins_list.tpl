{if not $permission_listadmin}
	Access denied
{else}
	<button onclick="window.location.href='{$btn_href}'" class="btn btn-float btn-danger m-btn" {$btn_helpa}><i class="zmdi {$btn_icon}"></i></button>
	<div class="card-header">
		<h2>Admins List ({if not $btn_rem}Active: {else}Истекших: {/if}<span id="admincount">{$admin_count}</span>) 
			<small>
				Click on admin for more information. {$admin_nav_p}
			</small>
		</h2>

		<ul class="actions" id="banlist-nav">
			{$admin_nav}
		</ul>
		{if $btn_rem}<br>{$btn_rem}{/if}
	</div>
	{php} require (TEMPLATES_PATH . "/admin.admins.search.php");{/php}
	
	<div class="table-responsive" id="banlist">
		<table cellspacing="0" cellpadding="0" class="table table-striped">
			<tr>
				<th>Name</th>
				<th>Access group for server</th>
				<th>Access group for WEB</th>
				<th class="text-right">Expire</th>
			</tr>
			{foreach from="$admins" item="admin"}
				<tr onmouseout="this.className='opener'" onmouseover="this.className='info opener'" class="opener" style="cursor: pointer;">
					<td>
						{$admin.user} / <mark data-toggle="tooltip" data-placement="right" title="" data-original-title="Admin immunity">{$admin.immunity}</mark>
					</td>
					<td>{$admin.server_group}</td>
					<td>{$admin.web_group}</td>
					<td class="text-right">{$admin.expired_text}</td>
				</tr>
				<tr>
					<td colspan="4" style="padding: 0px;border-top: 0px solid #FFFFFF;">
						<div class="opener" style="visibility: visible; zoom: 1; opacity: 1; height: 449px; padding-top: 0px; border-top-style: none; padding-bottom: 0px; border-bottom-style: none; overflow: hidden;">
							<div class="p-20">
							<div class="card" id="profile-main">
								<div class="pm-overview c-overflow">
									<div class="pmo-pic">
										<div class="p-relative">
											<a href="#">
												<img src="{$admin.avatar}">
											</a>
											<a href="http://steamcommunity.com/profiles/{$admin.communityid_profile}" class="pmop-edit" target="_blank">
												<i class="zmdi zmdi-steam"></i> <span class="hidden-xs">Steam profile</span>
											</a>
										</div>
									</div>
									<div class="pmo-block pmo-contact hidden-xs p-t-0">
										<div style="text-align: center;padding-bottom: 20px;"></div>
										<h2>Contact</h2>
										<ul>
											<li><i class="zmdi zmdi-steam" data-toggle="tooltip" data-placement="top" title="" data-original-title="Steam"></i> {$admin.steam_id_amd}</li>
											<li><i class="zmdi zmdi-account-box-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Skype"></i> {$admin.sk_profile}</li>
											<li><i class="zmdi zmdi-email"></i> {$admin.email_profile} (<a href="mailto:{$admin.email_profile}">message</a>)</li>
											<li><i class="zmdi zmdi-vk"></i> {$admin.vk_profile}</li>
										</ul>
									</div>
									
									<div class="pmo-block hidden-xs p-t-0">
										<h2>Permissions</h2>
										
												<a class="btn btn-primary btn-block waves-effect" data-toggle="modal" href="#modalWider_srv{$admin.aid}">
													Server
												</a>
												<br>
												<br>
												<a class="btn btn-primary btn-block waves-effect" data-toggle="modal" href="#modalWider_web{$admin.aid}">
													WEB
												</a>
									</div>
									
									<!-- Modal -->	
									<div class="modal fade" id="modalWider_srv{$admin.aid}" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Info</h4>
												</div>
												<div class="modal-body">
													{$admin.server_flag_string}
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
									<!-- Modal -->
									
									<!-- Modal -->	
									<div class="modal fade" id="modalWider_web{$admin.aid}" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Info</h4>
												</div>
												<div class="modal-body">
													{$admin.web_flag_string}
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
									<!-- Modal -->	
									
									
								</div>
                        
								<div class="pm-body clearfix" id="accordionRed-one" class="collapse in" role="tabpanel">
									{if $permission_editadmin}
										<ul class="tab-nav tn-justified">
											<li class="bgm-lightblue waves-effect"><a class="c-white" href="index.php?p=admin&c=admins&o=editdetails&id={$admin.aid}">Details</a></li>
											<li class="bgm-lightblue waves-effect"><a class="c-white" href="index.php?p=admin&c=admins&o=editpermissions&id={$admin.aid}">Privilegies</a></li>
											<li class="bgm-lightblue waves-effect"><a class="c-white" href="index.php?p=admin&c=admins&o=editservers&id={$admin.aid}">Server</a></li>
											<li class="bgm-lightblue waves-effect"><a class="c-white" href="index.php?p=admin&c=admins&o=editgroup&id={$admin.aid}">Group</a></li>
											{if $allow_warnings}
												<li class="btn-warning waves-effect"><a class="c-white" href="index.php?p=admin&c=admins&o=warnings&id={$admin.aid}">Warnings ({$admin.warnings} from {$maxWarnings})</a></li>
											{/if}
											{if $permission_deleteadmin}
												<li class="btn-danger waves-effect"><a class="c-white" href="#" onclick="{$admin.del_link_d}">Remove</a></li>
											{/if}
										</ul>
									{/if}
									
									
									<div class="pmb-block  p-t-30">
										<div class="pmbb-header">
											<h2><i class="zmdi zmdi-comment m-r-5"></i> Comment</h2>
										</div>
										<div class="pmbb-body p-l-30">
											<div class="pmbb-view">
												{$admin.comment_profile|escape}
											</div>
										</div>
									</div>
									
									<div class="pmb-block p-t-10">
										<div class="pmbb-header">
											<h2><i class="zmdi zmdi-hourglass-alt m-r-5"></i> Visit and period</h2>
										</div>
										<div class="pmbb-body p-l-30">
											<div class="pmbb-view">
												<dl class="dl-horizontal">
													<dt>Access</dt>
													<dd>{$admin.expired_cv}</dd>
												</dl>
												<dl class="dl-horizontal">
													<dt>Last visit</dt>
													<dd>{$admin.lastvisit}</dd>
												</dl>
											</div>
										</div>
									</div>
							   
								
									<div class="pmb-block p-t-10">
										<div class="pmbb-header">
											<h2><i class="zmdi zmdi-fire m-r-5"></i> Bans</h2>
										</div>
										<div class="pmbb-body p-l-30">
											<div class="pmbb-view">
												<dl class="dl-horizontal">
													<dt>Bans without demo</dt>
													<dd>{$admin.bancount} <a href="./index.php?p=banlist&advSearch={$admin.aid}&advType=admin">(Search)</a></dd>
												</dl>
												<dl class="dl-horizontal">
													<dt>Bans with demo</dt>
													<dd>{$admin.nodemocount} <a href="./index.php?p=banlist&advSearch={$admin.aid}&advType=nodemo">(Search)</a></dd>
												</dl>
											</div>
										</div>
									</div>
									<div class="pmb-block p-t-10 m-b-0">
										<div class="pmbb-header">
											<h2>{help_icon title="Support" message="Do you want add this admin on list which is on top right side near search bar?'." style="padding-top: 3px;"} Support-List</h2>
										</div>
										<div class="pmbb-body p-l-30">
											<div class="pmbb-view">
												<dl class="dl-horizontal">
													<dt>Add to list?</dt>
													<dd>
														<div class="toggle-switch p-b-5" data-ts-color="red">
															<input type="checkbox" id="add_support_{$admin.aid}" name="add_support_{$admin.aid}" TABINDEX=9 onclick="xajax_AddSupport({$admin.aid});" hidden="hidden" /> 
															<label for="add_support_{$admin.aid}" class="ts-helper checkbox-inline m-r-20" style="z-index:2;"></label>
														</div>
													</dd>
												</dl>
											</div>
										</div>
									</div>
								</div>
							</div>
							</div>
						</div>
					</td>
				</tr>
			{/foreach}
		</table>
	</div>
	
	<script type="text/javascript">
		{foreach from=$checked_if item=kek}
			$("add_support_{$kek.kid}").checked = 1;
		{/foreach}
	</script>
	<script type="text/javascript">InitAccordion('tr.opener', 'div.opener', 'content');</script>
{/if}
