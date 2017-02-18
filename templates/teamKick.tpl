{capture assign='contentHeader'}
	<header class="contentHeader articleContentHeader">
		<div class="contentHeaderTitle">
			<h1 class="contentTitle" itemprop="name headline">{lang}tourneysystem.team.kick.header{/lang}</h1>
		</div>
	</header>
{/capture}

<body id="tpl{$templateName|ucfirst}">

{include file='teamSidebar'  application='tourneysystem' assign='sidebar'}

{include file='header' sidebarOrientation='right'}

{include file='formError'}

<p class="warning">{lang}tourneysystem.team.kick.warning{/lang}</p>

<form method="post" action="{link application='tourneysystem' controller='TeamKick' teamID=$teamID positionID=$positionID}{/link}">

	<div class="formSubmit">
		<fieldset>
			<input type="submit" value="{lang}wcf.user.register.disclaimer.accept{/lang}" accesskey="s" />

			<a class="button" href="{link application='tourneysystem' controller='Team' id=$teamID}{/link}">{lang}wcf.user.register.disclaimer.decline{/lang}</a>

			{@SECURITY_TOKEN_INPUT_TAG}
		</fieldset>

	</div>

</form>

{include file='footer' sandbox=false}
</body>
