{if $comment}
<!--Код Комментариев-->
<div class="row">
	<div class="card">
		<div class="card-header">
			<h2>{$commenttype} Comment</h2>
		</div>
		<div class="tv-comments">
			<ul class="tvc-lists">
				{foreach from="$othercomments" item="com"}
				<li class="media">
					<a href="#" class="tvh-user pull-left">
						<img class="img-responsive" style="width: 46px;height: 46px;border-radius: 50%;" src="theme/img/profile-pics/1.jpg" alt="">
					</a>
					<div class="media-body">
						<strong class="d-block">{$com.comname}</strong>
						<small class="c-gray">{$com.added} {if $com.editname != ''}last edit {$com.edittime} by {$com.editname}{/if}</small>

						<div class="m-t-10">{$com.commenttxt}</div>

					</div>
				</li>
				{/foreach}
				<li class="p-20">
					<div class="fg-line">
						<textarea class="form-control auto-size" rows="5" placeholder="Your comment...." id="commenttext" name="commenttext">{$commenttext}</textarea>
						<div id="commenttext.msg" class="badentry"></div>
					</div>
					<input type="hidden" name="bid" id="bid" value="{$comment}">
					<input type="hidden" name="ctype" id="ctype" value="{$ctype}">
					{if $cid != ""}
					<input type="hidden" name="cid" id="cid" value="{$cid}">
					{else}
					<input type="hidden" name="cid" id="cid" value="-1">
					{/if}
					<input type="hidden" name="page" id="page" value="{$page}">
					{sb_button text="$commenttype Comment" onclick="ProcessComment();" class="m-t-15 btn-primary btn-sm" id="acom" submit=false}&nbsp;
					{sb_button text="Back" onclick="history.go(-1)" class="m-t-15 btn btn-sm" id="aback"}
				</li>
			</ul>
		</div>
	</div>
