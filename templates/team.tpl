{include file='documentHeader'}

<head>
	<title>{if $__wcf->getPageMenu()->getLandingPage()->menuItem != 'tourneysystem.header.menu.teams'}{lang}tourneysystem.header.menu.teams{/lang} - {/if}{PAGE_TITLE|language}</title>
	
	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">
{include file='header' sandbox=false}

<header class="boxHeadline">
	<h1>[{$team->getTeamTag()}] - {$team->getTeamName()}</h1>
</header>

{include file='userNotice'}

<div class="contentNavigation">
    {hascontent}
        <nav>
            <ul>
                {content}
                {if $team->isTeamLeader()}
					<li><a href="{link application='tourneysystem' controller='TeamEdit' teamID=$teamID platformID=$platformID}{/link}"
                           title="{lang}tourneysystem.team.edit{/lang}" class="button"><span
                                class="icon icon16 icon-pencil"></span>
                        <span>{lang}tourneysystem.team.edit{/lang}</span></a></li>
                    <li><a href="{link application='tourneysystem' controller='TeamInvitation' teamID=$teamID platformID=$platformID}{/link}"
                           title="{lang}tourneysystem.team.invitation.send{/lang}" class="button"><span
                                class="icon icon16 icon-plus"></span>
                        <span>{lang}tourneysystem.team.invitation{/lang}</span></a></li>
				{/if}
                {event name='contentNavigationButtonsTop'}
                {/content}
            </ul>
        </nav>
    {/hascontent}
</div>

<div class="container marginTop">
		<ul class="containerList userList">
			<li class="exampleBox">
				<fieldset>
					<legend>{lang}tourneysystem.team.page.leader{/lang}</legend>
				</fieldset>
			</li>
		</ul>
	</div>


{include file='footer' sandbox=false}
</body>
</html>