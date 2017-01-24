{capture assign='pageTitle'}[{$team->getTeamTag()}] - {$team->getTeamName()}{/capture}

{capture assign='contentHeader'}
	<header class="contentHeader userProfileUser">
		<div class="contentHeaderIcon">
			{if $user->userID == $__wcf->user->userID}
				<a href="{link application='teamsystem' controller='TeamAvatarEdit' teamID=$teamID}{/link}" class="jsTooltip" title="{lang}wcf.user.avatar.edit{/lang}">{@$team->getAvatar()->getImageTag(128)}</a>
			{else}
				<span>{@$team->getAvatar()->getImageTag(128)}</span>
			{/if}
		</div>
		<div class="contentHeaderTitle">
			<h1 class="contentTitle" itemprop="name headline">
				[{$team->getTeamTag()}] - {$team->getTeamName()}
			</h1>
			<div class="contentHeaderDescription">
				<ul class="inlineList commaSeparated">
					<li>{lang}teamsystem.team.page.registrationDate{/lang}</li>
					{event name='userDataRow1'}
				</ul>

				<ul class="inlineList commaSeparated">
					<li>{lang}teamsystem.team.teamList.platform{/lang}</li>
				</ul>
			</div>
		</div>
			<nav class="contentHeaderNavigation">
				<ul class="userProfileButtonContainer">
					{if $team->isTeamLeader()}
						{if $team->dummyTeam == 0}
							{if TEAMSYSTEM_LOCK_TEAMEDIT == false}
								{hascontent}
								<li class="dropdown">
									<a class="button dropdownToggle" title="{lang}teamsystem.team.page.edit{/lang}">
										<span class="icon icon32 fa-pencil"></span>
									</a>
									<ul class="dropdownMenu userProfileButtonMenu">
										{content}
										{event name='menuCustomization'}
											<li class="boxFlag"><a href="{link application='teamsystem' controller='TeamAvatarEdit' teamID=$teamID}{/link}"
																   title="{lang}teamsystem.team.avatar.edit{/lang}" class="box24">
													<span>{lang}teamsystem.team.avatar.edit{/lang}</span></a>
											</li>
											<li class="boxFlag"><a href="{link application='teamsystem' controller='TeamEdit' teamID=$teamID}{/link}"
																   title="{lang}teamsystem.team.page.edit{/lang}" class="box24">
													<span>{lang}teamsystem.team.page.edit{/lang}</span></a>
											</li>
											{if $teamIsFull != true}
												<li class="boxFlag"><a href="{link application='teamsystem' controller='TeamInvitation' teamID=$teamID}{/link}"
																	   title="{lang}teamsystem.team.page.invitation{/lang}" class="box24">
														<span>{lang}teamsystem.team.page.invitation{/lang}</span></a>
												</li>
											{/if}
											<li class="boxFlag"><a href="{link application='teamsystem' controller='TeamKickList' teamID=$teamID}{/link}"
																   title="{lang}teamsystem.team.page.kick{/lang}" class="box24">
													<span>{lang}teamsystem.team.page.kick{/lang}</span></a>
											</li>
											<li class="boxFlag"><a href="{link application='teamsystem' controller='TeamDelete' teamID=$teamID}{/link}"
																   title="{lang}teamsystem.team.page.delete{/lang}" class="box24">
													<span>{lang}teamsystem.team.page.delete{/lang}</span></a>
											</li>
										{/content}
									</ul>
								</li>
								{/hascontent}
							{/if}
						{/if}
					{/if}
					{if (!$team->isTeamMember() && !$team->isTeamLeader()) || ($__wcf->getUser()->userID == 1 && $team->dummyTeam == 1)}
						{if $__wcf->getSession()->getPermission('mod.teamSystem.canEditTeams')}
							{hascontent}
								<li class="dropdown">
									<a class="button dropdownToggle" title="{lang}teamsystem.team.page.edit{/lang}">
										<span class="icon icon32 fa-pencil"></span>
									</a>
									<ul class="dropdownMenu userProfileButtonMenu">
										{content}
										{event name='menuCustomization'}
											<li class="boxFlag"><a href="{link application='teamsystem' controller='TeamEdit' teamID=$teamID}{/link}"
																   title="{lang}teamsystem.team.page.edit.mod{/lang}" class="box24">
													<span>{lang}teamsystem.team.page.edit.mod{/lang}</span></a>
											</li>
										{if $teamIsFull != true}
											<li class="boxFlag"><a href="{link application='teamsystem' controller='TeamInvitation' teamID=$teamID}{/link}"
																   title="{lang}teamsystem.team.page.invitation.mod{/lang}" class="box24">
													<span>{lang}teamsystem.team.page.invitation.mod{/lang}</span></a>
											</li>
										{/if}
											<li class="boxFlag"><a href="{link application='teamsystem' controller='TeamKickList' teamID=$teamID}{/link}"
																   title="{lang}teamsystem.team.page.kick.mod{/lang}" class="box24">
													<span>{lang}teamsystem.team.page.kick.mod{/lang}</span></a>
											</li>
											<li class="boxFlag"><a href="{link application='teamsystem' controller='TeamDelete' teamID=$teamID}{/link}"
																   title="{lang}teamsystem.team.page.delete.mod{/lang}" class="box24">
													<span>{lang}teamsystem.team.page.delete.mod{/lang}</span></a>
											</li>
										{/content}
									</ul>
								</li>
							{/hascontent}
						{/if}
					{/if}
					{if $team->dummyTeam == 0}
						{if $team->isTeamMember() && $__wcf->getUser()->getUserID() != 0}
							{if TEAMSYSTEM_LOCK_TEAMEDIT == false}
								<a href="{link application='teamsystem' controller='TeamLeave' teamID=$teamID}{/link}"
									   title="{lang}teamsystem.team.page.leave{/lang}" class="button">
									<span class="icon icon32 fa-sign-out"></span>
								</a>
							{/if}
						{/if}
					{/if}
					{event name='contentHeaderNavigation'}
				</ul>
			</nav>
	</header>
{/capture}

