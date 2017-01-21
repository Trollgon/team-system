{capture assign='contentHeader'}
	<header class="contentHeader articleContentHeader">
		<div class="contentHeaderTitle">
			<h1 class="contentTitle" itemprop="name headline">{lang}teamsystem.header.editTeam{/lang}</h1>
		</div>
	</header>
{/capture}

<body id="tpl{$templateName|ucfirst}">

{include file='teamSidebar'  application='teamsystem' assign='sidebar'}

{include file='header' sidebarOrientation='right'}

{include file='formError'}

<form method="post" action="{link application='teamsystem' controller='TeamEdit' teamID=$teamID}{/link}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}teamsystem.team.edit.general{/lang}</legend>
			
			<dl>
				<dt><label for="contactForm">{lang}teamsystem.team.page.contact{/lang}</label></dt>
				<dd>
					<select id="contact" name="contact">
						<option value="0" {if $contactForm==0}selected="selected"{/if}>{@$team->getLeaderName()}</option>
						{if ($team->player2ID != NULL)}<option value="1" {if $contactForm==1}selected="selected"{/if}>{@$team->getPlayer2Name()}</option>{/if}
						{if ($team->player3ID != NULL)}<option value="2" {if $contactForm==2}selected="selected"{/if}>{@$team->getPlayer3Name()}</option>{/if}
						{if ($team->player4ID != NULL)}<option value="3" {if $contactForm==3}selected="selected"{/if}>{@$team->getPlayer4Name()}</option>{/if}
						{if ($team->sub1ID != NULL)}<option value="4" {if $contactForm==4}selected="selected"{/if}>{@$team->getSub1Name()}</option>{/if}
						{if ($team->sub2ID != NULL)}<option value="5" {if $contactForm==5}selected="selected"{/if}>{@$team->getSub2Name()}</option>{/if}
						{if ($team->sub3ID != NULL)}<option value="6" {if $contactForm==6}selected="selected"{/if}>{@$team->getSub3Name()}</option>{/if}
					</select>
					<small>{lang}teamsystem.team.edit.contact.description{/lang}</small>
				</dd>
			</dl>
			
			<dl{if $errorField == 'description'} class="formError"{/if}>
				<dt><label for="description">{lang}teamsystem.team.page.description{/lang}</label></dt>
				<dd>
					<textarea id="description" name="description" rows="10" cols="40" maxlength="400">{@$team->teamDescription}</textarea>
					{if $errorField == 'description'}
							<small class="innerError">
								{lang}teamsystem.team.page.description.error.length{/lang}
							</small>
					{/if}
					<small>{lang}teamsystem.team.edit.description.description{/lang}</small>
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