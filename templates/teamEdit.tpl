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
					<li><a class="interactiveDropdownShowAll" href="{link application='tourneysystem' controller='TeamDelete'}t={@SECURITY_TOKEN}{/link}" 
						onclick="WCF.System.Confirmation.show('{lang}tourneysystem.team.delete.sure{/lang}'">{lang}tourneysystem.team.delete{/lang}
						<span class="icon icon16 icon-remove"></span>
						<span>{lang}tourneysystem.team.delete{/lang}</span>
					</a></li>
                {/content}
            </ul>
        </nav>
    {/hascontent}
</div>

<form method="post" action="{link application='tourneysystem' controller='TeamEdit'}{/link}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}tourneysystem.team.overview.basic{/lang}</legend>
			
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
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}tourneysystem.team.edit.invite.players{/lang}</legend>
				<dl{if $errorType.leader|isset} class="formError"{/if}>
			<dt><label for="leader">{lang}wcf.acp.group.leader{/lang}</label></dt>
			<dd>
				<input type="text" id="leader" name="leader" value="{$leader}" class="long" />
				{if $errorType.leader|isset}
					<small class="innerError">
						{lang}wcf.acp.group.leader.error.{@$errorType.leader}{/lang}
					</small>
				{/if}
				<small>{lang}wcf.acp.group.leader.description{/lang}</small>
			</dd>
		</dl>
		
		{event name='fields'}
		
		<script data-relocate="true">
		//<![CDATA[
			$(function() {
				new WCF.Search.User('#leader', undefined, false, [ ], true);
			});
		//]]>
		</script>
			
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
