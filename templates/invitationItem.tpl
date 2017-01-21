<li data-object-id="{@$invitation->invitationID}">
	<div class="box48">
		<a href="{link application='teamsystem' controller='Invitation' object=$invitation}{/link}" >{@$invitation->getAvatar()->getImageTag(48)}</a>
		
		<div class="details userInformation">
			<div class="containerHeadline">
				<h3><a href="{link application='teamsystem' controller='Invitation' object=$invitation}{/link}">[{$invitation->getTeamTag()}] - {$invitation->getTeamName()}</a></h3>
			</div>

			<ul class="inlineList commaSeparated">
				<li>{lang}teamsystem.team.invitationList.platform{/lang}</li>
				<li>
					{lang}teamsystem.team.invitation.position{/lang}:
					{if $invitation->getPositionID() == 1}
						{lang}teamsystem.team.position.player{/lang}
					{else}
						{lang}teamsystem.team.position.sub{/lang}
					{/if}
				</li>
				{event name='userData'}
			</ul>

	</div>
</li>