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

<form method="post" action="{link application='tourneysystem' controller='TeamCreate'}{/link}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}tourneysystem.team.overview.basic{/lang}</legend>
			
			<dl{if $errorField == 'platform'} class="formError"{/if}>
				<dt><label for="platform">{lang}tourneysystem.team.overview.platform{/lang}</label></dt>
				<dd>
					<select id="platform" name="platform">
						<option value="" selected>{lang}tourneysystem.team.overview.platform.choose{/lang}</option>
						<option value="1" {if $platform==1}selected="selected"{/if}>{lang}tourneysystem.team.overview.platform.pc{/lang}</option>
						<option value="2" {if $platform==2}selected="selected"{/if}>{lang}tourneysystem.team.overview.platform.ps4{/lang}</option>
						<option value="3" {if $platform==3}selected="selected"{/if}>{lang}tourneysystem.team.overview.platform.ps3{/lang}</option>
						<option value="4" {if $platform==4}selected="selected"{/if}>{lang}tourneysystem.team.overview.platform.xbox1{/lang}</option>
						<option value="5" {if $platform==5}selected="selected"{/if}>{lang}tourneysystem.team.overview.platform.xbox360{/lang}</option>
					</select>
					{if $errorField == 'platform'}
							<small class="innerError">
								{if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
								{if $errorType == 'notUnique'}{lang}tourneysystem.team.add.platform.error.notUnique{/lang}{/if}
							</small>
					{/if}
					<small>{lang}tourneysystem.team.overview.platform.description{/lang}</small>
				</dd>
			</dl>
			
			<dl{if $errorField == 'teamname'} class="formError"{/if}>
				<dt><label for="teamname">{lang}tourneysystem.team.overview.name{/lang}</label></dt>
				<dd>
					<input type="text" id="teamname" name="teamname" value="{$teamname}" class=""/>
					{if $errorField == teamname}
						<small class="innerError">
							{if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
							{if $errorType == 'notValid'}{lang}tourneysystem.team.add.name.error.notValid{/lang}{/if}
							{if $errorType == 'notUnique'}{lang}tourneysystem.team.add.name.error.notUnique{/lang}{/if}
						</small>
					{/if}
					<small>{lang}tourneysystem.team.overview.name.description{/lang}</small>
				</dd>
			</dl>			
		
			
			<dl{if $errorField == 'teamtag'} class="formError"{/if}>
				<dt><label for="teamtag">{lang}tourneysystem.team.overview.tag{/lang}</label></dt>
				<dd>
					<input type="text" id="teamtag" name="teamtag" value="{$teamtag}" class=""/>
					{if $errorField == teamtag}
						<small class="innerError">
							{if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
							{if $errorType == 'notValid'}{lang}tourneysystem.team.add.tag.error.notValid{/lang}{/if}
							{if $errorType == 'notUnique'}{lang}tourneysystem.team.add.tag.error.notUnique{/lang}{/if}
						</small>
					{/if}
					<small>{lang}tourneysystem.team.overview.tag.description{/lang}</small>
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
