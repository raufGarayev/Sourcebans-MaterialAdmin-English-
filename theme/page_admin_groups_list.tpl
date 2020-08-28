{if NOT $permission_listgroups}
    Access denied!
{else}
    <!-- Web Admin Groups -->
    {display_header title="Groups" text="Click on group to view permissions"}
    <div class="card-body card-padding">
        {display_header title="Web admin groups" text="Total: $web_group_count"}
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="35%" class="text-left">Group name</th>
                    <th width="20%" class="text-center">Admins in group</th>
                    <th width="20%" class="text-right">Actions</th>{/if}
                </tr>
            </thead>
            <tbody>
                {foreach from="$web_group_list item=group name=web_group}
                <tr id="gid_{$group.gid}" onmouseout="this.className='opener'" onmouseover="this.className='info opener'" class="opener" style="cursor:">
                    <td class="text-left">{$group.name}</td>
                    <td class="text-center">{$web_admins[$smarty.foreach.web_group.index]}</td>
                    <td class="text-right">
                        {if $permission_editgroup}<a href="index.php?p=admin&c=groups&o=edit&type=web&id={$group.gid}">Edit</a>{if $permission_deletegroup} / {/if}{/if}
                        {if $permission_deletegroup}<a href="#" onclick="RemoveGroup({$group.gid}, '{$group.name}', 'web');">Remove</a>{/if}
                    </td>
                </tr>
                <tr>
                    <td colspan="7" align="center" style="padding-bottom: 0px; padding-left: 0px; padding-right: 0px; padding-top: 0px;">
                        <div class="opener">
                            <table class="table">
                                <tr>
                                    <td height="16" align="left" class="listtable_top" colspan="2">
                                        <b>Group detauks</b>            
                                    </td>
                                </tr>
                                <tr>
                                    <td height="16" class="listtable_1">{$group.permissions}</td>
                                    <td height="16" class="listtable_1">
                                        <p class="c-blue">Group members</p>
                                        <ul class="clist clist-star">
                                            {foreach from=$web_admins_list[$smarty.foreach.web_group.index] item="web_admin"}
                                            <li>
                                                {if $permission_editadmin}<a href="#admin_w{$web_admin.aid}" data-toggle="modal">{/if}
                                                    {$web_admin.user}
                                                {if $permission_editadmin}</a>{/if}
                                            </li>
                                            
                                            {if $permission_editadmin}
                                            <!-- Модальное окошко с действиями над админом {$web_admin.user} -->
                                            <div class="modal fade" id="admin_w{$web_admin.aid}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class='modal-dialog modal-sm'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <h4 class='modal-title'>{$web_admin.user}</h4>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <p class="m-b-10"><button class="btn btn-link btn-block" data-dismiss="modal" onClick='location.href="index.php?p=admin&c=admins&o=editgroup&id={$web_admin.aid}";'>Edit groups</button></p>
                                                            <p class="m-b-10"><button class="btn btn-link btn-block" href="#" data-dismiss='modal' onClick='location.href="index.php?p=admin&c=admins&o=editgroup&id={$web_admin.aid}&wg=";'>Disable admin from group</button></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {/if}
                                            {/foreach}
                                        </ul>
                                    </td>
                            </tr>
                        </table>        
                    </div>
                </td>     
            </tr>        
            {/foreach}
        </tbody>
    </table>
    <br/>
    
    <!-- Server Admin Groups -->
    {display_header title="Server admin groups" text="Total: $server_admin_group_count"}
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="35%" class="text-left">Group name</th>
                <th width="20%" class="text-center">Admins in group</th>
                <th width="20%" class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
        {foreach from="$server_group_list" item="group" name="server_admin_group"}
            <tr id="gid_{$group.id}" onmouseout="this.className='opener'" onmouseover="this.className='info opener'" class="opener" style="cursor: pointer;">
                <td class="text-left" height='16'>{$group.name}</td>
                <td class="text-center" height='16'>{$server_admins[$smarty.foreach.server_admin_group.index]}</td>
                <td class="text-right" height='16'> 
                    {if $permission_editgroup}
                        <a href="index.php?p=admin&c=groups&o=edit&type=srv&id={$group.id}">Edit</a>
                        {if $permission_deletegroup}
                            &nbsp;/&nbsp;
                        {/if}
                    {/if}
                    {if $permission_deletegroup}
                        <a href="#" onclick="RemoveGroup({$group.id}, '{$group.name}', 'srv');">Remove</a>
                    {/if}
                </td>
            </tr>
            <tr>
                <td colspan="7" align="center" style="padding-bottom: 0px; padding-left: 0px; padding-right: 0px; padding-top: 0px;">
                    <div class="opener">
                        <table class="table">
                            <tr>
                                <td height="16" align="left" class="listtable_top" colspan="2">
                                    <b>Group details</b>            
                                </td>
                            </tr>
                            <tr>
                                <td height="16" class="listtable_1">{$group.permissions}</td>
                                <td height="16" class="listtable_1">
                                    <p class="c-blue">Group members</p>
                                    <ul class="clist clist-star">
                                        {foreach from=$server_admins_list[$smarty.foreach.server_admin_group.index] item="server_admin"}
                                        <li>
                                            {if $permission_editadmin}<a href="#admin_s{$server_admin.aid}" data-toggle="modal">{/if}
                                                {$server_admin.user}
                                            {if $permission_editadmin}</a>{/if}
                                        </li>
                                        
                                        {if $permission_editadmin}
                                        <!-- Модальное окошко с действиями над админом {$server_admin.user} -->
                                        <div class="modal fade" id="admin_s{$server_admin.aid}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class='modal-dialog modal-sm'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h4 class='modal-title'>{$server_admin.user}</h4>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <p class="m-b-10"><button class="btn btn-link btn-block" data-dismiss="modal" onClick='location.href="index.php?p=admin&c=admins&o=editgroup&id={$server_admin.aid}";'>Edit groups</button></p>
                                                        <p class="m-b-10"><button class="btn btn-link btn-block" href="#" data-dismiss='modal' onClick='location.href="index.php?p=admin&c=admins&o=editgroup&id={$server_admin.aid}&sg=";'>Disable admin from group</button></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {/if}
                                        {/foreach}
                                    </ul>
                                </td>
                                <td>
                                    <p class="c-blue">Overrides</p>
                                    <ul class="clist clist-star">
                                        {if $server_overrides_list[$smarty.foreach.server_admin_group.index]|@count > 0}
                                            {foreach from=$server_overrides_list[$smarty.foreach.server_admin_group.index] item="override"}
                                        <li><b>{if $override.access == "allow"}Allowed{else}Denied{/if}</b> access to {if $override.type == "command"}command{else}command group{/if} <b>{$override.name|htmlspecialchars}</b></li>
                                            {/foreach}
                                        {else}
                                        <li>Overrides <b>do not exist</b>.</li>
                                        {/if}
                                    </ul>
                                </td>
                           </tr>
                    </table>        
                 </div>
            </td>     
        </tr>        
        {/foreach}
        </tbody>
    </table>
    <br/>


    <!-- Server Groups -->
    {display_header title="Server Groups" text="Total: $server_group_count"}
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="35%" class="text-left">Group name</th>
                <th width="20%" class="text-center">Servers in group</th>
                <th width="20%" class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
        {foreach from="$server_list" item="group" name="servers_group"}
            <tr id="gid_{$group.gid}" onmouseout="this.className='opener'" onmouseover="this.className='info opener'" class="opener" style="cursor: pointer;">
                <td class="text-left" height='16'>{$group.name}</td>
                <td class="text-center" height='16'>{$server_list[$smarty.foreach.servers_group.index].servers|@count}</td>
                <td class="text-right" height='16'>   
                    {if $permission_editgroup}
                    <a href="index.php?p=admin&c=groups&o=edit&type=server&id={$group.gid}">Edit</a>
                    {if $permission_deletegroup}
                    &nbsp;/&nbsp;
                    {/if}
                {/if}
                {if $permission_deletegroup}
                    <a href="#" onclick="RemoveGroup({$group.gid}, '{$group.name}', 'server');">Remove</a>
                {/if}        
                </td>
            </tr>
            <tr>
                <td colspan="7" align="left" style="padding-bottom: 0px; padding-left: 0px; padding-right: 0px; padding-top: 0px;">         
                    <div class="opener">
                        <div style="padding-left: 30px; padding-top: 15px; padding-bottom: 15px;">
                            <p class="c-blue">Servers in group</p>
                            <ul class="clist clist-star">
                                {if $server_list[$smarty.foreach.servers_group.index].servers|@count > 0}
                                {foreach from=$server_list[$smarty.foreach.servers_group.index].servers item="server"}
                                    <li id="servername_{$server[0]}">Please, wait...</li>
                                    <script type="text/javascript">
                                        xajax_ServerHostProperty({$server[0]}, "servername_{$server[0]}", "innerHTML", 100);
                                    </script>
                                {/foreach}
                                {else}
                                    <li>Servers in group <b>do not exist.</b></li>
                                {/if}
                            </ul>
                        </div>
                     </div>
                 </td>     
              </tr> 
        {/foreach}
        </tbody>
        </table>
    </div>

    <script type="text/javascript">InitAccordion('tr.opener', 'div.opener', 'content');</script>
