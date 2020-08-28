<div class="card">
  <div class="card-header">
    <h2>Quick ban search</h2>
  </div>

  <div class="alert alert-info" role="alert">
    <h4>Data used in the search for bans</h4>
    <ul class="clist clist-star">
      <li><b>IP adress</b>: {$user.ip}</li>
      <li><b>SteamID</b>: {if $user.steam == false}Unknown{else}{$user.steam}{/if}
    </ul>
    {if $user.steam == false}
    <br />
    For quick STEAM ID ban search, <a href="steam_auth.php?reason=user_auth">sign in</a>.
    {/if}
  </div>

  <ul class="clist clist-star">
    <li><b>IP ban</b>: {if $check_result.GameBan.IP}Active, more info <a href="index.php?p=banlist&advType=banid&advSearch={$check_result.GameBan.IP}">here</a>{else}Missing{/if}.</li>
    <li><b>STEAM ID ban</b>: {if $user.steam}{if $check_result.GameBan.Steam > 0}Active, more info <a href="index.php?p=banlist&advType=banid&advSearch={$check_result.GameBan.Steam}">here</a>{else}Отсутствует{/if}{else}Can't check, unknown STEAM ID{/if}.</li>
    <li><b>Text chat</b>: {if $user.steam}{if $check_result.CommBan.Gag > 0}Active, more info <a href="index.php?p=comms&advType=banid&advSearch={$check_result.CommBan.Gag}">here</a>{else}Отсутствует{/if}{else}Can't check, unknown STEAM ID{/if}.</li>
    <li><b>Voice chat</b>: {if $user.steam}{if $check_result.CommBan.Voice > 0}Active, more info <a href="index.php?p=comms&advType=banid&advSearch={$check_result.CommBan.Voice}">здесь</a>{else}Отсутствует{/if}{else}Can't check, unknown STEAM ID{/if}.</li>
  </ul>
  <br />
</div>