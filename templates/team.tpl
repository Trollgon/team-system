{include file='documentHeader'}

<head>
	<title>{if $__wcf->getPageMenu()->getLandingPage()->menuItem != 'teamsystem.header.menu.teams'}{lang}teamsystem.header.menu.teams{/lang} - {/if}{PAGE_TITLE|language}</title>
	
	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">

{if $__boxSidebar|isset && $__boxSidebar}
	{capture assign='sidebar'}
		{@$__boxSidebar}
	{/capture}
{/if}

{include file='header' sidebarOrientation='right'}


<header class="boxHeadline">
	<h1>[{$team->getTeamTag()}] - {$team->getTeamName()}</h1>
</header>

{include file='userNotice'}
{if $__wcf->getUser()->getUserID != 0}
	<div class="contentNavigation">
		{hascontent}
			<nav>
				<ul>
					{content}
						{if $team->isTeamLeader()}
							<li><a href="{link application='teamsystem' controller='TeamDelete' teamID=$teamID}{/link}"
							title="{lang}teamsystem.team.invitation.delete{/lang}" class="button"><span
									class="icon icon16 icon-remove"></span>
								<span>{lang}teamsystem.team.delete{/lang}</span></a></li>
							<li><a href="{link application='teamsystem' controller='TeamInvitation' teamID=$teamID}{/link}"
								title="{lang}teamsystem.team.invitation.send{/lang}" class="button"><span
									class="icon icon16 icon-plus"></span>
								<span>{lang}teamsystem.team.invitation{/lang}</span></a></li>
						{/if}
						{if $team->isTeamMember()}
							<li><a href="{link application='teamsystem' controller='TeamLeave' teamID=$teamID}{/link}"
								title="{lang}teamsystem.team.invitation.leave{/lang}" class="button"><span
									class="icon icon16 icon-signout"></span>
								<span>{lang}teamsystem.team.leave{/lang}</span></a></li>
						{/if}
					{event name='contentNavigationButtonsTop'}
					{/content}
				</ul>
			</nav>
		{/hascontent}
	</div>	{/if}

<header class="boxHeadline boxSubHeadline">

	<h2>{lang}teamsystem.team.page.members{/lang} <span class="badge">{#$playerObjects->count()}</span></h2>

</header>

<div class="container marginTop">
		<ul class="containerList userList">	
			<ol class="containerList userList">
				{foreach from=$playerObjects item=user}
					{include file='userListItem'}
				{/foreach}
			</ol>
		</ul>
</div>
{if $subObjects|count > 0}
	<header class="boxHeadline boxSubHeadline">

		<h2>{lang}teamsystem.team.page.subs{/lang} <span class="badge">{#$subObjects->count()}</span></h2>

	</header>
	
	<div class="container marginTop">
		<ul class="containerList userList">	
			<ol class="containerList userList">
				{foreach from=$subObjects item=user}
					{include file='userListItem'}
				{/foreach}
			</ol>
		</ul>
	</div>
{/if}


{include file='footer' sandbox=false}
</body>
</html>
