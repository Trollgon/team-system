{include file='documentHeader'}

<head>
	<title>{if $__wcf->getPageMenu()->getLandingPage()->menuItem != 'tourneysystem.header.menu.tourneys'}{lang}tourneysystem.header.menu.tourneys{/lang} - {/if}{PAGE_TITLE|language}</title>
	
	{include file='headInclude' sandbox=false}
	
	<script data-relocate="true">

		//<![CDATA[

		$(function() {

			new WCF.Search.User('#playername', null, false, [ ], false);

		});

		//]]>

	</script>
</head>

<body id="tpl{$templateName|ucfirst}">

{include file='header' sandbox=false}

<header class="boxHeadline">
		<h1>{lang}tourneysystem.team.invitation{/lang}</h1>
</header>

{include file='userNotice'}

{include file='formError'}

<form method="post" action="{link application='tourneysystem' controller='TeamInvitation' teamID=$teamID platformID=$platformID}{/link}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}tourneysystem.team.invitation.form{/lang}</legend>
			
			<dl{if $errorField == 'positionID'} class="formError"{/if}>
				<dt><label for="positionID">{lang}tourneysystem.team.invitation.position{/lang}</label></dt>
				<dd>
					<select id="positionID" name="positionID">
						<option value="" selected>{lang}tourneysystem.team.invitation.position.choose{/lang}</option>
						<option value="1" {if $positionID==1}selected="selected"{/if}>{lang}tourneysystem.team.invitation.position.player2{/lang}</option>
						<option value="2" {if $positionID==2}selected="selected"{/if}>{lang}tourneysystem.team.invitation.position.player3{/lang}</option>
						<option value="3" {if $positionID==3}selected="selected"{/if}>{lang}tourneysystem.team.invitation.position.player4{/lang}</option>
						<option value="4" {if $positionID==4}selected="selected"{/if}>{lang}tourneysystem.team.invitation.position.sub1{/lang}</option>
						<option value="5" {if $positionID==5}selected="selected"{/if}>{lang}tourneysystem.team.invitation.position.sub2{/lang}</option>
						<option value="6" {if $positionID==6}selected="selected"{/if}>{lang}tourneysystem.team.invitation.position.sub3{/lang}</option>
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

{include file='footer' sandbox=false}
</body>
</html>