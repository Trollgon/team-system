{capture assign='contentHeader'}
	<header class="contentHeader articleContentHeader">
		<div class="contentHeaderTitle">
			<h1 class="contentTitle" itemprop="name headline">{lang}tourneysystem.team.delete.header{/lang}</h1>
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
								<li class="boxFlag"><a href="{link application='tourneysystem' controller='TeamEdit' teamID=$teamID}{/link}"
													   title="{lang}tourneysystem.team.page.edit{/lang}" class="box24">
										<span>{lang}tourneysystem.team.page.edit{/lang}</span></a>
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

<p class="warning">{lang}tourneysystem.team.delete.warning{/lang}</p>

<form method="post" action="{link application='tourneysystem' controller='TeamDelete' teamID=$teamID}{/link}">
	<fieldset>
		<div class="formSubmit">
			<input type="submit" value="{lang}wcf.user.register.disclaimer.accept{/lang}" accesskey="s" />

			<a class="button" href="{link application='tourneysystem' controller='Team' id=$teamID}{/link}">{lang}wcf.user.register.disclaimer.decline{/lang}</a>
			{@SECURITY_TOKEN_INPUT_TAG}
		</div>
	</fieldset>
</form>

{include file='footer' sandbox=false}
</body>
