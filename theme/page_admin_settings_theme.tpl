<form action="" method="post" id="theme_form">
	<input type="hidden" name="settingsGroup" value="mainsettings_themes" />
	<div class="card">
		<div class="form-horizontal" role="form">
			<div class="card-header">
				<h2>Theme settings <small>Choose best type for your theme.</small></h2>
			</div>
			<div class="card-body card-padding p-b-0">
                <div class="form-group m-b-5">
					<label for="splashscreen" class="col-sm-3 control-label">{help_icon title="Loading screen" message="Allows you to turn on and off the loading screen with 'Please wait...'"} Loading screen</label>
					<div class="col-sm-9 p-t-10">
						<div class="toggle-switch p-b-5" data-ts-color="red">
							<input type="checkbox" id="splashscreen" name="splashscreen" hidden="hidden" /> 
							<label for="splashscreen" class="ts-helper checkbox-inline m-r-20" style="z-index:2;"></label> Enable?
						</div>
					</div>
				</div>
				
				<div class="form-group m-b-5">
					<label for="home_stats" class="col-sm-3 control-label">{help_icon title="Project stats" message="Allows you to enable and disable project statistics (number of admins, servers, bans, mutes) on the main"} Stats</label>
					<div class="col-sm-9 p-t-10">
						<div class="toggle-switch p-b-5" data-ts-color="red">
							<input type="checkbox" id="home_stats" name="home_stats" hidden="hidden" /> 
							<label for="home_stats" class="ts-helper checkbox-inline m-r-20" style="z-index:2;"></label> Enable?
						</div>
					</div>
				</div>
			
				<div class="form-group m-b-5">
					<label for="global_themes_t" class="col-sm-3 control-label">{help_icon title="Modes" message="Allows you to switch between minimal (hide the main menu) and normal (always open main menu) template. In the minimum mode, the user can change his view by the switch on the top right."} Modes</label>
					<div class="col-sm-9 p-t-10">
						<div class="toggle-switch p-b-5" data-ts-color="red">
							<input type="checkbox" id="global_themes_t" name="global_themes_t" hidden="hidden" /> 
							<label for="global_themes_t" class="ts-helper checkbox-inline m-r-20" style="z-index:2;"></label> Full support?
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="xleb_kroxi_t" class="col-sm-3 control-label">{help_icon title="Bread crumbs" message="Allows you to disable the navigation bar 'Main/Admin-cente'"} Bread crumbs</label>
					<div class="col-sm-9 p-t-10">
						<div class="toggle-switch p-b-5" data-ts-color="red">
							<input type="checkbox" id="xleb_kroxi_t" name="xleb_kroxi_t" hidden="hidden" /> 
							<label for="xleb_kroxi_t" class="ts-helper checkbox-inline m-r-20" style="z-index:2;"></label> Enable?
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label class="col-sm-3 control-label">{help_icon title="Header color" message="Allows you to choose the color of the header that suits your taste"} Header color</label>
					<div class="col-sm-9 p-t-10">
						<input type="text" value="{$theme_color}" id="color_theme_result" name="color_theme_result" hidden="hidden" />
							<table>
								<tr>
									<td>
										<label for="lightblue" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="lightblue" id="lightblue" name="inlineRadioOptions" hidden="hidden" onchange="$('color_theme_result').value = this.value;"/>
											<i class="input-helper"></i>    
											<span class="ss-skin bgm-lightblue" data-skin="lightblue">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label for="bluegray" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="bluegray" id="bluegray" name="inlineRadioOptions" hidden="hidden" onchange="$('color_theme_result').value = this.value;"/>
											<i class="input-helper"></i>    
											<span class="ss-skin bgm-bluegray" data-skin="bluegray">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										 <label for="cyan" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="cyan" id="cyan" name="inlineRadioOptions" hidden="hidden" onchange="$('color_theme_result').value = this.value;"/>
											<i class="input-helper"></i>    
											<span class="ss-skin bgm-cyan" data-skin="cyan">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										 <label for="teal" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="teal" id="teal" name="inlineRadioOptions" hidden="hidden" onchange="$('color_theme_result').value = this.value;"/>
											<i class="input-helper"></i>    
											<span class="ss-skin bgm-teal" data-skin="teal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label for="orange" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="orange" id="orange" name="inlineRadioOptions" hidden="hidden" onchange="$('color_theme_result').value = this.value;"/>
											<i class="input-helper"></i>    
											<span class="ss-skin bgm-orange" data-skin="orange">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label for="blue" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="blue" id="blue" name="inlineRadioOptions" hidden="hidden" onchange="$('color_theme_result').value = this.value;"/>
											<i class="input-helper"></i>    
											<span class="ss-skin bgm-blue" data-skin="blue">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label for="del_style" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="" id="del_style" name="inlineRadioOptions" hidden="hidden" onchange="$('color_theme_result').value = this.value;"/>
											<i class="input-helper"></i> <span class="c-red">Remove</span>
										</label>
									</td>
								</tr>
							</table>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="theme_color_p" class="col-sm-3 control-label">{help_icon title="Header color" message="Lets you choose the color of the SourceBans header that suits your taste. When filling in the input field, the usual color of the header will be ignored!"} Header color(own color)</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" class="form-control" id="theme_color_p" name="theme_color_p" {if $theme_color_t != ""}value="{$theme_color_t}"{else}placeholder="Type color code in #ffffff(Not necessary if color already choosed)"{/if} />
						</div>
						<a href="http://www.stm.dp.ua/web-design/color-html.php" target="_blank">See: Color code for HTML</a>
					</div>
				</div>
			</div>
			<div class="card-header">
				<h2>Fon settings <small>Precise setting of the background with ready-made options.</small>
							<ul class="actions">
                                <li class="dropdown">
									<a href="#" data-toggle="dropdown">
										<i class="zmdi zmdi-more-vert c-red"></i>
									</a>
                    
									<ul class="dropdown-menu dropdown-menu-right">
										<li>
											<a href="#" onclick="theme_num(1);">Theme 1</a>
										</li>
										<li>
											<a href="#" onclick="theme_num(2);">Theme 2</a>
										</li>
										<li>
											<a href="#" onclick="theme_num(3);">Theme 3</a>
										</li>
										<li>
											<a href="#" onclick="theme_num(4);">Theme 4</a>
										</li>
										<li>
											<a href="#" onclick="theme_num(5);">Theme 5</a>
										</li>
										<li>
											<a href="#" onclick="theme_num(6);">Theme 6</a>
										</li>
										<li>
											<a href="#" onclick="theme_num(7);">Theme 7</a>
										</li>
										<li>
											<a href="#" onclick="theme_num(8);">Theme 8</a>
										</li>
										<li>
											<a href="#" onclick="theme_num(9);">Theme 9</a>
										</li>
										<li>
											<a href="#" onclick="theme_num(10);">Theme 10</a>
										</li>
										<li>
											<a href="#" onclick="theme_num(11);">Theme 11</a>
										</li>
									</ul>
                                </li>
                            </ul>
				</h2>
			</div>
			<div class="card-body card-padding p-b-0">
				<div class="form-group m-b-5">
					<label for="bg_scr" class="col-sm-3 control-label">{help_icon title="Fon" message="The background of all SourceBans pages. If you want to use a color instead of a picture, write the color code in the '#ffffff' format, or rgb / rgba - without any ';', and not a link to the picture."} Fon</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" class="form-control" id="bg_scr" name="bg_scr" {if $config_bg_scr_value != ""}value="{$config_bg_scr_value}"{else}placeholder="Enter a link to a picture or a color code in the format #ffffff, or rgb / rgba (Optional)"{/if} />
						</div>
						<a href="http://www.stm.dp.ua/web-design/color-html.php" target="_blank">See: Color code for HTML</a>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label class="col-sm-3 control-label">{help_icon title="Repeating background" message="Repetition of the background picture, provided that the link to the picture is indicated."} Repeating</label>
					<div class="col-sm-9 p-t-10">
						<input type="text" value="{$config_bg_scr_rep_value}" id="bg_scr_rep" name="bg_scr_rep" hidden="hidden" />
						<table>
								<tr>
									<td>
										<label for="no-repeat" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="no-repeat" id="no-repeat" name="inlineRadioOptions_bg_rep" hidden="hidden" onchange="$('bg_scr_rep').value = this.value;"/>
											<i class="input-helper"></i> no-repeat
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label for="repeat" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="repeat" id="repeat" name="inlineRadioOptions_bg_rep" hidden="hidden" onchange="$('bg_scr_rep').value = this.value;"/>
											<i class="input-helper"></i> repeat
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label for="repeat-x" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="repeat-x" id="repeat-x" name="inlineRadioOptions_bg_rep" hidden="hidden" onchange="$('bg_scr_rep').value = this.value;"/>
											<i class="input-helper"></i> repeat-x
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label for="repeat-y" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="repeat-y" id="repeat-y" name="inlineRadioOptions_bg_rep" hidden="hidden" onchange="$('bg_scr_rep').value = this.value;"/>
											<i class="input-helper"></i> repeat-y
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label for="inherit" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="inherit" id="inherit" name="inlineRadioOptions_bg_rep" hidden="hidden" onchange="$('bg_scr_rep').value = this.value;"/>
											<i class="input-helper"></i> inherit
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label for="space" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="space" id="space" name="inlineRadioOptions_bg_rep" hidden="hidden" onchange="$('bg_scr_rep').value = this.value;"/>
											<i class="input-helper"></i> space
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label for="round" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="round" id="round" name="inlineRadioOptions_bg_rep" hidden="hidden" onchange="$('bg_scr_rep').value = this.value;"/>
											<i class="input-helper"></i> round
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label for="del_rep" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="" id="del_rep" name="inlineRadioOptions_bg_rep" hidden="hidden" onchange="$('bg_scr_rep').value = this.value;"/>
											<i class="input-helper"></i> <span class="c-red">Remove</span>
										</label>
									</td>
								</tr>
						</table>
						<a href="http://htmlbook.ru/css/background-repeat" target="_blank">See: Description background-repeat</a>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label class="col-sm-3 control-label">{help_icon title="Attachment" message="Allows you to configure the attachment of the picture, if it exist."} Attachment</label>
					<div class="col-sm-9 p-t-10">
						<input type="text" value="{$config_bg_att_value}" id="bg_scr_att" name="bg_scr_att" hidden="hidden" />
						<table>
								<tr>
									<td>
										<label for="fixed" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="fixed" id="fixed" name="inlineRadioOptions_bg_att" hidden="hidden" onchange="$('bg_scr_att').value = this.value;"/>
											<i class="input-helper"></i> fixed
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label for="scroll" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="scroll" id="scroll" name="inlineRadioOptions_bg_att" hidden="hidden" onchange="$('bg_scr_att').value = this.value;"/>
											<i class="input-helper"></i> scroll
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label for="inherit_2" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="inherit" id="inherit_2" name="inlineRadioOptions_bg_att" hidden="hidden" onchange="$('bg_scr_att').value = this.value;"/>
											<i class="input-helper"></i> inherit
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label for="local" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="local" id="local" name="inlineRadioOptions_bg_att" hidden="hidden" onchange="$('bg_scr_att').value = this.value;"/>
											<i class="input-helper"></i> local
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label for="del_att" class="radio radio-inline m-r-20 p-t-0">
											<input type="radio" value="" id="del_att" name="inlineRadioOptions_bg_att" hidden="hidden" onchange="$('bg_scr_att').value = this.value;"/>
											<i class="input-helper"></i> <span class="c-red">Remove</span>
										</label>
									</td>
								</tr>
						</table>
						<a href="http://htmlbook.ru/css/background-attachment" target="_blank">See: Description background-attachment</a>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="bg_pos" class="col-sm-3 control-label">{help_icon title="Position" message="Picture position, if any. Enter values like 'center' or 'top left', etc."} Position</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" class="form-control" id="bg_pos" name="bg_pos" {if $config_bg_pos_value != ""}value="{$config_bg_pos_value}"{else}placeholder="Type details, like: 'center' or 'top left' or etc.(Optional)"{/if} />
						</div>
						<a href="http://htmlbook.ru/css/background-position" target="_blank">See: About background-position</a>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="bg_size" class="col-sm-3 control-label">{help_icon title="Size" message="Picture size in %. E.g.: '100%'"} Size</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" class="form-control" id="bg_size" name="bg_size" {if $config_bg_size_value != ""}value="{$config_bg_size_value}"{else}placeholder="Enter the data to resize the picture. (Optional)"{/if} />
						</div>
						<a href="http://htmlbook.ru/faq/kak-rastyanut-fon-na-vsyu-shirinu-okna" target="_blank">See: Guide background-size</a>
					</div>
				</div>
			</div>
			<div class="card-header">
				<h2>Information settings <small>Manage Additional Features on the SourceBans Home Page.</small></h2>
			</div>
			<div class="alert alert-info" role="alert">If the function is disabled, further settings in this unit are not required.<br />If some parameters are not needed, just leave the input field - empty.</div>
			<div class="card-body card-padding p-b-0">
				<div class="form-group m-b-5">
					<label for="obrat_cvaz" class="col-sm-3 control-label">{help_icon title="Additional information" message="Adds an additional block on the main page to the 'Home' section, in which you can specify additional information."} Feedback</label>
					<div class="col-sm-9 p-t-10">
						<div class="toggle-switch p-b-5" data-ts-color="red">
							<input type="checkbox" id="obrat_cvaz" name="obrat_cvaz" hidden="hidden" /> 
							<label for="obrat_cvaz" class="ts-helper checkbox-inline m-r-20" style="z-index:2;"></label> Enable?
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="dash_textik" class="col-sm-3 control-label">{help_icon title="Additional description" message="The description that is added to the 'Home' section of the SourceBans home page."} Description</label>
					<div class="col-sm-9 p-t-15">
						<textarea cols="80" rows="20" id="dash_textik" name="dash_textik" class="html-editor">{if $dash_info_block_text != ""}{$dash_info_block_text}{else}{/if}</textarea>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="dash_textik_p" class="col-sm-3 control-label">{help_icon title="Additional sign" message="Sign that adding to description."} Sign</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" class="form-control" id="dash_textik_p" name="dash_textik_p" {if $dash_info_block_text_t != ""}value="{$dash_info_block_text_t}"{else}placeholder="Type details (optional)"{/if} />
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="dash_link_vk" class="col-sm-3 control-label">{help_icon title="Additional link" message="Link that adding to descption. E.g.: http://site1.com/"} Instagram</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" class="form-control" id="dash_link_vk" name="dash_link_vk" {if $dash_info_vk != ""}value="{$dash_info_vk}"{else}placeholder="Type details (optional)"{/if} />
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="dash_link_steam" class="col-sm-3 control-label">{help_icon title="Additional link" message="Link that adding to description. E.g.: http://site1.com/"} Steam</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" class="form-control" id="dash_link_steam" name="dash_link_steam" {if $dash_info_steam != ""}value="{$dash_info_steam}"{else}placeholder="Type details (optional)"{/if} />
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="dash_link_yout" class="col-sm-3 control-label">{help_icon title="Additional link" message="Link that adding to description. E.g.: http://site1.com/"} Youtube</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" class="form-control" id="dash_link_yout" name="dash_link_yout" {if $dash_info_yout != ""}value="{$dash_info_yout}"{else}placeholder="Type details"{/if} />
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="dash_link_faceb" class="col-sm-3 control-label">{help_icon title="Additional link" message="Link that adding to description. E.g.: http://site1.com/"} Facebook</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" class="form-control" id="dash_link_faceb" name="dash_link_faceb" {if $dash_info_face != ""}value="{$dash_info_face}"{else}placeholder="Type details"{/if} />
						</div>
					</div>
				</div>
			</div>
			<div class="card-header">
				<h2>Notification setiings <small>Fill in, if necessary, the text of the notifications accompanying the administrators / users.</small></h2>
			</div>
			<div class="alert alert-info" role="alert">If you do not want to use the notification, leave the input field for this notification blank.</div>
			<div class="card-body card-padding p-b-0">
				<div class="form-group m-b-5">
					<label for="yvedom_1" class="col-sm-3 control-label">{help_icon title="Notification" message="Notification that comes out when visiting the SourceBans home page."} On Home</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" class="form-control" id="yvedom_1" name="yvedom_1" {if $config_text_home != ""}value="{$config_text_home}"{else}placeholder="Type details (optional)"{/if} />
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="yvedom_2" class="col-sm-3 control-label">{help_icon title="Notification" message="The notification that goes out to the administrator when entering the monitoring page."} In Monitoring</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" class="form-control" id="yvedom_2" name="yvedom_2" {if $config_text_mon != ""}value="{$config_text_mon}"{else}placeholder="Type details (optional)"{/if} />
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="yvedom_3" class="col-sm-3 control-label">{help_icon title="Notification" message="The first notification that a user receives when they log into their SourceBans account."} In Profile (1)</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" class="form-control" id="yvedom_3" name="yvedom_3" {if $config_text_acc != ""}value="{$config_text_acc}"{else}placeholder="Type details (Optional)"{/if} />
						</div>
					</div>
				</div>
				<div class="form-group m-b-5">
					<label for="yvedom_4" class="col-sm-3 control-label">{help_icon title="Notification" message="The second notification that appears to the user when they log into their SourceBans account."} In Profile (2)</label>
					<div class="col-sm-9">
						<div class="fg-line">
							<input type="text" class="form-control" id="yvedom_4" name="yvedom_4" {if $config_text_acc2 != ""}value="{$config_text_acc2}"{else}placeholder="Type details (optional)"{/if} />
						</div>
					</div>
				</div>
			</div>
			<div class="card-body card-padding text-center">
				{sb_button text="Save" icon="<i class='zmdi zmdi-check-all'></i>" class="bgm-green btn-icon-text" id="asettings" submit=true}
				&nbsp;
				{sb_button text="Back" icon="<i class='zmdi zmdi-undo'></i>" class="bgm-red btn-icon-text" id="aback"}
			</div>
		</div>
	</div>
</form>
