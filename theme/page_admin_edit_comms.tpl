<form action="" method="post">
	<div id="admin-page-content">
		<div id="0">
			<div id="msg-green" style="display:none;">
				<i><img src="./images/yay.png" alt="Warning" /></i>
				<b>Block refreshed</b>
				<br />
				Block details refreshed.<br /><br />
				<i>Redirecting to blocks page...</i>
			</div>
			<div id="add-group">
		<h3>Block details</h3>
		For more information move your mouse on question mark.<br /><br />
		<input type="hidden" name="insert_type" value="add">
			<table width="90%" border="0" style="border-collapse:collapse;" id="group.details" cellpadding="3">
			  <tr>
			    <td valign="top" width="35%">
				  <div class="rowdesc">
				    -{help_icon title="Ник" message="Nick of blocked player."}-Ник
				  </div>
				</td>
			    <td>
				  <div align="left">
			        <input type="text" class="submit-fields" id="name" name="name" value="-{$ban_name}-" />
			      </div>
			      <div id="name.msg" class="badentry"></div></td>
			  </tr>

			  <tr>
    			<td valign="top">
    			  <div class="rowdesc">
    				-{help_icon title="Steam ID" message="Steam ID ."}-Steam ID
    			  </div>
    			</td>
    		 	<td>
    			  <div align="left">
      				<input value="-{$ban_authid}-" type="text" TABINDEX=2 class="submit-fields" id="steam" name="steam" />
    			  </div>
    			  <div id="steam.msg" class="badentry"></div>
    			</td>
  			  </tr>
  			  <tr>
    		<td valign="top" width="35%">
    			<div class="rowdesc">
    				-{help_icon title="Block Type" message="Choose type of block, chat or voice"}-Block type
    			</div>
    		</td>
    		<td>
    			<div align="left">
    				<select id="type" name="type" TABINDEX=2 class="submit-fields">
						<option value="1">Voice</option>
						<option value="2">Chat</option>
					</select>
    			</div>
    		</td>
 		  </tr>
 		  <tr>
    		<td valign="top" width="35%">
    			<div class="rowdesc">
    				-{help_icon title="Block reason" message="Explain reason of block."}-Block reason
    			</div>
    		</td>
    		<td>
    			<div align="left">
    				<select id="listReason" name="listReason" TABINDEX=4 class="submit-fields" onChange="changeReason(this[this.selectedIndex].value);">
    					<option value="" selected> -- Choose reason -- </option>
					<optgroup label="Violation">
						<option value="Obsence Language">Obsence Language</option>
						<option value="Insulting players">Insulting players</option>
                        <option value="Insulting Admins">Admins</option>
                        <option value="Innapropriate Language">Innapropriate Language</option>
						<option value="Trade">Trade</option>
						<option value="Voice/Chat Spam">Spam</option>
						<option value="Advertising">Advertising</option>
					</optgroup>
					<option value="other">Own Reason</option>
				</select>

				<div id="dreason" style="display:none;">
     					<textarea class="submit-fields" TABINDEX=4 cols="30" rows="5" id="txtReason" name="txtReason"></textarea>
     				</div>
    			</div>
    			<div id="reason.msg" class="badentry"></div>
    		</td>
      </tr>
      <tr>
			    <td valign="top" width="35%"><div class="rowdesc">-{help_icon title="Block Length" message="Choose length of block."}-Block Length</div></td>
			    <td><div align="left">
			     <select id="banlength" name="banlength" TABINDEX=4 class="submit-fields">
									 <option value="0">Permanently</option>
						<optgroup label="Minutes">
						  <option value="1">1 minute</option>
						  <option value="5">5 minutes</option>
						  <option value="10">10 minutes</option>
						  <option value="15">15 minutes</option>
						  <option value="30">30 minutes</option>
						  <option value="45">45 minutes</option>
						</optgroup>
						<optgroup label="Hours">
							<option value="60">1 hour</option>
							<option value="120">2 hours</option>
							<option value="180">3 hours</option>
							<option value="240">4 hours</option>
							<option value="480">8 hours</option>
							<option value="720">12 hours</option>
						</optgroup>
						<optgroup label="Days">
						  <option value="1440">1 day</option>
						  <option value="2880">2 days</option>
						  <option value="4320">3 days</option>
						  <option value="5760">4 days</option>
						  <option value="7200">5 days</option>
						  <option value="8640">6 days</option>
						</optgroup>
						<optgroup label="Weeks">
						  <option value="10080">1 week</option>
						  <option value="20160">2 weeks</option>
						  <option value="30240">3 weeks</option>
						</optgroup>
						<optgroup label="Months">
						  <option value="43200">1 month</option>
						  <option value="86400">2 months</option>
						  <option value="129600">3 months</option>
						  <option value="259200">6 months</option>
						  <option value="518400">12 months</option>
						</optgroup>
				  </select>
			    </div><div id="length.msg" class="badentry"></div></td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td>
			      <input type="hidden" name="did" id="did" value="" />
			      <input type="hidden" name="dname" id="dname" value="" />
			      	-{sb_button text="Save" class="ok" id="editban" submit=true}-
			     	 &nbsp;
			     	 -{sb_button text="Back" onclick="history.go(-1)" class="cancel" id="back" submit=false}-
			      </td>
			  </tr>
        </table>
       </div>
		</div>
	</div>
</form>
