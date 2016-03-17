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

{include file='formError'}

{if $success|isset}
	<p class="success">{lang}wcf.global.success.{$action}{/lang}</p>
{/if}


<form method="post" action="{link application='tourneysystem' controller='TeamAdd'}{/link}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}tourneysystem.team.overview.basic{/lang}</legend>
			
			<dl>
				<dt><label for="teamName">{lang}tourneysystem.team.overview.name{/lang}</label></dt>
				<dd>
					<input type="text" id="teamName" name="teamName" class="" required="required" />
				</dd>
			</dl>			
		
			
			<dl>
				<dt><label for="teamTag">{lang}tourneysystem.team.overview.tag{/lang}</label></dt>
				<dd>
					<input type="text" id="teamTag" name="teamTag" class="" required="required" />
				</dd>
			</dl>			
					
		</fieldset>
		
	</div>
	
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SECURITY_TOKEN_INPUT_TAG}
	</div>
</form>

{include file='footer' sandbox=false}
</body>
</html>
