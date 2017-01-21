{capture assign='contentHeader'}
	<header class="contentHeader articleContentHeader">
		<div class="contentHeaderTitle">
			<h1 class="contentTitle" itemprop="name headline">{lang}teamsystem.team.leave.header{/lang}</h1>
		</div>
	</header>
{/capture}

<body id="tpl{$templateName|ucfirst}">

{include file='teamSidebar'  application='teamsystem' assign='sidebar'}

{include file='header' sidebarOrientation='right'}

{include file='formError'}

<p class="warning">{lang}teamsystem.team.leave.warning{/lang}</p>

<form method="post" action="{link application='teamsystem' controller='TeamLeave' teamID=$teamID}{/link}">
	<fieldset>
		<div class="formSubmit">
			<input type="submit" value="{lang}wcf.user.register.disclaimer.accept{/lang}" accesskey="s" />

			<a class="button" href="{link application='teamsystem' controller='InvitationList'}{/link}">{lang}wcf.user.register.disclaimer.decline{/lang}</a>

			{@SECURITY_TOKEN_INPUT_TAG}
		</div>
	</fieldset>
</form>

{include file='footer' sandbox=false}
</body>
