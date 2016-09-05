{include file='documentHeader'}

<head>
	<title>{if $team->getTeamID() == 0}{lang}teamsystem.header.menu.teams{/lang} - {else} [{$team->getTeamTag()}] - {$team->getTeamName()} - {/if}{PAGE_TITLE|language}</title>
	
	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">

{include file='teamSidebar'  application='teamsystem' assign='sidebar'}

{include file='header' sidebarOrientation='left'}

<header class="boxHeadline">
	<h1>{lang}teamsystem.team.page.kick.header{/lang}</h1>
</header>

{include file='userNotice'}

<div class="contentNavigation">
    {hascontent}
        <nav>
            <ul>
                {content}
                {if $team->isTeamLeader()}
                	<li><a href="{link application='teamsystem' controller='TeamEdit' teamID=$teamID}{/link}"
                           title="{lang}teamsystem.team.page.edit{/lang}" class="button"><span
                                class="icon icon16 icon-pencil"></span>
                        <span>{lang}teamsystem.team.page.edit{/lang}</span></a></li>
				{/if}
				{/content}
            </ul>
        </nav>
    {/hascontent}
</div>

<div class="container marginTop">
		<ul class="containerList">
			<li>
				<div>
					<div class="containerHeadline">
						{if ($team->player2ID != NULL)}<h3><a href="{link application='teamsystem' controller='TeamKick' teamID=$teamID positionID='1'}{/link}" title="{lang}teamsystem.team.page.kick.this{/lang}"><span class="icon icon16 icon-remove"></span></a> {@$team->getPlayer2Name()}</h3>{/if}
						{if ($team->player3ID != NULL)}<h3><a href="{link application='teamsystem' controller='TeamKick' teamID=$teamID positionID='2'}{/link}" title="{lang}teamsystem.team.page.kick.this{/lang}"><span class="icon icon16 icon-remove"></span></a> {@$team->getPlayer3Name()}</h3>{/if}
						{if ($team->player4ID != NULL)}<h3><a href="{link application='teamsystem' controller='TeamKick' teamID=$teamID positionID='3'}{/link}" title="{lang}teamsystem.team.page.kick.this{/lang}"><span class="icon icon16 icon-remove"></span></a> {@$team->getPlayer4Name()}</h3>{/if}
						{if ($team->sub1ID != NULL)}<h3><a href="{link application='teamsystem' controller='TeamKick' teamID=$teamID positionID='4'}{/link}" title="{lang}teamsystem.team.page.kick.this{/lang}"><span class="icon icon16 icon-remove"></span></a> {@$team->getSub1Name()}</h3>{/if}
						{if ($team->sub2ID != NULL)}<h3><a href="{link application='teamsystem' controller='TeamKick' teamID=$teamID positionID='5'}{/link}" title="{lang}teamsystem.team.page.kick.this{/lang}"><span class="icon icon16 icon-remove"></span></a> {@$team->getSub2Name()}</h3>{/if}
						{if ($team->sub3ID != NULL)}<h3><a href="{link application='teamsystem' controller='TeamKick' teamID=$teamID positionID='6'}{/link}" title="{lang}teamsystem.team.page.kick.this{/lang}"><span class="icon icon16 icon-remove"></span></a> {@$team->getSub3Name()}</h3>{/if}
					</div>
				</div>
			</li>
		</ul>
</div>


{include file='footer' sandbox=false}
</body>
</html>
