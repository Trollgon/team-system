<li data-object-id="{@$invitation->invitationID}">
	<div class="box48">
		<a href="{link application='tourneysystem' controller='Invitation' object=$invitation}{/link}" >{@$invitation->getAvatar()->getImageTag(48)}</a>
		
		<div class="details userInformation">
			<div class="containerHeadline">
				<h3><a href="{link application='tourneysystem' controller='Invitation' object=$invitation}{/link}">[{$invitation->getTeamTag()}] - {$invitation->getTeamName()}</a></h3>
			</div>

			<ul class="inlineList commaSeparated">
				<li>{lang}tourneysystem.team.invitationList.platform{/lang}</li>
				<li>
					{lang}tourneysystem.team.invitation.position{/lang}:
					{if $invitation->getPositionID() == 1}
						{lang}tourneysystem.team.position.player{/lang}
					{else}
						{lang}tourneysystem.team.position.sub{/lang}
					{/if}
				</li>
				{event name='userData'}
			</ul>

	</div>
</li>