{include file='documentHeader'}

<head>
	<title>{if $team->getTeamID() == 0}{lang}teamsystem.header.menu.teams{/lang} - {else} {lang}teamsystem.team.invitation.form.title{/lang} - {/if}{PAGE_TITLE|language}</title>
	
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

{include file='teamSidebar'  application='teamsystem' assign='sidebar'}

{include file='header' sidebarOrientation='left'}

<header class="boxHeadline">
		<h1>{lang}teamsystem.team.invitation.form.title{/lang}</h1>
</header>

{include file='userNotice'}

{include file='formError'}

<div class="contentNavigation">
    {hascontent}
        <nav>
            <ul>
                {content}
                {if $team->isTeamLeader()}
                	<li><a href="{link application='teamsystem' controller='TeamEdit' teamID=$teamID}{/link}"
                           title="{lang}teamsystem.team.page.edit{/lang}" class="button"><span
                                class="icon icon16 icon-pencil"></span>
                        <span>{lang}teamsystem.team.page.edit{/lang}</span></a></li>
				{/if}
				{/content}
            </ul>
        </nav>
    {/hascontent}
</div>

<form method="post" action="{link application='teamsystem' controller='TeamInvitation' teamID=$teamID}{/link}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}teamsystem.team.invitation.form{/lang}</legend>
			
			<dl{if $errorField == 'positionID'} class="formError"{/if}>
				<dt><label for="positionID">{lang}teamsystem.team.invitation.position{/lang}</label></dt>
				<dd>
					<select id="positionID" name="positionID">
						<option value="" selected>{lang}teamsystem.team.invitation.position.choose{/lang}</option>
						<option value="1" {if $positionID==1}selected="selected"{/if}>{lang}teamsystem.team.invitation.position.player{/lang}</option>
						<option value="2" {if $positionID==2}selected="selected"{/if}>{lang}teamsystem.team.invitation.position.sub{/lang}</option>
					</select>
					{if $errorField == 'positionID'}
							<small class="innerError">
								{if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
								{if $errorType == 'notUnique'}{lang}teamsystem.team.invitation.position.error.notUnique{/lang}{/if}
							</small>
					{/if}
					<small>{lang}teamsystem.team.invitation.position.description{/lang}</small>
				</dd>
			</dl>
				
			<dl{if $errorField == 'playername'} class="formError"{/if}>
				<dt><label for="playername">{lang}teamsystem.team.invitation.playername{/lang}</label></dt>
				<dd>
					<input type="text" id="playername" name="playername" value="{$playername}" class="medium" />
					{if $errorField == playername}
						<small class="innerError">
							{if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
							{if $errorType == 'notValid'}{lang}teamsystem.team.invitation.playername.error.notValid{/lang}{/if}
							{if $errorType == 'notUnique'}{lang}teamsystem.team.invitation.playername.error.notUnique{/lang}{/if}
						</small>
					{/if}
					<small>{lang}teamsystem.team.invitation.playername.description{/lang}</small>
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
