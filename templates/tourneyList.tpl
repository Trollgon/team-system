{capture assign='contentHeader'}
    <header class="contentHeader articleContentHeader">
        <div class="contentHeaderTitle">
            <h1 class="contentTitle" itemprop="name headline">{lang}tourneysystem.header.menu.tourneys{/lang}</h1>
        </div>

        {if $__wcf->getUser()->getUserID() != 0}
            {hascontent}
                <nav class="contentHeaderNavigation">
                    <ul>
                        {content}
                        {if $__wcf->getSession()->getPermission('admin.tourneySystem.canCreateTourneys')}
                            <li><a href="{link application='tourneysystem' controller='TourneyCreate'}{/link}"
                                   title="{lang}tourneysystem.tourney.create{/lang}" class="button"><span
                                            class="icon icon16 fa-asterisk"></span>
                                    <span>{lang}tourneysystem.tourney.create{/lang}</span></a></li>
                        {/if}
                        {event name='contentHeaderNavigation'}
                        {/content}
                    </ul>
                </nav>
            {/hascontent}
        {/if}
    </header>
{/capture}

{include file='header'}

{if $objects|count > 0}
    <div class="section sectionContainerList">
        <ol class="containerList userList">
            {foreach from=$objects item=tourney}
                <tr class="appRow">
                    <td class="columnName"><a href="{link controller='Tourney' application='tourneysystem' object=$tourney}{/link}">{@$tourney->tourneyName}</a></td>
                    {event name='columns'}
                </tr>
            {/foreach}
        </ol>
    </div>
{else}
    <p class="info">{lang}tourneysystem.tourney.list.noTourneys{/lang}</p>
{/if}

<div class="contentNavigation">
    {hascontent}
        <nav>
            <ul>
                {content}
                {event name='contentNavigationButtonsBottom'}
                {/content}
            </ul>
        </nav>
    {/hascontent}
</div>

{include file='footer'}