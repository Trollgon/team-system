{include file='documentHeader'}

<head>
	<title>{if $__wcf->getPageMenu()->getLandingPage()->menuItem != 'tourneysystem.header.menu.index'}{lang}tourneysystem.header.menu.index{/lang} - {/if}{PAGE_TITLE|language}</title>
	
	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">
{include file='header' sandbox=false}

<header class="boxHeadline">
	{if $__wcf->getPageMenu()->getLandingPage()->menuItem == 'tourneysystem.header.menu.index'}
		<h1>{PAGE_TITLE|language}</h1>
		{hascontent}<h2>{content}{PAGE_DESCRIPTION|language}{/content}</h2>{/hascontent}
	{else}
		<h1>{lang}tourneysystem.header.menu.index{/lang}</h1>
	{/if}
</header>

{include file='userNotice'}

<div class="contentNavigation">
    {hascontent}
        <nav>
            <ul>
                {content}
                    <li><a href="{link application='tourneysystem' controller='AddTeam'}{/link}"
                           title="{lang}tourneysystem.team.add{/lang}" class="button"><span
                                class="icon icon16 icon-asterisk"></span>
                        <span>{lang}tourneysystem.team.add{/lang}</span></a></li>
                {event name='contentNavigationButtonsTop'}
                {/content}
            </ul>
        </nav>
    {/hascontent}
</div>

{include file='footer' sandbox=false}
</body>
</html>
