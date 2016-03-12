{include file='documentHeader'}

<head>
	<title>{if $__wcf->getPageMenu()->getLandingPage()->menuItem != 'tourneysystem.header.menu.index'}{lang}tourneysystem.header.menu.index{/lang} - {/if}{PAGE_TITLE|language}</title>
	
	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">
{include file='header' sandbox=false}

<header class="boxHeadline">
		<h1>{lang}tourneysystem.header.addTeam{/lang}</h1>
</header>

{include file='userNotice'}


{include file='footer' sandbox=false}
</body>
</html>
