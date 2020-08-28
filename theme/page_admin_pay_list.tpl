	<div class="card">
		<div class="card-header">
		<h2>Promokeys <small>Promokeys activating adminship or vip automatically after typing.</small></h2>
		</div>

		<div class="card-body table-responsive">
				<table width="100%" class="table" id="group.details">
					<thead>
						<tr>
							<th width="5%">№</th>
							<th width="12%">Status</th>
							<th width="30%">Key</th>
							<th width="10%">Length</th>
							<th width="10%">Group(server)</th>
							<th width="10%">Group(web)</th>
							<th width="13%">Server</th>
							<th width="8%"></th>
						</tr>
					</thead>
					<tbody>
						{foreach from="$card_list" item="card"}
							<tr>
								<td>
									{$card.aid}
								</td>
								<td>
									{if $card.activ == "1"}<span class="c-green">Active</span>{else}<span class="c-red">Used</span>{/if}
								</td>
								<td>
									{if $card.value != ""}{$card.value}{else}<span class="c-red">No key</span>{/if}
								</td>
								<td>
									{if $card.days == "0"}Навсегда{else}{$card.days} Days{/if}
								</td>
								<td>
									{if $card.group_srv != ""}{$card.group_srv}{else}<span class="c-red">No group</span>{/if}
								</td>
								<td>
									{if $card.group_web != "0"}{$card.group_web}{else}<span class="c-red">No group</span>{/if}
								</td>
								<td>
									{if $card.servers == ""}
										<span class="c-green">Free choice</span>
									{else}
										{if $card.servers == "-1"}
											<span class="c-red">No access</span>
										{else}
											<span class="c-red">Choice limited</span>
										{/if}
									{/if}
								</td>
								<td>
									<a href="index.php?p=admin&c=pay_card&o=del&id={$card.aid}">Remove</a>
								</td>
							</tr>
						{/foreach}
					</tbody>
				</table>&nbsp;
		</div>
	</div>