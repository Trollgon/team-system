<li data-object-id="{@$team->teamID}">
	<div class="box48">
		<a href="{link application='teamsystem' controller='Team' object=$team}{/link}" >{@$team->getAvatar()->getImageTag(48)}</a>
		
		<div class="details userInformation">
			<div class="containerHeadline">
				<h3><a href="{link application='teamsystem' controller='Team' object=$team}{/link}">[{$team->getTeamTag()}] - {$team->getTeamName()}</a></h3>
			</div>
			
			<ul class="dataList userFacts">

				<li>{lang}teamsystem.team.page.contact{/lang}: <a href="{link controller='User' object=$team->getContactProfile()}{/link}" class="userLink" data-user-id="{$team->leaderID}">{$team->getLeaderName()}</a></li>

				{event name='userData'}
			</ul>
		</div>
		
			<dl class="inlineDataList userStats">

				{event name='statistics'}	

					<dd>{if $team->dummyTeam == 0}{lang}teamsystem.team.teamList.platform{/lang}{else}DUMMYTEAM{/if}</dd>


			</dl>
	</div>
</li>