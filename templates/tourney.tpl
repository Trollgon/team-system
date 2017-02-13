{capture assign='pageTitle'}{$tourney->tourneyName}{/capture}

{capture assign='contentHeader'}
    <header class="contentHeader articleContentHeader">
        <div class="contentHeaderTitle">
            <h1 class="contentTitle" itemprop="name headline">{$tourney->tourneyName} ({@$tourney->getPlatformName()}) {if $tourney->officialTourney}<span class="icon icon32 fa-check jsTooltip" title="{lang}tourneysystem.tourney.official{/lang}"></span>{/if}</h1>
            <ul class="inlineList contentHeaderMetaData articleMetaData">
                <li>
                    <span class="icon icon16 fa-gamepad"></span>
                    <span>{@$tourney->getGameName()} ({@$tourney->getGamemodeName()})</span>
                </li>

                <li>
                    <span class="icon icon16 fa-clock-o"></span>
                    <span>{@$tourney->tourneyStartTime|time}</span>
                </li>

                <li class="articleLikesBadge"></li>
            </ul>
        </div>

        {if $__wcf->getUser()->getUserID() != 0}
            {hascontent}
                <nav class="contentHeaderNavigation">
                    <ul>
                        {content}
                        {if $tourney->isReferee($__wcf->user->userID)}
                            <li><a href="{link application='tourneysystem' controller='TourneySettings' tourneyID=$tourney->tourneyID}{/link}"
                                   title="{lang}tourneysystem.tourney.settings.header{/lang}" class="button"><span
                                            class="icon icon16 fa-cog"></span>
                                    <span>{lang}tourneysystem.tourney.settings.header{/lang}</span></a></li>
                        {/if}
                        {if $tourney->getTourneyStatusID() == 1}
                            {if $canSignUp == true}
                                <li><a href="{link application='tourneysystem' controller='TourneySignUp' tourneyID=$tourney->tourneyID}{/link}"
                                       title="{lang}tourneysystem.tourney.signUp.header{/lang}" class="button"><span
                                                class="icon icon16 fa-sign-in"></span>
                                        <span>{lang}tourneysystem.tourney.signUp.header{/lang}</span></a></li>
                            {/if}
                            {if $canSignOff == true}
                                <li><a href="{link application='tourneysystem' controller='TourneySignOff' tourneyID=$tourney->tourneyID}{/link}"
                                       title="{lang}tourneysystem.tourney.signOff.header{/lang}" class="button"><span
                                                class="icon icon16 fa-sign-out"></span>
                                        <span>{lang}tourneysystem.tourney.signOff.header{/lang}</span></a></li>
                            {/if}
                        {/if}
                        {event name='contentHeaderNavigation'}
                        {/content}
                    </ul>
                </nav>
            {/hascontent}
        {/if}
    </header>
{/capture}

<body id="tpl{$templateName|ucfirst}">

{include file='tourneySidebar'  application='tourneysystem' assign='sidebar'}

{include file='header' sidebarOrientation='right'}

{if $tourney->getTourneyStatusID() == 0}
    <div class="container marginTop">
        TBD
    </div>
{elseif $tourney->getTourneyStatusID() < 3 && $signUp->count() > 0}

    <header class="boxHeadline boxSubHeadline">
        <h2>{lang}tourneysystem.tourney.signUp.header{/lang} <span class="badge">{$signUp->count()}</span></h2>
    </header>

    <ol class="containerList userList">
        {foreach from=$signUp item=team}
            {include file='teamItem' application='tourneysystem'}
        {/foreach}
    </ol>

{/if}



{include file='footer'}

