{include file='documentHeader'}

<head>
	<title>{if $__wcf->getPageMenu()->getLandingPage()->menuItem != 'tourneysystem.header.menu.teams'}{lang}tourneysystem.header.menu.teams{/lang} - {/if}{PAGE_TITLE|language}</title>
	
	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">

{include file='header' sandbox=false}

<header class="boxHeadline">
		<h1>{lang}tourneysystem.header.addTeam{/lang}</h1>
</header>

{include file='userNotice'}

{include file='formError'}

<div class="contentNavigation">
    {hascontent}
        <nav>
            <ul>
                {content}
					<li><a href="{link application='tourneysystem' controller='TeamDelete' teamID=$teamID platformID=$platformID}{/link}"
                           title="{lang}tourneysystem.team.invitation.delete{/lang}" class="button"><span
                                class="icon icon16 icon-remove"></span>
                        <span>{lang}tourneysystem.team.delete{/lang}</span></a></li>
                {/content}
            </ul>
        </nav>
    {/hascontent}
</div>


{include file='footer' sandbox=false}
</body>
</html>
