{display_header title="MODs Repository" text="List of all MODs in repository of Sourcebans"}
<div class="card-body card-padding">
    <table class="table table-striped">
        <tbody>
            <tr>
                <th width="5%"  class="text-center">Icon</th>
                <th width="70%" class="text-left">Name</th>
                <th class="text-right">Status</th>
            </tr>
            {foreach from="$modlist" item="mod"}
            <tr id="{$mod.folder}">
                <td class="text-center"><img src="{$mirror}{$mirror_iconsdir}{$mod.icon}"></td>
                <td class="text-left">{$mod.name|htmlspecialchars}</td>
                <td class="text-right">{if $mod.installed}<strong>Installed</strong>{else}<strong><a href="#" onClick="xajax_InstallMOD('{$mod.folder}'); return false;">Install</a></strong>{/if}</td>
            </tr>
            {/foreach}
        </tbody>
    </table>
</div>
