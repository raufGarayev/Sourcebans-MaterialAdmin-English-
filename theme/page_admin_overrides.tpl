{if NOT $permission_addadmin}
Access denied!
{else}
{if $overrides_error != ""}
<script type="text/javascript">ShowBox("Error", "{$overrides_error}", "red");</script>
{/if}
{if $overrides_save_success}
<script type="text/javascript">ShowBox("Overrides updated", "Changes successfully saved.", "green", "index.php?p=admin&c=admins");</script>
{/if}
<div id="add-group">
    <form action="" method="post">
        {display_header title="Overrides" text="With Overrides you can change the flags or permissions on any command, either globally, or for a specific group, without editing plugin source code."}
        <div class="card-body card-padding">
            <p>Read about overrides <a href="https://wiki.alliedmods.net/Ru:Overriding_Command_Access_(SourceMod)" title="Overrides (SourceMod)" target="_blank">on AlliedModders Wiki</a>.<br />
            Blanking out an overrides' name will delete it.</p>
            <table align="center" cellspacing="0" cellpadding="4" id="overrides" width="90%" class="table table-striped">
                <tr>
                    <th class="text-left">Type</td>
                        <th>Name</td>
                            <th>Flags</td>
                            </tr>
                            {foreach from=$overrides_list item=override}
                            <tr>
                                <td class="text-left">
                                    <select name="override_type[]" class="selectpicker">
                                        <option{if $override.type == "command"} selected="selected"{/if} value="command">Command</option>
                                        <option{if $override.type == "group"} selected="selected"{/if} value="group">Group</option>
                                    </select>
                                    <input type="hidden" name="override_id[]" value="{$override.id}" />
                                </td>
                                <td>
                                    <div class="form-group m-b-5">
                                        <div class="col-sm-9">
                                            <div class="fg-line">
                                                <input type="text" class="form-control" name="override_name[]" value="{$override.name|htmlspecialchars}">
                                            </div>
                                        </div>
                                    </div>                                      
                                </td>
                                <td>
                                   <div class="form-group m-b-5">
                                    <div class="col-sm-9">
                                        <div class="fg-line">
                                            <input type="text" class="form-control" name="override_flags[]" value="{$override.flags|htmlspecialchars}">
                                        </div>
                                    </div>
                                </div>                                      
                            </td>
                        </tr>
                        {/foreach}
                        <tr>
                            <td class="text-left">
                                <select class="selectpicker" name="new_override_type">
                                    <option value="command">Command</option>
                                    <option value="group">Group</option>
                                </select>
                            </td>
                            <td>
                                <div class="form-group m-b-5">
                                    <div class="col-sm-9">
                                        <div class="fg-line">
                                            <input type="text" class="form-control" id="new_override_name" name="new_override_name" placeholder="Type details(important)">
                                        </div>
                                    </div>
                                </div>  
                            </td>
                            <td>
                                <div class="form-group m-b-5">
                                    <div class="col-sm-9">
                                        <div class="fg-line">
                                            <input type="text" class="form-control" id="new_override_flags" name="new_override_flags" placeholder="Type details (important)">
                                        </div>
                                    </div>
                                </div>    
                            </td>
                        </tr>
                    </table>
                </div>
                <br />
                <center>
                    {sb_button text="Save" icon="<i class='zmdi zmdi-check-all'></i>" class="bgm-green btn-icon-text" id="oversave" submit=true}
                    &nbsp;
                    {sb_button text="Back" onclick="history.go(-1)" icon="<i class='zmdi zmdi-undo'></i>" class="bgm-red btn-icon-text" id="oback"}
                </center>
                <br />
            </form>
        </div>
        {/if}