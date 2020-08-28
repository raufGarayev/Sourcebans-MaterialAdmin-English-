{if NOT $permission_import}
	Access denied!
{else}
    {display_header title="Import bans" text="For more information move your mouse on question mark."}
    <div class="card-body card-padding p-b-0 clearfix">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="importBans" />
            <div class="form-group m-b-5">
                <label for="file" class="col-sm-3 control-label">{help_icon title="File" message="Choose file banned_users.cfg or banned_ip.cfg for uploading bans."} File </label>
                <div class="col-sm-9">
                    <!-- <div class="fg-line">
                        <input type="file" TABINDEX=1 class="file" id="importFile" name="importFile" />
                    </div> -->
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <span class="btn btn-primary btn-file m-r-10 waves-effect">
                            <span class="fileinput-new">Choose file</span>
                            <span class="fileinput-exists">Change</span>
                            <input name="importFile" type="file" />
                        </span>
                        <span class="fileinput-filename"></span>
                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput">×</a>
                    </div>
                    <div id="file.msg" class="badentry"></div>
                </div>
            </div>
            {display_material_checkbox name="friendsname" help_title="Get names" help_text="Check mark, if you want to get names of players from their Steam community profile. (works only with  banned_users.cfg)"}
            <br /><br />
            <center>
                {sb_button text="Start import bans" icon="<i class='zmdi zmdi-account-add'></i>" class="bgm-green btn-icon-text" id="iban" submit=true}
            </center>
            <br />
        </form>
    </div>
    {if !$extreq}
    <script type="text/javascript">
        $('friendsname').disabled = true;
    </script>
    {/if}
{/if}
