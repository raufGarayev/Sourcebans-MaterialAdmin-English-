{* Шаблон вывода информации о наличии или отсутствии бана по IP-адресу *}
<div class="alert alert-{if $IsBanned > 0}danger{else}success{/if}" role="alert">
  <h4>Quick ban search</h4>
  <span class="p-l-10"><b>Your ip adress - {$UserIP}</b>.&nbsp;
  {if $IsBanned === NULL}
    Everything is fine, today no violations.
  {else}
    You have active bans, you are denied access to the servers. More info <a href="index.php?p=banlist&advType=banid&advSearch={$IsBanned}">here</a>.
  {/if}
  </span>

  <br />
  <span class="p-l-10">Check for a SteamID ban in a couple of clicks <a href="index.php?p=check">here</a>.</span>
</div>