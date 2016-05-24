{include file='documentHeader'}

<head>
	<title>{if $__wcf->getPageMenu()->getLandingPage()->menuItem != 'teamsystem.header.menu.teams'}{lang}teamsystem.header.menu.teams{/lang} - {/if}{PAGE_TITLE|language}</title>
	
	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">
{include file='header' sandbox=false}

<header class="boxHeadline">
	{if $__wcf->getPageMenu()->getLandingPage()->menuItem == 'teamsystem.header.menu.teams'}
		<h1>{PAGE_TITLE|language}</h1>
		{hascontent}<h2>{content}{PAGE_DESCRIPTION|language}{/content}</h2>{/hascontent}
	{else}
		<h1>{lang}teamsystem.header.menu.teams{/lang}</h1>
	{/if}
</header>

{include file='userNotice'}

{if $__wcf->getUser()->getUserID() != 0}
	
<div class="contentNavigation">
    {hascontent}
        <nav>
            <ul>
                {content}
                {if $__wcf->getSession()->getPermission('user.teamSystem.canCreateTeam')}
					<li><a href="{link application='teamsystem' controller='TeamCreate'}{/link}"
                           title="{lang}teamsystem.team.create{/lang}" class="button"><span
                                class="icon icon16 icon-asterisk"></span>
                        <span>{lang}teamsystem.team.create{/lang}</span></a></li>
				{/if}
				{if $pcTeamID != NULL}
					<li><a href="{link application='teamsystem' controller='Team' id=$pcTeamID}{/link}"
                           title="{lang}teamsystem.team.page.user{/lang}" class="button"><span
                                class="icon icon16 icon-group"></span>
                        <span>{lang}teamsystem.team.page.user{/lang}</span></a></li>
                {/if}
                {if $ps4TeamID != NULL}
                    <li><a href="{link application='teamsystem' controller='Team' id=$ps4TeamID}{/link}"
                           title="{lang}teamsystem.team.page.user{/lang}" class="button"><span
                                class="icon icon16 icon-group"></span>
                        <span>{lang}teamsystem.team.page.user{/lang}</span></a></li>
                {/if}
                {if $id=$ps3TeamID != NULL}
                    <li><a href="{link application='teamsystem' controller='Team' id=$ps3TeamID}{/link}"
                           title="{lang}teamsystem.team.page.user{/lang}" class="button"><span
                                class="icon icon16 icon-group"></span>
                        <span>{lang}teamsystem.team.page.user{/lang}</span></a></li>
                {/if}
                {if $id=$xb1TeamID != NULL}
                    <li><a href="{link application='teamsystem' controller='Team' id=$xb1TeamID}{/link}"
                           title="{lang}teamsystem.team.page.user{/lang}" class="button"><span
                                class="icon icon16 icon-group"></span>
                        <span>{lang}teamsystem.team.page.user{/lang}</span></a></li>
                {/if}
                {if $xb360TeamID != NULL}
                    <li><a href="{link application='teamsystem' controller='Team' id=$xb360TeamID}{/link}"
                           title="{lang}teamsystem.team.page.user{/lang}" class="button"><span
                                class="icon icon16 icon-group"></span>
                        <span>{lang}teamsystem.team.page.user{/lang}</span></a></li>
                {/if}
				<li><a href="{link application='teamsystem' controller='InvitationList'}{/link}"
                      title="{lang}teamsystem.team.invitations{/lang}" class="button"><span
                            class="icon icon16 icon-envelope"></span>
                    <span>{lang}teamsystem.team.invitations{/lang}</span></a></li>
                {event name='contentNavigationButtonsTop'}
                {/content}
            </ul>
        </nav>
    {/hascontent}
</div>

{/if}

{if $objects|count > 0}
	<div class="container marginTop">
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

</body>
</html>
