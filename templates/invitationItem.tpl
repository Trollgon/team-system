<li data-object-id="{@$invitation->invitationID}">
	<div class="box48">
		<a href="{link application='tourneysystem' controller='Invitation' object=$invitation}{/link}" >{@$invitation->getTeamName()}</a>
		
		<div class="details userInformation">
			{if $invitation->getPositionID() < 5}
				{lang}tourneysystem.team.position.player{/lang}
			{else}
				{lang}tourneysystem.team.position.sub{/lang}
			{/if}
		</div>
	</div>
</li>