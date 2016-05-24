<fieldset>

	<legend class="invisible">{lang}teamsystem.team.avatar{/lang}</legend>

	

	<div class="userAvatar">

		{if $team->isTeamLeader()}

			<a href="{link application='teamsystem' controller='TeamAvatarEdit'}{/link}" class="framed jsTooltip" title="{lang}teamsystem.team.avatar.edit{/lang}">{@$team->getAvatar()->getImageTag()}</a>

		{else}

			<span class="framed">{@$team->getAvatar()->getImageTag()}</span>

		{/if}

	</div>

</fieldset>
<div>
    <fieldset>
        <legend>{lang}teamsystem.team.page.contact{/lang}</legend>
        </br>
        <div class="box96 framed">
            <a href="{link controller='User' object=$contact}{/link}"
                           data-user-id="{@$contact->userID}">{@$contact->getAvatar()->getImageTag(96)}</a>
            <div>
                <div class="containerHeadline">
                    <h3><a href="{link controller='User' object=$contact}{/link}" class="userLink"
                           data-user-id="{@$contact->userID}">{@$contact->getFormattedUsername()}</a></h3>
                    {if MODULE_USER_RANK && $contact->getUserTitle()}<p
                            class="badge userTitleBadge{if $contact->getRank() && $contact->getRank()->cssClassName} {@$contact->getRank()->cssClassName}{/if}">{$contact->getUserTitle()}{/if}</p>
                </div>
                {include file='userInformationStatistics'}
            </div>
        </div>
    </fieldset>
</div>
{if ($team->teamDescription != NULL)}
<div class="dashboardBox">
	<fieldset>
        <legend>{lang}teamsystem.team.page.description{/lang}</legend>
        </br>
        <div>
        	<center>{@$team->teamDescription}</center>
        </div>
    </fieldset>
</div>
{/if}