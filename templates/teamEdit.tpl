{capture assign='contentHeader'}
	<header class="contentHeader articleContentHeader">
		<div class="contentHeaderTitle">
			<h1 class="contentTitle" itemprop="name headline">{lang}tourneysystem.header.editTeam{/lang}</h1>
		</div>

		<nav class="contentHeaderNavigation">
			<ul class="userProfileButtonContainer">
				{hascontent}
					<li class="dropdown">
						<a class="button dropdownToggle" title="{lang}tourneysystem.team.page.edit{/lang}">
							<span class="icon icon32 fa-pencil"></span>
						</a>
						<ul class="dropdownMenu userProfileButtonMenu">
							{content}
							{event name='menuCustomization'}
								<li class="boxFlag"><a href="{link application='tourneysystem' controller='TeamAvatarEdit' teamID=$teamID}{/link}"
													   title="{lang}tourneysystem.team.avatar.edit{/lang}" class="box24">
										<span>{lang}tourneysystem.team.avatar.edit{/lang}</span></a>
								</li>
							{if $teamIsFull != true}
								<li class="boxFlag"><a href="{link application='tourneysystem' controller='TeamInvitation' teamID=$teamID}{/link}"
													   title="{lang}tourneysystem.team.page.invitation{/lang}" class="box24">
										<span>{lang}tourneysystem.team.page.invitation{/lang}</span></a>
								</li>
							{/if}
							{if $teamIsEmpty != true}
								<li class="boxFlag"><a href="{link application='tourneysystem' controller='TeamKickList' teamID=$teamID}{/link}"
													   title="{lang}tourneysystem.team.page.kick{/lang}" class="box24">
										<span>{lang}tourneysystem.team.page.kick{/lang}</span></a>
								</li>
							{/if}
								<li class="boxFlag"><a href="{link application='tourneysystem' controller='TeamDelete' teamID=$teamID}{/link}"
													   title="{lang}tourneysystem.team.page.delete{/lang}" class="box24">
										<span>{lang}tourneysystem.team.page.delete{/lang}</span></a>
								</li>
							{/content}
						</ul>
					</li>
				{/hascontent}
			</ul>
		</nav>
	</header>
{/capture}

<body id="tpl{$templateName|ucfirst}">

{include file='teamSidebar'  application='tourneysystem' assign='sidebar'}

{include file='header' sidebarOrientation='right'}

{include file='formError'}

<form method="post" action="{link application='tourneysystem' controller='TeamEdit' teamID=$teamID}{/link}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}tourneysystem.team.edit.general{/lang}</legend>
			
			<dl>
				<dt><label for="contactForm">{lang}tourneysystem.team.page.contact{/lang}</label></dt>
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
					<small>{lang}tourneysystem.team.edit.contact.description{/lang}</small>
				</dd>
			</dl>
			
			<dl{if $errorField == 'description'} class="formError"{/if}>
				<dt><label for="description">{lang}tourneysystem.team.page.description{/lang}</label></dt>
				<dd>
					<textarea id="description" name="description" rows="10" cols="40" maxlength="400">{@$team->teamDescription}</textarea>
					{if $errorField == 'description'}
							<small class="innerError">
								{lang}tourneysystem.team.page.description.error.length{/lang}
							</small>
					{/if}
					<small>{lang}tourneysystem.team.edit.description.description{/lang}</small>
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