<body id="tpl{$templateName|ucfirst}">

{include file='teamSidebar'  application='teamsystem' assign='sidebar'}

{include file='header' sidebarOrientation='right'}

{if $team->dummyTeam == 0}
	{if $team->isTeamMember()}
		{if $playerMissingContactInfo == true}
			<p class="warning">{lang}teamsystem.team.page.missingContactinfo.player{/lang}</p>
		{/if}
	{/if}

	{if $team->isTeamLeader()}
		{if $memberMissing == true}
			<p class="warning">{lang}teamsystem.team.page.notEnoughMembers{/lang}</p>
		{else}
			{if $subMissing == true}
				<p class="info">{lang}teamsystem.team.page.noSubs{/lang}</p>
			{/if}
		{/if}
		{if $missingContactInfo == true}
			<p class="warning">{lang}teamsystem.team.page.missingContactinfo{/lang}</p>
		{/if}
		{if $playerMissingContactInfo == true}
			<p class="warning">{lang}teamsystem.team.page.missingContactinfo.player{/lang}</p>
		{/if}
	{/if}
{else}
	<p class="warning">{lang}teamsystem.team.page.dummy{/lang}</p>
{/if}

{if $team->dummyTeam == 0}
	<header class="boxHeadline boxSubHeadline">

		<h2>{lang}teamsystem.team.page.members{/lang}{if $playerObjects|count > 1}s{/if} <span class="badge">{#$playerObjects->count()}</span></h2>

	</header>

	<div class="container marginTop">
			<ul class="containerList userList">
				<ol class="containerList userList">
					{foreach from=$playerObjects item=user}
						{include file='playerItem' application='teamsystem'}
					{/foreach}
				</ol>
			</ul>
	</div>
	{if $subObjects|count > 0}
		<header class="boxHeadline boxSubHeadline">

			<h2>{lang}teamsystem.team.page.subs{/lang}{if $subObjects|count > 1}s{/if} <span class="badge">{#$subObjects->count()}</span></h2>

		</header>

		<div class="container marginTop">
			<ul class="containerList userList">
				<ol class="containerList userList">
					{foreach from=$subObjects item=user}
						{include file='playerItem' application='teamsystem'}
					{/foreach}
				</ol>
			</ul>
		</div>
	{/if}
{/if}


{include file='footer' sandbox=false}
</body>
</html>
