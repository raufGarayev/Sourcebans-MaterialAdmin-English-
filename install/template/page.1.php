<?php
	if(!defined("IN_SB")){echo "You should not be here. Only follow links!";die();}
?>

<div class="card m-b-0" id="messages-main">
	<div class="ms-menu">
		<div class="ms-block p-10">
			<span class="c-black"><b>Process</b></span>
		</div>

		<div class="listview lv-user" id="install-progress">
			<div class="lv-item media active">
				<div class="lv-avatar bgm-red pull-left">1</div>
				<div class="media-body">
					<div class="lv-title">Step: Licence</div>
					<div class="lv-small"><i class="zmdi zmdi-badge-check zmdi-hc-fw c-green"></i> Current step</div>
				</div>
			</div>

			<div class="lv-item media">
				<div class="lv-avatar bgm-orange pull-left">2</div>
				<div class="media-body">
					<div class="lv-title">Step: Database</div>
					<div class="lv-small"><i class="zmdi zmdi-time zmdi-hc-fw c-blue"></i> Next step</div>
				</div>
			</div>

			<div class="lv-item media">
				<div class="lv-avatar bgm-orange pull-left">3</div>
				<div class="media-body">
					<div class="lv-title">Step: System requirements</div>
					<div class="lv-small"><i class="zmdi zmdi-time zmdi-hc-fw c-blue"></i> Next step</div>
				</div>
			</div>

			<div class="lv-item media">
				<div class="lv-avatar bgm-orange pull-left">4</div>
				<div class="media-body">
					<div class="lv-title">Step: Creating tables</div>
					<div class="lv-small"><i class="zmdi zmdi-time zmdi-hc-fw c-blue"></i> Next step</div>
				</div>
			</div>

			<div class="lv-item media">
				<div class="lv-avatar bgm-orange pull-left">5</div>
				<div class="media-body">
					<div class="lv-title">Step: Install</div>
					<div class="lv-small"><i class="zmdi zmdi-time zmdi-hc-fw c-blue"></i> Next step</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="ms-body">
		<div class="listview lv-message">
			<div class="lv-header-alt clearfix">
				<div class="lvh-label">
					<span class="c-black">Familiarization</span>
				</div>
			</div>

			<div class="lv-body p-15">                                    
				Before installing this software, you must read and accept the terms of the license agreement. If you do not agree with the terms, create your own ban system.<br />
				For an explanation of this license agreement, please read <a href="https://creativecommons.org/licenses/by-nc-sa/3.0/" target="_blank">here</a>.
			</div>

			<div class="lv-header-alt clearfix">
				<div class="lvh-label">
					<span class="c-black">Creative Commons - Attribution-NonCommercial-ShareAlike 3.0</span>
				</div>
			</div>
			<div class="lv-body p-15" id="submit-introduction">
				<form action="index.php?p=submit" method="POST" enctype="multipart/form-data">
					<div id="submit-main">
						<textarea class="form-control" id="license" cols="105" rows="15" name="license">
This program is part of SourceBans ++.

All rights reserved © 2014-2016 Sarabveer Singh <me@sarabveer.me>

SourceBans ++ is licensed
Creative Commons Attribution-NonCommercial-ShareAlike 3.0.

You should have received a copy of the license along with this work. If not, see <http://creativecommons.org/licenses/by-nc-sa/3.0/>.

THE SOFTWARE IS PROVIDED "AS IS" WITHOUT WARRANTIES OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM OR LOSS, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

This program is based on work covered by the following copyright(s):
	SourceBans 1.4.11
	Copyright © 2007-2014 SourceBans Team - Part of GameConnect
	Licensed under CC BY-NC-SA 3.0
	Страница: <http://www.sourcebans.net/> - <http://www.gameconnect.net/>

	SourceBans TF2 Theme v1.0
	Copyright © 2014 IceMan
	Страница: <https://forums.alliedmods.net/showthread.php?t=252533>
						</textarea>
					</div>
				</form>

				<div class="col-sm-12 p-l-0 m-10">
					<div class="col-sm-6">
						<div class="checkbox m-b-15">
							<label for="accept">
								<input type="checkbox" name="accept" id="accept" hidden="hidden" />
								<i class="input-helper"></i> I have read and accept the terms
							</label>
						</div>
					</div>

					<div class="col-sm-6" align="right">
						<button onclick="checkAccept()" class="btn btn-primary waves-effect" id="button" name="button">Accept</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
<script type="text/javascript">
$E('html').onkeydown = function(event){
	var event = new Event(event);
	if (event.key == 'enter' ) checkAccept();
};
function checkAccept()
{
	if($('accept').checked)
		window.location = "index.php?step=2";
	else
	{
		ShowBox('Error', 'If you do not accept the terms, refuse to install this software.', 'red', '', true);
	}
}
</script>
