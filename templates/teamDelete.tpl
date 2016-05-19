{include file='documentHeader'}

<head>
	<title>{if $__wcf->getPageMenu()->getLandingPage()->menuItem != 'tourneysystem.header.menu.teams'}{lang}tourneysystem.header.menu.teams{/lang} - {/if}{PAGE_TITLE|language}</title>
	
	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">
{include file='header' sandbox=false}

<header class="boxHeadline">
	<h1>You are about to delete [{$team->getTeamTag()}] - {$team->getTeamName()}</h1>
</header>

{include file='userNotice'}

{include file='formError'}

<p class="warning">{lang}tournamentsystem.team.delete.warning{/lang}</p>

<form method="post" action="{link application='tourneysystem' controller='TeamDelete' teamID=$teamID platformID=$platformID}{/link}">

	<div class="formSubmit">

		<input type="submit" value="{lang}wcf.user.register.disclaimer.accept{/lang}" accesskey="s" />

		<a class="button" href="{link application='tourneysystem' controller='InvitationList'}{/link}">{lang}wcf.user.register.disclaimer.decline{/lang}</a>

		{@SECURITY_TOKEN_INPUT_TAG}

	</div>

</form>

{include file='footer' sandbox=false}
</body>
</html>
