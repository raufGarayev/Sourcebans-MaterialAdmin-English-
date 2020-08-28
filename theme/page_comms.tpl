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
						<textarea class="form-control auto-size" placeholder="Your comment...." id="commenttext" name="commenttext">{$commenttext}</textarea>
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
		<h2>Comm blocks list
			<small>
				Total: {$total_bans} {$ban_nav_p}
			</small>
		</h2>
		
		<div class="actions" id="banlist-nav">
			{$ban_nav}
		</div>
	</div>
	
	<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<tr>
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
				<tr class="opener" {if $ban.server_id != 0}onclick="xajax_ServerHostPlayers({$ban.server_id}, {$ban.ban_id});"{/if} style="cursor: pointer;">
					<td class="text-center">{$ban.mod_icon}</td>
					<td class="text-center">{$ban.ban_date_info}</td>
					<td>
						<div style="float:left;">{$ban.type_icon_p}
							{if empty($ban.player)}
								<i>Player name hided</i>
							{else}
								{$ban.player|escape:'html'|stripslashes}
							{/if}
						</div>
						{if $view_comments && $ban.commentdata != "Нет" && $ban.commentdata|@count > 0}
							<div style="float:right;">
								{$ban.commentdata|@count} <img src="theme/img/comm.png" alt="Comments" title="Comments" style="height:14px;width:14px;" />
							</div>
						{/if}
					</td>
					{if !$hideadminname}
						<td class="text-center">
							{if !empty($ban.admin)}
								{if $ban.admin != "CONSOLE"}
									{$ban.admin|escape:'html'}
								{else}
									{$ConsoleName|escape:'html'}
								{/if}
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
									<h2>Comms block info:</h2>

									{if $view_bans}
									<ul class="actions actions-alt">
										<li class="dropdown">
											<a href="#" data-toggle="dropdown" aria-expanded="false">
												<i class="zmdi zmdi-more-vert"></i>
											</a>

											<ul class="dropdown-menu dropdown-menu-right">
												{if $ban.unbanned && $ban.reban_link != false}
												  <li>{$ban.reban_link}</li>
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
											</ul>
										</li>
									</ul>
									{/if}
								</div>
								<div class="card-body card-padding">
									<div class="form-group col-sm-7">
										<div class="form-group col-sm-12 m-b-10">
											<label class="col-sm-4 control-label"><i class="zmdi zmdi-star text-left"></i>  Player</label>
											<div class="col-sm-8">
												{if empty($ban.player)}
													<i>player name hided.</i>
												{else}
													{$ban.player|escape:'html'|stripslashes}
												{/if}
											</div>
										</div>
										<div class="form-group col-sm-12 m-b-10">
											<label class="col-sm-4 control-label"><i class="zmdi zmdi-star text-left"></i> Steam ID</label>
											<div class="col-sm-8">
												{if empty($ban.steamid)}
													<i>Steam ID hided.</i>
												{else}
													{$ban.steamid}
												{/if}
											</div>
										</div>
										<div class="form-group col-sm-12 m-b-10">
											<label class="col-sm-4 control-label"><i class="zmdi zmdi-star text-left"></i> Steam3 ID</label>
											<div class="col-sm-8">
												{if empty($ban.steamid)}
													<i>Steam3 ID hided.</i>
												{else}
													<a href="http://steamcommunity.com/profiles/{$ban.steamid3}" target="_blank">{$ban.steamid3}</a>
												{/if}
											</div>
										</div>
										{if $ban.type == 0}
										<div class="form-group col-sm-12 m-b-10">
											<label class="col-sm-4 control-label"><i class="zmdi zmdi-star text-left"></i> Steam Community</label>
											<div class="col-sm-8">
												<a href="http://steamcommunity.com/profiles/{$ban.communityid}" target="_blank">{$ban.communityid}</a>
											</div>
										</div>
										{/if}
										<div class="form-group col-sm-12 m-b-10">
											<label class="col-sm-4 control-label"><i class="zmdi zmdi-star text-left"></i> Issued</label>
											<div class="col-sm-8">
												{$ban.ban_date}
											</div>
										</div>
										<div class="form-group col-sm-12 m-b-10">
											<label class="col-sm-4 control-label"><i class="zmdi zmdi-star text-left"></i> Length</label>
											<div class="col-sm-8">
												{if $ban.ub_reason}<del>{$ban.banlength}</del> {$ban.ub_reason}{else}{$ban.banlength}{/if}
											</div>
										</div>
										{if $ban.unbanned}
										<div class="form-group col-sm-12 m-b-10">
											<label class="col-sm-4 control-label"><i class="zmdi zmdi-star text-left"></i> Unblock reason</label>
											<div class="col-sm-8">
												{if $ban.ureason == ""}
													<i>Reason not specified.</i>
												{else}
													{$ban.ureason}
												{/if}
											</div>
										</div>
										<div class="form-group col-sm-12 m-b-10">
											<label class="col-sm-4 control-label"><i class="zmdi zmdi-star text-left"></i> Admin unblocked</label>
											<div class="col-sm-8">
												 {if !empty($ban.removedby)}
													{$ban.removedby|escape:'html'}
												{else}
													<i>Admin removed</i>
												{/if}
											</div>
										</div>
										{/if}
										<div class="form-group col-sm-12 m-b-10">
											<label class="col-sm-4 control-label"><i class="zmdi zmdi-star text-left"></i> Expire</label>
											<div class="col-sm-8">
												{if $ban.expires == "never"}
													<i>Permanent.</i>
												{else}
													{$ban.expires}
												{/if}
											</div>
										</div>
										<div class="form-group col-sm-12 m-b-10">
											<label class="col-sm-4 control-label"><i class="zmdi zmdi-star text-left"></i> Block reason</label>
											<div class="col-sm-8">
												{$ban.reason|escape:'html'}
											</div>
										</div>
										{if !$hideadminname}
										<div class="form-group col-sm-12 m-b-10">
											<label class="col-sm-4 control-label"><i class="zmdi zmdi-star text-left"></i> Admin blocked</label>
											<div class="col-sm-8">
												{if !empty($ban.admin)}
													{$ban.admin|escape:'html'}
												{else}
													<i>Admin removed.</i>
												{/if}
											</div>
										</div>
										{/if}
										<div class="form-group col-sm-12 m-b-10">
											<label class="col-sm-4 control-label"><i class="zmdi zmdi-star text-left"></i> Server</label>
											<div class="col-sm-8" id="ban_server_{$ban.ban_id}">
												{if $ban.server_id == 0}
													Web ban
												{else}
													Please, wait...
												{/if}
											</div>
										</div>
										<div class="form-group col-sm-12 m-b-10">
											<label class="col-sm-4 control-label"><i class="zmdi zmdi-star text-left"></i> Previous blocks</label>
											<div class="col-sm-8">
												{$ban.prevoff_link}
											</div>
										</div>
									</div>
									<div class="form-group col-sm-5">
										{if !$hideadminname}
											<div class="wall-comment-list">
												<div class="pmo-block pmo-contact" style="font-size: 14px;">
													<div class="lv-header c-bluegray p-b-5 p-t-0" style="border-bottom: 2px solid #607d8b;">Admin blocked:</div>
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
														<li class="p-b-5"><i class="zmdi zmdi-steam"></i> {if !empty($ban.admin_authid)}{$ban.admin_authid} (<a href="http://steamcommunity.com/profiles/{$ban.admin_authid_link}" target="_blank">Profile</a>){else}No data...{/if}</li>
														<li class="p-b-5"><i class="zmdi zmdi-vk"></i> {if !empty($ban.admin_vk)}<a href="https://vk.com/{$ban.admin_vk}" target="_blank">Link</a>{else}No data...{/if}</li>
														<li class="p-b-5"><i class="zmdi zmdi-account-box-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Skype"></i> {if !empty($ban.admin_skype)}{$ban.admin_skype}{else}No data...{/if}</li>
														<li class="p-b-5">
															<i class="zmdi zmdi-info-outline" data-toggle="tooltip" data-placement="top" title="" data-original-title="Comment"></i>
															<address class="m-b-0 ng-binding">
																{if !empty($ban.admin_comm)}
																{$ban.admin_comm}
																{else}
																No data. An ordinary private, controls order on the servers.
																{/if}
															</address>
														</li>
														{/if}
													</ul>
												</div>
											</div>
										{/if}
										<!-- COMMENT CODik-->
										<div class="wall-comment-list">
										{if $view_comments}
											{if $ban.commentdata != "Нет"}
												<!-- Comment Listing -->
												<div class="wcl-list">
													{foreach from=$ban.commentdata item=commenta}
													<div class="media">
														<a href="#" class="pull-left">
															<img src="theme/img/profile-pics/4.jpg" alt="" class="lv-img-sm">
														</a>
								 
														<div class="media-body">
															<a href="#" class="a-title">{if !empty($commenta.comname)}{$commenta.comname|escape:'html'}{else}<i>Admin removed</i>{/if}</a> {if !empty($commenta.edittime)}<small class="c-gray m-l-10">last edit {$commenta.edittime} by {if !empty($commenta.editname)}{$commenta.editname}{else}<i>Admin deleted</i>{/if}</small>{/if}
															<p class="m-t-5 m-b-0" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">{$commenta.commenttxt}</p>
														</div>
														
														{if $commenta.editcomlink != ""}
															<ul class="actions">
																<li class="dropdown">
																	<a href="#" data-toggle="dropdown" aria-expanded="false">
																		<i class="zmdi zmdi-more-vert"></i>
																	</a>

																	<ul class="dropdown-menu dropdown-menu-right">
																		<li>{$commenta.editcomlink}</li>
																		<li>{$commenta.delcomlink}</li>
																	</ul>
																</li>
															</ul>
														{/if}
													</div>
													{/foreach}
												</div>
											{else}
												<!-- Comment Listing -->
												<div class="wcl-list">
													<div class="media">
														<div class="media-body">
															<p class="m-t-5 m-b-0">{if $ban.commentdata == "None"}No comments.{/if}</p>
														</div>
													</div>
												</div>
											{/if}
										{else}
											<!-- Comment Listing -->
											<div class="wcl-list">
												<div class="media">
													<div class="media-body">
														<p class="m-t-5 m-b-0">View comments and leave them - only authorized users are allowed!</p>
													</div>
												</div>
											</div>
										{/if}
											<!-- Comment form -->
											<div class="wcl-form">
												<div class="wc-comment">
													{if $view_comments}
														<a href="{$ban.addcomment_link}">
															<div class="wcc-inner">
																Add comment...
															</div>
														</a>
													{else}
														<div class="wcc-inner">
															Access denied...
														</div>
													{/if}
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
			{/foreach}
		</tbody>
	</table>
	</div>
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
