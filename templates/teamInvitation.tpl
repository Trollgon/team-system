{capture assign='pageTitle'}[{$team->getTeamTag()}] - {$team->getTeamName()}{/capture}

{capture assign='contentHeader'}
	<header class="contentHeader articleContentHeader">
		<div class="contentHeaderTitle">
			<h1 class="contentTitle" itemprop="name headline">{lang}tourneysystem.team.invitation.form.title{/lang}</h1>
		</div>

		{hascontent}
			<nav>
				<ul>
					{content}
					{if $team->isTeamLeader()}
						<li><a href="{link application='tourneysystem' controller='TeamEdit' teamID=$teamID}{/link}"
							   title="{lang}tourneysystem.team.page.edit{/lang}" class="button"><span
										class="icon icon16 fa-pencil"></span>
								<span>{lang}tourneysystem.team.page.edit{/lang}</span></a></li>
					{/if}
					{event name='contentHeaderNavigation'}
					{/content}
				</ul>
			</nav>
		{/hascontent}
	</header>
{/capture}

<body id="tpl{$templateName|ucfirst}">

{include file='teamSidebar'  application='tourneysystem' assign='sidebar'}

{include file='header' sidebarOrientation='right'}

{include file='formError'}

<form method="post" action="{link application='tourneysystem' controller='TeamInvitation' teamID=$teamID}{/link}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}tourneysystem.team.invitation.form{/lang}</legend>
			
			<dl{if $errorField == 'positionID'} class="formError"{/if}>
				<dt><label for="positionID">{lang}tourneysystem.team.invitation.position{/lang}</label></dt>
				<dd>
					<select id="positionID" name="positionID">
						<option value="" selected>{lang}tourneysystem.team.invitation.position.choose{/lang}</option>
						<option value="1" {if $positionID==1}selected="selected"{/if}>{lang}tourneysystem.team.invitation.position.player{/lang}</option>
						<option value="2" {if $positionID==2}selected="selected"{/if}>{lang}tourneysystem.team.invitation.position.sub{/lang}</option>
					</select>
					{if $errorField == 'positionID'}
							<small class="innerError">
								{if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
								{if $errorType == 'notUnique'}{lang}tourneysystem.team.invitation.position.error.notUnique{/lang}{/if}
							</small>
					{/if}
					<small>{lang}tourneysystem.team.invitation.position.description{/lang}</small>
				</dd>
			</dl>
				
			<dl{if $errorField == 'playername'} class="formError"{/if}>
				<dt><label for="playername">{lang}tourneysystem.team.invitation.playername{/lang}</label></dt>
				<dd>
					<input type="text" id="playername" name="playername" value="{$playername}" class="medium" />
					{if $errorField == playername}
						<small class="innerError">
							{if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
							{if $errorType == 'notValid'}{lang}tourneysystem.team.invitation.playername.error.notValid{/lang}{/if}
							{if $errorType == 'notUnique'}{lang}tourneysystem.team.invitation.playername.error.notUnique{/lang}{/if}
						</small>
					{/if}
					<small>{lang}tourneysystem.team.invitation.playername.description{/lang}</small>
				</dd>
			</dl>	
				
					
		</fieldset>
		
	</div>
	
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SECURITY_TOKEN_INPUT_TAG}
	</div>
</form>

<script data-relocate="true">
	$(function() {
		new WCF.Search.User($('#playername'), function(data) {
			$('#playername').val(data.label);//.focus();
		});
	});
</script>

{include file='footer' sandbox=false}
</body>
</html>
