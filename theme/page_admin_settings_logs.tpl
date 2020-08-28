<div class="card-header">
    <h2 align="left">System Log {$clear_logs} <small>Click the mouse cursor on the required event in order to reveal more details about it.</small></h2>
</div>
<div class="card-body">
{php} require (TEMPLATES_PATH . "/admin.log.search.php");{/php}
</div>
<div class="card-body card-padding">
<div id="banlist-nav">{$page_numbers}</div>
</div>
<div class="card-body">

    <table width="100%" cellspacing="0" cellpadding="0" align="center" class="table table-striped table-vmiddle">
        <tr>
            <td width="5%" height="16" class="listtable_top" align="center"><b>Type</b></td>
            <td width="28%" height="16" class="listtable_top" align="center"><b>Event</b></td>
            <td width="28%" height="16" class="listtable_top" align="center"><b>User</b></td>
            <td width="" height="16" class="listtable_top"><b>Date/Time</b></td>
        </tr>

{foreach from="$log_items" item="log"}
        <tr class="opener" onmouseout="this.className='tbl_out'" onmouseover="this.className='tbl_hover'" style="cursor: pointer;">
            <td height="16" align="center" class="listtable_1">{$log.type_img}</td>
            <td height="16" class="listtable_1">{$log.title}</td>
            <td height="16" class="listtable_1">{$log.user}</td>
            <td height="16" class="listtable_1">{$log.date_str}</td>
        </tr>
        <tr>
            <td colspan="4" align="center" style="background-color: #f4f4f4;padding: 0px;border-top: 0px solid #FFFFFF;">
                <div class="opener" style="visibility: hidden; zoom: 1; opacity: 0;">
                    <table width="100%" cellspacing="0" cellpadding="0" class="table table-striped table-vmiddle">
                        <tr>
                            <td height="16" align="center" class="listtable_top" colspan="3"><strong>Event details</strong></td>
                        </tr>
                        <tr align="left">
                            <td width="20%" height="16" class="listtable_1">Details</td>
                            <td height="16" class="listtable_1">{$log.message|escape}</td>
                        </tr>
                        <tr align="left">
                            <td width="20%" height="16" class="listtable_1">Parent function</td>
                            <td height="16" class="listtable_1">{$log.function}</td>
                        </tr>
                        <tr align="left">
                            <td width="20%" height="16" class="listtable_1">Request string</td>
                            <td height="16" class="listtable_1">{textformat wrap=62 wrap_cut=true}{$log.query}{/textformat}</td>
                        </tr>
                        <tr align="left">
                            <td width="20%" height="16" class="listtable_1">IP</td>
                            <td height="16" class="listtable_1">{$log.host}</td>
                       </tr>
                    </table>
                </div>
            </td>
        </tr>
{/foreach}
    </table>
</div>
<script type="text/javascript">
	InitAccordion('tr.opener', 'div.opener', 'content');
</script>
