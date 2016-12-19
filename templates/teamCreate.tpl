{include file='documentHeader'}

<head>
	<title>{lang}teamsystem.header.createTeam{/lang} - {PAGE_TITLE|language}</title>
	
	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">

{include file='header' sidebarOrientation='left'}

<header class="boxHeadline">
		<h1>{lang}teamsystem.header.createTeam{/lang}</h1>
</header>

{include file='userNotice'}

{include file='formError'}

<form method="post" action="{link application='teamsystem' controller='TeamCreate'}{/link}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}teamsystem.team.overview.basic{/lang}</legend>
			
			<dl{if $errorField == 'platform'} class="formError"{/if}>
				<dt><label for="platformID">{lang}teamsystem.team.overview.platform{/lang}</label></dt>
				<dd>
					<select id="platformID" name="platformID">
						<option value="">{lang}teamsystem.team.overview.platform.choose{/lang}</option>
						{foreach from=$platformArray item=platform}
							<option value="{$platform->platformID}" {if $platformID == $platform->platformID} selected="selected" {/if}>{$platform->platformName}</option>
						{/foreach}
					</select>
					{if $errorField == 'platform'}
							<small class="innerError">
								{if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
								{if $errorType == 'notUnique'}{lang}teamsystem.team.create.platform.error.notUnique{/lang}{/if}
							</small>
					{/if}
					<small>{lang}teamsystem.team.overview.platform.description{/lang}</small>
				</dd>
			</dl>
			
			<dl{if $errorField == 'teamname'} class="formError"{/if}>
				<dt><label for="teamname">{lang}teamsystem.team.overview.name{/lang}</label></dt>
				<dd>
					<input type="text" id="teamname" name="teamname" value="{$teamname}" class=""/>
					{if $errorField == teamname}
						<small class="innerError">
							{if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
							{if $errorType == 'notValid'}{lang}teamsystem.team.create.name.error.notValid{/lang}{/if}
							{if $errorType == 'notUnique'}{lang}teamsystem.team.create.name.error.notUnique{/lang}{/if}
						</small>
					{/if}
					<small>{lang}teamsystem.team.overview.name.description{/lang}</small>
				</dd>
			</dl>			
		
			
			<dl{if $errorField == 'teamtag'} class="formError"{/if}>
				<dt><label for="teamtag">{lang}teamsystem.team.overview.tag{/lang}</label></dt>
				<dd>
					<input type="text" id="teamtag" name="teamtag" value="{$teamtag}" class=""/>
					{if $errorField == teamtag}
						<small class="innerError">
							{if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
							{if $errorType == 'notValid'}{lang}teamsystem.team.create.tag.error.notValid{/lang}{/if}
							{if $errorType == 'notUnique'}{lang}teamsystem.team.create.tag.error.notUnique{/lang}{/if}
						</small>
					{/if}
					<small>{lang}teamsystem.team.overview.tag.description{/lang}</small>
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
