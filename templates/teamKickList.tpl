{capture assign='contentHeader'}
	<header class="contentHeader articleContentHeader">
		<div class="contentHeaderTitle">
			<h1 class="contentTitle" itemprop="name headline">{lang}tourneysystem.team.page.kick.header{/lang}</h1>
		</div>
	</header>
{/capture}

<body id="tpl{$templateName|ucfirst}">

{include file='teamSidebar'  application='tourneysystem' assign='sidebar'}

{include file='header' sidebarOrientation='right'}

<div class="section sectionContainerList">
	<ul class="containerList">
		<li>
			<div>
				<div class="containerHeadline">
					{if ($team->player2ID != NULL)}<h3><a href="{link application='tourneysystem' controller='TeamKick' teamID=$teamID positionID='1'}{/link}" title="{lang}tourneysystem.team.page.kick.this{/lang}"><span class="icon icon16 fa-remove"></span></a> {@$team->getPlayer2Name()}</h3>{/if}
					{if ($team->player3ID != NULL)}<h3><a href="{link application='tourneysystem' controller='TeamKick' teamID=$teamID positionID='2'}{/link}" title="{lang}tourneysystem.team.page.kick.this{/lang}"><span class="icon icon16 fa-remove"></span></a> {@$team->getPlayer3Name()}</h3>{/if}
					{if ($team->player4ID != NULL)}<h3><a href="{link application='tourneysystem' controller='TeamKick' teamID=$teamID positionID='3'}{/link}" title="{lang}tourneysystem.team.page.kick.this{/lang}"><span class="icon icon16 fa-remove"></span></a> {@$team->getPlayer4Name()}</h3>{/if}
					{if ($team->sub1ID != NULL)}<h3><a href="{link application='tourneysystem' controller='TeamKick' teamID=$teamID positionID='4'}{/link}" title="{lang}tourneysystem.team.page.kick.this{/lang}"><span class="icon icon16 fa-remove"></span></a> {@$team->getSub1Name()}</h3>{/if}
					{if ($team->sub2ID != NULL)}<h3><a href="{link application='tourneysystem' controller='TeamKick' teamID=$teamID positionID='5'}{/link}" title="{lang}tourneysystem.team.page.kick.this{/lang}"><span class="icon icon16 fa-remove"></span></a> {@$team->getSub2Name()}</h3>{/if}
					{if ($team->sub3ID != NULL)}<h3><a href="{link application='tourneysystem' controller='TeamKick' teamID=$teamID positionID='6'}{/link}" title="{lang}tourneysystem.team.page.kick.this{/lang}"><span class="icon icon16 fa-remove"></span></a> {@$team->getSub3Name()}</h3>{/if}
				</div>
			</div>
		</li>
	</ul>
</div>

{include file='footer' sandbox=false}
</body>