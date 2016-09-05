{include file='documentHeader'}

<head>
	<title>{lang}teamsystem.header.menu.teams{/lang} - {PAGE_TITLE|language}</title>
	
	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">

{include file='teamSidebar'  application='teamsystem' assign='sidebar'}

{include file='header' sidebarOrientation='left'}

<header class="boxHeadline">
	<h1>{lang}teamsystem.team.invitation.title{/lang}</h1>
</header>

{include file='userNotice'}

{include file='formError'}

<form method="post" action="{link application='teamsystem' controller='Invitation' id=$invitationID}{/link}">

	<div class="formSubmit">

		<input type="submit" value="{lang}wcf.user.register.disclaimer.accept{/lang}" accesskey="s" />

		<a class="button" href="{link application='teamsystem' controller='InvitationList'}{/link}">{lang}wcf.user.register.disclaimer.decline{/lang}</a>

		{@SECURITY_TOKEN_INPUT_TAG}

	</div>

</form>

{include file='footer' sandbox=false}
</body>
</html>
