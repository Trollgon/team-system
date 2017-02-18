<body id="tpl{$templateName|ucfirst}">

{include file='header' sandbox='false'}

{include file='formError'}

<form method="post" action="{link application='tourneysystem' controller='TeamCreate'}{/link}">
		<fieldset>
			<legend>{lang}tourneysystem.team.overview.basic{/lang}</legend>
			
			<dl{if $errorField == 'platform'} class="formError"{/if}>
				<dt><label for="platformID">{lang}tourneysystem.team.overview.platform{/lang}</label></dt>
				<dd>
					<select id="platformID" name="platformID">
						<option value="">{lang}tourneysystem.team.overview.platform.choose{/lang}</option>
						{foreach from=$platformArray item=platform}
							<option value="{$platform->platformID}" {if $platformID == $platform->platformID} selected="selected" {/if}>{$platform->platformName}</option>
						{/foreach}
					</select>
					{if $errorField == 'platform'}
							<small class="innerError">
								{if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
								{if $errorType == 'notUnique'}{lang}tourneysystem.team.create.platform.error.notUnique{/lang}{/if}
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
							{if $errorType == 'notValid'}{lang}tourneysystem.team.create.name.error.notValid{/lang}{/if}
							{if $errorType == 'notUnique'}{lang}tourneysystem.team.create.name.error.notUnique{/lang}{/if}
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
							{if $errorType == 'notValid'}{lang}tourneysystem.team.create.tag.error.notValid{/lang}{/if}
							{if $errorType == 'notUnique'}{lang}tourneysystem.team.create.tag.error.notUnique{/lang}{/if}
						</small>
					{/if}
					<small>{lang}tourneysystem.team.overview.tag.description{/lang}</small>
				</dd>
			</dl>			
					
		</fieldset>
	
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SECURITY_TOKEN_INPUT_TAG}
	</div>
</form>

{include file='footer' sandbox=false}
</body>
</html>
