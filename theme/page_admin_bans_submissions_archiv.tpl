{if NOT $permissions_submissions}
Access denied!
{else}
<div class="card-header">
  <h2>Ban submissions archieve (<span id="subcountarchiv">{$submission_count_archiv}</span>)<small>Click on player to get more information</small></h2>
</div>  
<div id="banlist-nav">
  {$asubmission_nav}
</div>
<table class="table table-bordered">
  <thead>
    <th>Nick</th>
    <th>Steam ID</th>
  </thead>
  {foreach from="$submission_list_archiv" item="sub"}
  <tr id="asid_{$sub.subid}" class="opener opener4 tbl_out" {if $sub.hostname == ""}onclick="xajax_ServerHostPlayers('{$sub.server}', 'id', 'suba{$sub.subid}');"{/if} onmouseout="this.className='tbl_out'" onmouseover="this.className='tbl_hover'" style="cursor: pointer;">
    <td>{$sub.name}</td>
    <td>{if $sub.SteamId!=""}{$sub.SteamId}{else}{$sub.sip}{/if}</td>
  </tr>
  <tr id="asid_{$sub.subid}a">
    <td colspan="7" style="padding: 0px;border-top: 0px solid #FFFFFF;">
      <div class="opener">
        <div class="card-header bgm-bluegray">
          <h2>Детали:</h2>
          <ul class="actions actions-alt">
            <li class="dropdown">
              <a href="#" data-toggle="dropdown" aria-expanded="false">
                <i class="zmdi zmdi-more-vert"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-right">
                {if $sub.archiv != "2" and $sub.archiv != "3"}
                <li><a href="#" onclick="xajax_SetupBan({$sub.subid});">Ban</a></li>
                {if $permissions_editsub}
                <li><a href="#" onclick="RemoveSubmission({$sub.subid}, '{$sub.name|stripslashes|stripquotes}', '2');">Restore</a></li>
                {/if}
                {/if}
                {if $permissions_editsub}
                <li><a href="#" onclick="RemoveSubmission({$sub.subid}, '{$sub.name|stripslashes|stripquotes}', '0');">Remove</a></li>
                {/if}   
                <li><a href="index.php?p=admin&c=bans&o=email&type=s&id={$sub.subid}">Contacts</a></li>           
              </ul>
            </li>
          </ul>
        </div>
        <div class="card-body card-padding">
          <div class="form-group col-sm-7" style="font-size: 14px;">
            <div class="form-group col-sm-12 m-b-5">
              <label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i>  Reason of archieving</label>
              <div class="col-sm-8">
                {$sub.archive}
              </div>
            </div>     
            <div class="form-group col-sm-12 m-b-5">
              <label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i>  Sent to archieve</label>
              <div class="col-sm-8">
                {if !empty($sub.archivedby)}
                {$sub.archivedby}
                {else}
                <i><font color="#677882">Admin removed.</font></i>
                {/if}
              </div>
            </div>                   
            <div class="form-group col-sm-12 m-b-5">
              <label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i>  Player</label>
              <div class="col-sm-8">
                {$sub.name}
              </div>
            </div>
            <div class="form-group col-sm-12 m-b-5">
              <label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Added</label>
              <div class="col-sm-8">
                {$sub.submitted}
              </div>
            </div>
            <div class="form-group col-sm-12 m-b-5">
              <label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> SteamID</label>
              <div class="col-sm-8">
                {if $sub.SteamId == ""}
                <i><font color="#677882">SteamID not specified</font></i>
                {else}
                {$sub.SteamId}
                {/if}
              </div>
            </div>
            <div class="form-group col-sm-12 m-b-5">
              <label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> IP Adress</label>
              <div class="col-sm-8">
                {if $sub.sip == ""}
                <i><font color="#677882">IP adress not specified</font></i>
                {else}
                {$sub.sip}
                {/if}                      
              </div>
            </div>
            <div class="form-group col-sm-12 m-b-5">
              <label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Reason</label>
              <div class="col-sm-8">
                <strong>{$sub.reason}</strong>
              </div>
            </div>
            <div class="form-group col-sm-12 m-b-5">
              <label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Server</label>
              <div class="col-sm-8">
                <span id="suba{$sub.subid}">{if $sub.hostname == ""}
                  <i>Getting server name...</i>
                  {else}
                  {$sub.hostname}
                  {/if}
                </span>
              </div>
            </div>
            <div class="form-group col-sm-12 m-b-5">
              <label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> MOD</label>
              <div class="col-sm-8">
                {$sub.mod}
              </div>
            </div>
            <div class="form-group col-sm-12 m-b-5">
              <label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Submitter name</label>
              <div class="col-sm-8">
                {if $sub.subname == ""}
                <i><font color="#677882">Name not specified</font></i>
                {else}
                {$sub.subname}
                {/if}
              </div>
            </div>
            <div class="form-group col-sm-12 m-b-5">
              <label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Submitter IP adress</label>
              <div class="col-sm-8">
                {$sub.ip}
              </div>
            </div>
            <div class="form-group col-sm-12 m-b-5">
              <label class="col-sm-4 control-label"><i class="zmdi zmdi-circle-o text-left"></i> Demo</label>
              <div class="col-sm-8">
                {$sub.demo}
              </div>
            </div>            
          </div>
        </div>
      </div>
    </td>
  </tr>
  {/foreach}
</table>
<script>InitAccordion('tr.opener4', 'div.opener4', 'mainwrapper');</script>
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
