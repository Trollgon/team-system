{if ($templateName != 'team')}
    <section class="box">
        <h2 class="boxTitle">{lang}tourneysystem.team.page.team{/lang}</h2>
        <div class="boxContent">
            <div class="box96">
                <a href="{link controller='Team' application='tourneysystem' object=$team}{/link}"
                   data-user-id="{@$team->teamID}">{@$team->getAvatar()->getImageTag(96)}</a>
                <div>
                    <div class="containerHeadline">
                        <h3><a href="{link controller='Team' application='tourneysystem' object=$team}{/link}">{$team->teamName}</a></h3>
                    </div>

                    <dl class="plain dataList containerContent small">
                        {event name='statistics'}
                        <p>{lang}tourneysystem.team.page.registrationDate{/lang}</p>
                        <p>{lang}tourneysystem.team.teamList.platform{/lang}</p>
                    </dl>
                </div>
            </div>
        </div>
    </section>
{/if}

<section class="box">
    <h2 class="boxTitle">{lang}tourneysystem.team.page.contact{/lang}</h2>
    <div class="boxContent">
        <div class="box96">
            <a href="{link controller='User' object=$contact}{/link}"
               data-user-id="{@$contact->userID}">{@$contact->getAvatar()->getImageTag(96)}</a>
            <div>
                <div class="containerHeadline">
                    <h3><a href="{link controller='User' object=$contact}{/link}">{$contact->username}</a></h3>
                    {if MODULE_USER_RANK}
                        {if $contact->getUserTitle()}
                            <p><span class="badge userTitleBadge{if $contact->getRank() && $contact->getRank()->cssClassName} {@$contact->getRank()->cssClassName}{/if}">{$contact->getUserTitle()}</span></p>
                        {/if}
                        {if $contact->getRank() && $contact->getRank()->rankImage}
                            <p><span class="userRankImage">{@$contact->getRank()->getImage()}</span></p>
                        {/if}
                    {/if}
                </div>

                <dl class="plain dataList containerContent small">
                    {include file='userInformationStatistics' user=$contact}
                </dl>
            </div>
        </div>
    </div>
</section>

{if ($team->teamDescription != NULL)}
    <section class="box">
        <h2 class="boxTitle">{lang}tourneysystem.team.page.description{/lang}</h2>
        <div class="boxContent">
            <center>{@$team->teamDescription}</center>
        </div>
    </section>
{/if}