</div>
<!--Код Комментариев-->
{else}
<div class="card">
	<div class="card-header">
		<h2>Ban list
			<small>
				Total: {$total_bans}{$ban_nav_p}
			</small>
		</h2>
		
		<div class="actions" id="banlist-nav">
			{$ban_nav}
		</div>
	</div>
	
	<div class="alert alert-info" role="alert" id="bans_hidden" style="display:none;">You are viewing a list of bans that are currently active.</div>
	<div class="alert" role="alert" id="tickswitchlink" style="display:none;"></div>
	
	<div class="table-responsive">
		<table class="table table-bordered">
			<thead>
				<tr>
					{if $view_bans}
					<th width="1%" title="Select All" name="tickswitch" id="tickswitch" onclick="TickSelectAll()" onmouseout="this.className=''" onmouseover="this.className='active'"></th>
					{/if}
					<th width="5%" class="text-center">Game</th>
					<th width="11%" class="text-center">Date</th>
					<th class="text-center">Player</th>
					{if !$hideadminname}
					<th width="15%" class="text-center">Admin</th>
					{/if}
					<th width="20%" class="text-center">Length</th>  
				</tr>
			</thead>
			<tbody>
				{foreach from=$ban_list item=ban name=banlist}
				<tr class="opener" onclick="{if $ban.server_id != 0}xajax_ServerHostPlayers({$ban.server_id}, {$ban.ban_id});{/if}{if $ban.vacshow}xajax_GetVACBan({$ban.ban_id});{/if}" style="cursor: pointer;">
					{if $view_bans}
					<td>
						<label class="checkbox checkbox-inline m-r-20" for="chkb_{$smarty.foreach.banlist.index}" onclick="event.cancelBubble = true;">
							<input type="checkbox" name="chkb_{$smarty.foreach.banlist.index}" id="chkb_{$smarty.foreach.banlist.index}" value="{$ban.ban_id}" hidden="hidden" />
							<i class="input-helper"></i>
						</label>
					</td>
					{/if}
					<td class="text-center">{$ban.mod_icon}</td>
					<td class="text-center">{$ban.ban_date_info}</td>
					<td>
						<div style="float:left;">{if not $nocountryshow}{$ban.country_icon}{/if}
							{if empty($ban.player)}
							<i>player name not specified</i>
							{else}
							{$ban.player|escape:'html'|stripslashes}
							{/if}
						</div>
						{if $ban.demo_available}
						<div style="float:right;" class="f-20">
							<i class="zmdi zmdi-videocam"></i>
						</div>
						{/if}
						{if $view_comments && $ban.commentdata != "None" && $ban.commentdata|@count > 0}
						<div style="float:right;padding-right: 5px;">
							{$ban.commentdata|@count} <img src="theme/img/comm.png" alt="Comments" title="Comments" style="height:14px;width:14px;" />
						</div>
						{/if}
					</td>
					{if !$hideadminname}
					<td class="text-center">
						{if !empty($ban.admin)}
						{$ban.admin|escape:'html'}
						{else}
						<i>Admin removed</i>
						{/if}
					</td>
					{/if}
					<td class="{$ban.class}">{if not $ban.ub_reason}
						{$ban.banlength}
						{else}
						{$ban.ub_reason}
						{/if}
					</td>
				</tr>
				<!-- ###############[ Start Sliding Panel ]################## -->
				<tr>
					<td colspan="7" style="padding: 0px;border-top: 0px solid #FFFFFF;">
						<div class="opener"> 
							<div class="card-header bgm-bluegray">
								<h2>Ban info:</h2>

								<ul class="actions actions-alt">
									<li class="dropdown">
										<a href="#" data-toggle="dropdown" aria-expanded="false">
											<i class="zmdi zmdi-more-vert"></i>
										</a>

										<ul class="dropdown-menu dropdown-menu-right">
											{if $view_bans}
											{if $ban.unbanned && $ban.reban_link != false}
											<li>{$ban.reban_link}</li>
											{/if}
											<li>{$ban.blockcomm_link}</li>
											{if $ban.demo_available}
											<li>{$ban.demo_link}</li>
											{/if}
											<li>{$ban.addcomment}</li>
											{if $ban.type == 0}
											{if $groupban}
											<li>{$ban.groups_link}</li>
											{/if}
											{if $friendsban}
											<li>{$ban.friend_ban_link}</li>
											{/if}
											{/if}
											{if ($ban.view_edit && !$ban.unbanned)} 
											<li>{$ban.edit_link}</li>
											{/if}
											{if ($ban.unbanned == false && $ban.view_unban)}
											<li>{$ban.unban_link}</li>
											{/if}
											{if $ban.view_delete}
											<li>{$ban.delete_link}</li>
											{/if}
											{else}
											<li>{$ban.demo_link}</li>
											{/if}
										</ul>
									</li>
								</ul>
							</div>
							<div class="card-body card-padding">
								<div class="form-group col-sm-7" style="font-size: 14px;">
									<div class="form-group col-sm-12 m-b-5">
										<label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i>  Player</label>
										<div class="col-sm-8">
											{if empty($ban.player)}
											<i>player name not specified.</i>
											{else}
											{$ban.player|escape:'html'|stripslashes}
											{/if}
										</div>
									</div>
									<div class="form-group col-sm-12 m-b-5">
										<label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Steam ID</label>
										<div class="col-sm-8">
											{if empty($ban.steamid)}
											<i>STEAM ID not specified.</i>
											{else}
											{$ban.steamid}
											{/if}
										</div>
									</div>
									<div class="form-group col-sm-12 m-b-5">
										<label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Steam3 ID</label>
										<div class="col-sm-8">
											{if empty($ban.steamid)}
											<i>Steam3 ID not specified.</i>
											{else}
											<a href="http://steamcommunity.com/profiles/{$ban.steamid3}" target="_blank">{$ban.steamid3}</a>
											{/if}
										</div>
									</div>
									{if $ban.type == 0}
									<div class="form-group col-sm-12 m-b-5">
										<label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Steam Community</label>
										<div class="col-sm-8">
											<a href="http://steamcommunity.com/profiles/{$ban.communityid}" target="_blank">{$ban.communityid}</a>
										</div>
									</div>
									{/if}
									{if $ban.vacshow}
									<div class="form-group col-sm-12 m-b-5">
										<label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> VAC-ban</label>
										<div class="col-sm-8">
											<strong id="vacban_{$ban.ban_id}">Loading...</strong>
										</div>
									</div>
									{/if}
									{if !$hideplayerips}
									{if $ban.ip != "none"}
									<div class="form-group col-sm-12 m-b-5">
										<label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> IP adress</label>
										<div class="col-sm-8">
											<a href="https://whatismyipaddress.com/ip/{$ban.ip}" target="_blank" title="View IP adress details">{$ban.country_icon}{$ban.ip}</a>
										</div>
									</div>
									{/if}
									{/if}
									<div class="form-group col-sm-12 m-b-5">
										<label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Issued</label>
										<div class="col-sm-8">
											{$ban.ban_date}
										</div>
									</div>
									<div class="form-group col-sm-12 m-b-5">
										<label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Length</label>
										<div class="col-sm-8">
											{if $ban.ub_reason}<del>{$ban.banlength}</del> {$ban.ub_reason}{else}{$ban.banlength}{/if}
										</div>
									</div>
									{if $ban.unbanned}
									<div class="form-group col-sm-12 m-b-5">
										<label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Unban reason</label>
										<div class="col-sm-8">
											{if $ban.ureason == ""}
											<i>Unban reason not specified.</i>
											{else}
											{$ban.ureason}
											{/if}
										</div>
									</div>
									<div class="form-group col-sm-12 m-b-5">
										<label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Admin unbanned</label>
										<div class="col-sm-8">
											{if !empty($ban.removedby)}
											{$ban.removedby|escape:'html'}
											{else}
											<i>Admin removed.</i>
											{/if}
										</div>
									</div>
									{/if}
									<div class="form-group col-sm-12 m-b-5">
										<label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Expire</label>
										<div class="col-sm-8">
											{if $ban.expires == "never"}
											<i>Never.</i>
											{else}
											{$ban.expires}
											{/if}
										</div>
									</div>
									<div class="form-group col-sm-12 m-b-5">
										<label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Ban reason</label>
										<div class="col-sm-8">
											{$ban.reason|escape:'html'}
										</div>
									</div>
										<!--
										{if !$hideadminname}
											<div class="form-group col-sm-12 m-b-5">
												<label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Admin banned</label>
												<div class="col-sm-8">
													{if !empty($ban.admin)}
														{$ban.admin|escape:'html'}
													{else}
														<i>Admin removed.</i>
													{/if}
												</div>
											</div>
										{/if}
									-->
									<div class="form-group col-sm-12 m-b-5">
										<label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Server</label>
										<div class="col-sm-8" id="ban_server_{$ban.ban_id}">
											{if $ban.server_id == 0}
											Web ban
											{else}
											Please, wait...
											{/if}
										</div>
									</div>
									<div class="form-group col-sm-12 m-b-5">
										<label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Previous bans</label>
										<div class="col-sm-8">
											{$ban.prevoff_link}
										</div>
									</div>
									<div class="form-group col-sm-12 m-b-5">
										<label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Blocks ({$ban.blockcount})</label>
										<div class="col-sm-8">
											{if $ban.banlog == ""}
											<i>never...</i>
											{else}
											{if $ban.blockcount >= "5"}
											{help_icon title="Blocks" message="This player had too many blocks when logging into the server, so the list was complete."} 
											<a data-toggle="modal" href="#block_spoiler_{$ban.ban_id}_ply">
												Show all {$ban.blockcount} blocks.
											</a>
											<div class="modal fade" id="block_spoiler_{$ban.ban_id}_ply" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<h4 class="modal-title">
																Blocks list: 
																{if empty($ban.player)}
																<i><del>Hided :(</del></i>
																{else}
																{$ban.player|escape:'html'|stripslashes}
																{/if}
															</h4>
														</div>
														<div class="modal-body">
															<p>{$ban.banlog}</p>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-link bgm-blue c-white waves-effect" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>
											{else}
											{$ban.banlog}
											{/if}
											{/if}
										</div>
									</div>
								</div>
								<div class="form-group col-sm-5">
									{if !$hideadminname}
									<div class="wall-comment-list">

										<div class="pmo-block pmo-contact" style="font-size: 14px;">
											<div class="lv-header c-bluegray p-b-5 p-t-0" style="border-bottom: 2px solid #607d8b;">Block issued:</div>
											<ul>
												<li class="p-b-5">
													<i class="zmdi zmdi-star c-red f-20"></i> 
													{if !empty($ban.admin)}
													{if $ban.admin != "CONSOLE"}
													<b>{$ban.admin|escape:'html'}</b>
													{else}
													<b>{$ConsoleName|escape:'html'}</b>
													{/if}
													{else}
													<b>Admin removed</b>
													{/if}
												</li>
												{if $ban.admin != "CONSOLE"}
												{if !empty($ban.admin)}
												{if $admininfos}
												<li class="p-b-5"><i class="zmdi zmdi-steam"></i> {if !empty($ban.admin_authid)}{$ban.admin_authid} (<a href="http://steamcommunity.com/profiles/{$ban.admin_authid_link}" target="_blank">Profile</a>){else}No data...{/if}</li>
												<li class="p-b-5"><i class="zmdi zmdi-vk"></i> {if !empty($ban.admin_vk)}<a href="https://vk.com/{$ban.admin_vk}" target="_blank">Линк</a>{else}No data...{/if}</li>
												<li class="p-b-5"><i class="zmdi zmdi-account-box-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Skype"></i> {if !empty($ban.admin_skype)}{$ban.admin_skype}{else}No data...{/if}</li>
												<li class="p-b-5">
													<i class="zmdi zmdi-info-outline" data-toggle="tooltip" data-placement="top" title="" data-original-title="Comment"></i>
													<address class="m-b-0 ng-binding">
														{if !empty($ban.admin_comm)}
														{$ban.admin_comm}
														{else}
														No data. Regular private, controls order on servers.
														{/if}
													</address>
												</li>
												{/if}
												{/if}
												{/if}
											</ul>
										</div>
									</div>
									{/if}
									<!-- COMMENT CODik-->
									<hr class="m-t-10 m-b-10" />
									<div class="wall-comment-list">
										{if $ban.commentdata != "None"}
										<div class="wcl-list">
											{foreach from=$ban.commentdata item=commenta}
											<div class="media">
												<a href="#" class="pull-left">
													<img src="theme/img/profile-pics/4.jpg" alt="" class="lv-img-sm">
												</a>

												<div class="media-body">
													<a href="#" class="a-title">{if !empty($commenta.comname)}{$commenta.comname|escape:'html'}{else}<i>Admin removed</i>{/if}</a> {if $commenta.edittime != "none"}<small class="c-gray m-l-10">edited {if $commenta.editname != "none"}{$commenta.editname}{else}<i>Admin removed</i>{/if} в {$commenta.edittime}</small>{/if}
													<p class="m-t-5 m-b-0" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">{$commenta.commenttxt}</p>
												</div>

												<ul class="actions" style="right: -1px;">
													<li class="dropdown">
														<a href="#" data-toggle="dropdown" aria-expanded="false">
															<i class="zmdi zmdi-more-vert"></i>
														</a>

														<ul class="dropdown-menu dropdown-menu-right">
															{if $commenta.editcomlink != "none"}<li>{$commenta.editcomlink}</li>{/if}
															{if $commenta.delcomlink != "none"}<li>{$commenta.delcomlink}</li>{/if}
														</ul>
													</li>
												</ul>
											</div>
											{/foreach}
										</div>
										{else}
										<div class="wcl-list">
											<div class="media">
												<div class="media-body">
													<p class="m-t-5 m-b-0">No comments.</p>
												</div>
											</div>
										</div>
										{/if}
										<!-- Comment form -->
										<div class="wcl-form m-t-15">
											<div class="wc-comment">
												<a href="{$ban.addcomment_link}">
													<div class="wcc-inner">
														Add comment...
													</div>
												</a>
											</div>
										</div>
									</div>
									<!-- COMMENT CODik-->
								</div>
							</div>
						</div>
					</td>
				</tr>
				<!-- ###############[ End Sliding Panel ]################## -->
				<!-- 
				<div class="modal fade" id="mod_{$ban.admin_gid}_mod" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><b>{$ban.admin}</b></h4>
                                        </div>
                                        <div class="modal-body f-15">
                                            <p>Admin Details:</p>
											<p>
												<ul class="clist clist-angle">
													{if !empty($ban.admin_skype)}<li>Skype: {$ban.admin_skype}</li>{/if}
													{if !empty($ban.admin_vk)}<li>Instagram: <a href="https://vk.com/{$ban.admin_vk}">Link</a></li>{/if}
												</ul>
											</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        -->
                        {/foreach}
                    </tbody>
                </table>
            </div>
            {if $general_unban || $can_delete}
            <div class="card-body card-padding">
            	<div class="col-sm-12 p-l-0">
            		<div class="col-sm-2 p-0">
            			<select class="selectpicker " name="bulk_action" id="bulk_action" onchange="BulkEdit(this,'{$admin_postkey}');">
            				<option value="-1">Choose</option>
            				{if $general_unban}
            				<option value="U">Unban</option>
            				{/if}
            				{if $can_delete}
            				<option value="D">Remove</option>
            				{/if}
            			</select>
            		</div>
            		{if $can_export }
            		<div class="col-sm-7 p-t-10 text-center">
            			Download permanent&nbsp;(&nbsp;<a href="./exportbans.php?type=steam" title="Export permanent STEAM ID bans">SteamID</a>&nbsp;/&nbsp;
            			<a href="./exportbans.php?type=ip" title="Export permanent IP bans">IP</a>&nbsp;)&nbsp; bans.
            		</div>
            		{/if}
            		<div class="col-sm-3 p-r-0 text-right" style="float:right;">
            			<button class="btn bgm-bluegray waves-effect" onclick="window.location.href='index.php?p=banlist&hideinactive={if $hidetext_darf == '1'}true{else}false{/if}{$searchlink|htmlspecialchars}'">{$hidetext}&nbsp;bans</button>
            		</div>
            	</div>
            </div>&nbsp;
            {/if}
        </div>

        {literal}
        <script type="text/javascript">window.addEvent('domready', function(){	
        	InitAccordion('tr.opener', 'div.opener', 'content');
        	{/literal}
        	{if $view_bans}
        	$('tickswitch').value=0;
        	{/if}
        	{literal}
        }); 
    </script>
    {/literal}
    {/if}
