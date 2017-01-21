{capture assign='contentHeader'}
    <header class="contentHeader articleContentHeader">
        <div class="contentHeaderTitle">
            <h1 class="contentTitle" itemprop="name headline">{lang}teamsystem.header.menu.teams{/lang} <span class="badge">{@$teamsCount}</span></h1>
        </div>

        {if $__wcf->getUser()->getUserID() != 0}
            {hascontent}
                <nav class="contentHeaderNavigation">
                    <ul>
                        {content}
                        {if $__wcf->getSession()->getPermission('user.teamSystem.canCreateTeam')}
                            <li><a href="{link application='teamsystem' controller='TeamCreate'}{/link}"
                                   title="{lang}teamsystem.team.create{/lang}" class="button"><span
                                            class="icon icon16 fa-asterisk"></span>
                                    <span>{lang}teamsystem.team.create{/lang}</span></a></li>
                        {/if}
                        {if $teamList|count > 1}
                            <li class="dropdown">
                                <a class="dropdownToggle boxFlag box24 button">
                                    <span class="icon icon16 fa-group"></span>
                                    <span>{lang}teamsystem.team.page.user.many{/lang}</span>
                                </a>
                                <ul class="dropdownMenu">
                                    {foreach from=$teamList item=team}
                                        <li class="boxFlag"><a href="{link application='teamsystem' controller='Team' id=$team->teamID}{/link}"
                                               title="{$team->teamName}" class="box24"><span
                                                        class="icon icon16 fa-group"></span>
                                                <span>{$team->teamName}</span></a>
                                        </li>
                                    {/foreach}
                                </ul>
                            </li>
                        {elseif $teamList|count > 0}
                            {foreach from=$teamList item=team}
                                <li><a href="{link application='teamsystem' controller='Team' id=$team->teamID}{/link}"
                                       title="{lang}teamsystem.team.page.user{/lang}: {$team->teamName}" class="button"><span
                                                class="icon icon16 fa-group"></span>
                                        <span>{lang}teamsystem.team.page.user{/lang}: {$team->teamName}</span></a>
                                </li>
                            {/foreach}
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
            {foreach from=$objects item=team}
                {include file='teamItem' application='teamsystem'}
            {/foreach}
        </ol>
    </div>
{else}
    <p class="info">{lang}teamsystem.team.overview.noTeams{/lang}</p>
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
