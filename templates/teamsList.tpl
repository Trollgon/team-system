{include file='documentHeader'}

<head>
	<title>{if $__wcf->getPageMenu()->getLandingPage()->menuItem != 'tourneysystem.header.menu.teams'}{lang}tourneysystem.header.menu.teams{/lang} - {/if}{PAGE_TITLE|language}</title>
	
	{include file='headInclude' sandbox=false}
</head>



<body id="tpl{$templateName|ucfirst}">
{include file='header' sandbox=false}

<header class="boxHeadline">
	{if $__wcf->getPageMenu()->getLandingPage()->menuItem == 'tourneysystem.header.menu.teams'}
		<h1>{PAGE_TITLE|language}</h1>
		{hascontent}<h2>{content}{PAGE_DESCRIPTION|language}{/content}</h2>{/hascontent}
	{else}
		<h1>{lang}tourneysystem.header.menu.teams{/lang}</h1>
	{/if}
</header>

{include file='userNotice'}
	
<div class="contentNavigation">
    {hascontent}
        <nav>
            <ul>
                {content}
                {if $__wcf->getSession()->getPermission('user.teamSystem.canCreateTeam')}
					<li><a href="{link application='tourneysystem' controller='TeamCreate'}{/link}"
                           title="{lang}tourneysystem.team.add{/lang}" class="button"><span
                                class="icon icon16 icon-asterisk"></span>
                        <span>{lang}tourneysystem.team.add{/lang}</span></a></li>
				{/if}
				{if $pcTeamID != NULL}
					<li><a href="{link application='tourneysystem' controller='Team' id=$pcTeamID platformID='1'}{/link}"
                           title="{lang}tourneysystem.team.page.user{/lang}" class="button"><span
                                class="icon icon16 icon-group"></span>
                        <span>{lang}tourneysystem.team.page.user{/lang}</span></a></li>
                {/if}
                {if $ps4TeamID != NULL}
                    <li><a href="{link application='tourneysystem' controller='Team' id=$ps4TeamID platformID='2'}{/link}"
                           title="{lang}tourneysystem.team.page.user{/lang}" class="button"><span
                                class="icon icon16 icon-group"></span>
                        <span>{lang}tourneysystem.team.page.user{/lang}</span></a></li>
                {/if}
                {if $id=$ps3TeamID != NULL}
                    <li><a href="{link application='tourneysystem' controller='Team' id=$ps3TeamID platformID='3'}{/link}"
                           title="{lang}tourneysystem.team.page.user{/lang}" class="button"><span
                                class="icon icon16 icon-group"></span>
                        <span>{lang}tourneysystem.team.page.user{/lang}</span></a></li>
                {/if}
                {if $id=$xb1TeamID != NULL}
                    <li><a href="{link application='tourneysystem' controller='Team' id=$xb1TeamID platformID='4'}{/link}"
                           title="{lang}tourneysystem.team.page.user{/lang}" class="button"><span
                                class="icon icon16 icon-group"></span>
                        <span>{lang}tourneysystem.team.page.user{/lang}</span></a></li>
                {/if}
                {if $xb360TeamID != NULL}
                    <li><a href="{link application='tourneysystem' controller='Team' id=$xb360TeamID platformID='5'}{/link}"
                           title="{lang}tourneysystem.team.page.user{/lang}" class="button"><span
                                class="icon icon16 icon-group"></span>
                        <span>{lang}tourneysystem.team.page.user{/lang}</span></a></li>
                {/if}
                {event name='contentNavigationButtonsTop'}
                {/content}
            </ul>
        </nav>
    {/hascontent}
</div>

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

