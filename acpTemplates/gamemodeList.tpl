{include file='header' pageTitle='wcf.acp.menu.link.tourneysystem.gamemode.list'}

<script data-relocate="true">
    $(function () {
        new WCF.Action.Delete('tourneysystem\\data\\gamemode\\GamemodeAction', '.jsGamemodeRow');
    });
</script>

<header class="contentHeader">
    <div class="contentHeaderTitle">
        <h1 class="contentTitle">{lang}wcf.acp.menu.link.tourneysystem.gamemode.list{/lang}</h1>
    </div>

    <nav class="contentHeaderNavigation">
        <ul>
            <li><a href="{link application='tourneysystem' controller='GamemodeAdd'}{/link}" class="button"><span
                            class="icon icon16 fa-plus"></span>
                    <span>{lang}wcf.acp.menu.link.tourneysystem.gamemode.add{/lang}</span></a></li>

            {event name='contentHeaderNavigation'}
        </ul>
    </nav>
</header>

{if $objects|count}
    <div class="section tabularBox">
        <table class="table">
            <thead>
            <tr>
                <th class="columnID columnEntryID" colspan="2">
                    {lang}wcf.global.objectID{/lang}
                </th>
                <th class="columnText columnClassName">
                    {lang}tourneysystem.acp.general.title{/lang}
                </th>
                {event name='headColumns'} </tr>
            </thead>
            <tbody>
            {foreach from=$objects item=gamemode}
                <tr class="jsGamemodeRow">
                    <td class="columnIcon">
                        {* toggle, edit, delete *}
                        <a href="{link application='tourneysystem' controller='GamemodeEdit' object=$gamemode}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip"><span class="icon icon16 fa-pencil"></span></a>
                        <span class="icon icon16 fa-times jsDeleteButton jsTooltip pointer" title="{lang}wcf.global.button.delete{/lang}" data-object-id="{@$gamemode->gamemodeID}" data-confirm-message-html="{lang __encode=true}tourneysystem.acp.gamemode.save{/lang}"></span>
                        {event name='buttons'}
                    </td>
                    <td class="columnID"><p>{@$gamemode->gamemodeID}</p></td>
                    <td class="columnText columnClassName"><p>{$gamemode->gamemodeName}</p></td>
                    {event name='columns'} </tr>
            {/foreach}
            </tbody>
        </table>
    </div>


    <footer class="contentFooter">

        {hascontent}
            <nav class="contentFooterNavigation">
                <ul>
                    {content}
                        <li><a href="{link application='tourneysystem' controller='GamemodeAdd'}{/link}" class="button"><span
                                        class="icon icon16 fa-plus"></span>
                                <span>{lang}wcf.acp.menu.link.tourneysystem.gamemode.add{/lang}</span></a></li>
                    {event name='contentFooterNavigation'}
                    {/content}
                </ul>
            </nav>
        {/hascontent}
    </footer>
{else}
    <p class="info">{lang}tourneysystem.acp.general.noContent{/lang}</p>
{/if}

{include file='footer'}
