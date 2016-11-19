{include file='documentHeader'}

<head>
	<title>{if $team->getTeamID() == 0}{lang}teamsystem.header.menu.teams{/lang} - {else} [{$team->getTeamTag()}] - {$team->getTeamName()} - {/if}{PAGE_TITLE|language}</title>
	
	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">

{include file='teamSidebar'  application='teamsystem' assign='sidebar'}

{include file='header' sidebarOrientation='left'}

<header class="boxHeadline">
	<h1>[{$team->getTeamTag()}] - {$team->getTeamName()}</h1>
</header>

{include file='userNotice'}

{if $__wcf->getUser()->getUserID() != 0}

<div class="contentNavigation">
    {hascontent}
        <nav>
            <ul>
                {content}
				{if $team->isTeamLeader()}
					{if $team->dummyTeam == 0}
                		{if TEAMSYSTEM_LOCK_TEAMEDIT == false}
                		<li><a href="{link application='teamsystem' controller='TeamEdit' teamID=$teamID}{/link}"
	                           title="{lang}teamsystem.team.page.edit{/lang}" class="button"><span
	                                class="icon icon16 icon-pencil"></span>
	                        <span>{lang}teamsystem.team.page.edit{/lang}</span></a></li>
	                    {/if}
					{/if}
				{/if}
				{if (!$team->isTeamMember() && !$team->isTeamLeader()) || ($__wcf->getUser()->userID == 1 && $team->dummyTeam == 1)}
					{if $__wcf->getSession()->getPermission('mod.teamSystem.canEditTeams')}
                	<li><a href="{link application='teamsystem' controller='TeamEdit' teamID=$teamID}{/link}"
                           title="{lang}teamsystem.team.page.edit.mod{/lang}" class="button"><span
                                class="icon icon16 icon-pencil"></span>
                        <span>{lang}teamsystem.team.page.edit.mod{/lang}</span></a></li>
					{/if}
				{/if}
				{if $team->dummyTeam == 0}
					{if $team->isTeamMember()}
						{if TEAMSYSTEM_LOCK_TEAMEDIT == false}
						<li><a href="{link application='teamsystem' controller='TeamLeave' teamID=$teamID}{/link}"
	                           title="{lang}teamsystem.team.page.leave{/lang}" class="button"><span
	                                class="icon icon16 icon-signout"></span>
	                        <span>{lang}teamsystem.team.page.leave{/lang}</span></a></li>
	                    {/if}
					{/if}
				{/if}
                {event name='contentNavigationButtonsTop'}
                {/content}
            </ul>
        </nav>
    {/hascontent}
</div>

{/if}

{if $team->dummyTeam == 0}
	{if $team->isTeamMember()}
		{if $playerMissingContactInfo == true}
			<p class="warning">{lang}teamsystem.team.page.missingContactinfo.player{/lang}</p>
		{/if}
	{/if}

	{if $team->isTeamLeader()}
		{if $memberMissing == true}
			<p class="warning">{lang}teamsystem.team.page.notEnoughMembers{/lang}</p>
		{else}
			{if $subMissing == true}
				<p class="info">{lang}teamsystem.team.page.noSubs{/lang}</p>
			{/if}
		{/if}
		{if $missingContactInfo == true}
			<p class="warning">{lang}teamsystem.team.page.missingContactinfo{/lang}</p>
		{/if}
		{if $playerMissingContactInfo == true}
			<p class="warning">{lang}teamsystem.team.page.missingContactinfo.player{/lang}</p>
		{/if}
	{/if}
{else}
	<p class="warning">{lang}teamsystem.team.page.dummy{/lang}</p>
{/if}

{if $team->dummyTeam == 0}
	<header class="boxHeadline boxSubHeadline">

		<h2>{lang}teamsystem.team.page.members{/lang}{if $playerObjects|count > 1}s{/if} <span class="badge">{#$playerObjects->count()}</span></h2>

	</header>

	<div class="container marginTop">
			<ul class="containerList userList">
				<ol class="containerList userList">
					{foreach from=$playerObjects item=user}
						{include file='playerItem' application='teamsystem'}
					{/foreach}
				</ol>
			</ul>
	</div>
	{if $subObjects|count > 0}
		<header class="boxHeadline boxSubHeadline">

			<h2>{lang}teamsystem.team.page.subs{/lang}{if $subObjects|count > 1}s{/if} <span class="badge">{#$subObjects->count()}</span></h2>

		</header>

		<div class="container marginTop">
			<ul class="containerList userList">
				<ol class="containerList userList">
					{foreach from=$subObjects item=user}
						{include file='playerItem' application='teamsystem'}
					{/foreach}
				</ol>
			</ul>
		</div>
	{/if}
{/if}


{include file='footer' sandbox=false}
</body>
</html>
