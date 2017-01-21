<li data-object-id="{@$user->userID}">
    <div class="box48">
        <a href="{link controller='User' object=$user}{/link}" title="{$user->username}" class="framed">
            {@$user->getAvatar()->getImageTag(48)}
        </a>
        <div class="details userInformation">
            <div class="containerHeadline">

                <h3><a href="{link controller='User' object=$user}{/link}">{$user->username}</a>{if $user->banned} <span class="icon icon16 fa-lock jsTooltip jsUserBanned" title="{lang}wcf.user.banned{/lang}"></span>{/if}{if MODULE_USER_RANK}

                        {if $user->getUserTitle()}

                            <span class="badge userTitleBadge{if $user->getRank() && $user->getRank()->cssClassName} {@$user->getRank()->cssClassName}{/if}">{$user->getUserTitle()}</span>

                        {/if}

                        {if $user->getRank() && $user->getRank()->rankImage}

                            <span class="userRankImage">{@$user->getRank()->getImage()}</span>

                        {/if}

                    {/if}</h3>

            </div>

            <ul class="dataList userFacts">

                {if ($user->getUserOption($userOption->optionName) != NULL)}
                    <li>
                        {lang}wcf.user.option.{@$userOption->optionName}{/lang}: {@$user->getUserOption($userOption->optionName)}
                    </li>
                {/if}

                {event name='userData'}

            </ul>

            {include file='userInformationButtons'}

            {include file='playerInformationStatistics' application='teamsystem'}
        </div>
    </div>
</li>