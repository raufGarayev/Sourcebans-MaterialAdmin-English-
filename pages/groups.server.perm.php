<?php 
if(!defined("IN_SB")){echo "Permission error!";die();}
?>

<div class="table-responsive">
   <table cellspacing="0" cellpadding="0" class="table">
      <tbody>
         <tr>
            <th width="30%">Name</th>
            <th width="5%">Flag</th>
            <th width="50%">Purpose</th>
            <th width="15%">Activated</th>
         </tr>
         <tr id="srootcheckbox" name="srootcheckbox">
            <td>Root admin (Full access)</td>
            <td>z</td>
            <td> Magically enables all flags.</td>
            <td>
               <div class="checkbox">
                  <label for="s14">
                  <input type="checkbox" name="s14" id="s14" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>           
         </tr>
         <tr>
            <th colspan="5">Standart admin permissions </th>
         </tr>
         <tr>
            <td>Reserved slots </td>
            <td>a</td>
            <td> Reserved slots access.</td>
            <td>
               <div class="checkbox">
                  <label for="s1">
                  <input type="checkbox" name="s1" id="s1" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>Generic</td>
            <td>b</td>
            <td>Generic admin; required for admins..</td>
            <td>
               <div class="checkbox">
                  <label for="s23">
                  <input type="checkbox" name="s23" id="s23" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>            	
         </tr>
         <tr>
            <td>Kick</td>
            <td>c</td>
            <td>Kick players.</td>
            <td>
               <div class="checkbox">
                  <label for="s2">
                  <input type="checkbox" name="s2" id="s2" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>Ban </td>
            <td>d</td>
            <td>Ban players.</td>
            <td>
               <div class="checkbox">
                  <label for="s3">
                  <input type="checkbox" name="s3" id="s3" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>Unban</td>
            <td>e</td>
            <td>Unban players.</td>
            <td>
               <div class="checkbox">
                  <label for="s4">
                  <input type="checkbox" name="s4" id="s4" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>Slay</td>
            <td>f</td>
            <td>Slay/kill players.</td>
            <td>
               <div class="checkbox">
                  <label for="s5">
                  <input type="checkbox" name="s5" id="s5" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>Change map </td>
            <td>g</td>
            <td>Change the map or major gameplay features.</td>
            <td>
               <div class="checkbox">
                  <label for="s6">
                  <input type="checkbox" name="s6" id="s6" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>Cvar </td>
            <td>h</td>
            <td>Cvar changes.</td>
            <td>
               <div class="checkbox">
                  <label for="s7">
                  <input type="checkbox" name="s7" id="s7" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>Config</td>
            <td>i</td>
            <td>Execute config files.</td>
            <td>
               <div class="checkbox">
                  <label for="s8">
                  <input type="checkbox" name="s8" id="s8" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>Admin chat</td>
            <td>j</td>
            <td>Special chat privileges.</td>
            <td>
               <div class="checkbox">
                  <label for="s9">
                  <input type="checkbox" name="s9" id="s9" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>Vote</td>
            <td>k</td>
            <td>Start or create votes..</td>
            <td>
               <div class="checkbox">
                  <label for="s10">
                  <input type="checkbox" name="s10" id="s10" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>Server password</td>
            <td>l</td>
            <td>Set a password on the server.</td>
            <td>
               <div class="checkbox">
                  <label for="s11">
                  <input type="checkbox" name="s11" id="s11" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>RCON </td>
            <td>m</td>
            <td>Use RCON commands.</td>
            <td>
               <div class="checkbox">
                  <label for="s12">
                  <input type="checkbox" name="s12" id="s12" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>Cheats</td>
            <td>n</td>
            <td>Change sv_cheats or use cheating commands..</td>
            <td>
               <div class="checkbox">
                  <label for="s13">
                  <input type="checkbox" name="s13" id="s13" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <th colspan="5" class="tablerow4">Immunity </th>
         </tr>
         <tr>
            <td>Immunity </td>
            <td>-</td>
            <td>
				<div class="fg-line">
					<input type="hidden" id="fromsub" value="">
					<input type="number" tabindex="1" class="form-control" id="immunity" name="immunity" placeholder="Choose the immunity level. The higher the number, the more immunity..">
				</div>               
            </td>
            <td align="center"></td>
         </tr>
         <tr>
            <th colspan="5" class="tablerow4">Custom Admin Server Permissions</th>
         </tr>
         <tr>
            <td>Custom flag "o"</td>
            <td>o</td>
            <td>-</td>
            <td>
               <div class="checkbox">
                  <label for="s17">
                  <input type="checkbox" name="s17" id="s17" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>Custom flag "p"</td>
            <td>p</td>
            <td>-</td>
            <td>
               <div class="checkbox">
                  <label for="s18">
                  <input type="checkbox" name="s18" id="s18" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>Custom flag "q"</td>
            <td>q</td>
            <td>-</td>
            <td>
               <div class="checkbox">
                  <label for="s19">
                  <input type="checkbox" name="s19" id="s19" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>Custom flag "r"</td>
            <td>r</td>
            <td>-</td>
            <td>
               <div class="checkbox">
                  <label for="s20">
                  <input type="checkbox" name="s20" id="s20" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>Custom flag "s"</td>
            <td>s</td>
            <td>-</td>
            <td>
               <div class="checkbox">
                  <label for="s21">
                  <input type="checkbox" name="s21" id="s21" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
         <tr>
            <td>Custom flag "t"</td>
            <td>t</td>
            <td>-</td>
            <td>
               <div class="checkbox">
                  <label for="s22">
                  <input type="checkbox" name="s22" id="s22" hidden="hidden" />
                  <i class="input-helper"></i>
                  </label>	
               </div> 
            </td>
         </tr>
      </tbody>
   </table>
</div>