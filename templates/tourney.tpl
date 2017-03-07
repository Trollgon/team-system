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
            {if $tourney->creatorID == $__wcf->user->userID}
                <ul class="userProfileButtonContainer">
                    {hascontent}
                    <li class="dropdown">
                        <a class="button dropdownToggle" title="{lang}tourneysystem.tourney.settings.header{/lang}">
                            <span class="icon icon32 fa-cog"></span>
                        </a>
                        <ul class="dropdownMenu userProfileButtonMenu">
                            {content}
                            {event name='menuCustomization'}
                            {if $tourney->rulebookID != null}
                                <li class="boxFlag"><a href="{link application='tourneysystem' controller='Rulebook' object=$rulebook}{/link}"
                                                       title="{lang}tourneysystem.tourney.rulebook.header{/lang}" class="box24">
                                        <span>{lang}tourneysystem.tourney.rulebook.header{/lang}</span></a></li>
                            {/if}
                                <li class="boxFlag"><a href="{link application='tourneysystem' controller='TourneyEdit' object=$tourney}{/link}"
                                                       title="{lang}tourneysystem.tourney.settings.header{/lang}" class="box24">
                                        <span>{lang}tourneysystem.tourney.settings.header{/lang}</span></a></li>
                                <li class="boxFlag"><a href="{link application='tourneysystem' controller='RefereeList' tourneyID=$tourney->tourneyID}{/link}"
                                                       title="{lang}tourneysystem.tourney.referee.manage{/lang}" class="box24">
                                        <span>{lang}tourneysystem.tourney.referee.manage{/lang}</span></a></li>
                                <li class="boxFlag"><a href="{link application='tourneysystem' controller='ControlPanel' tourneyID=$tourney->tourneyID}{/link}"
                                                       title="{lang}tourneysystem.tourney.controlpanel.header{/lang}" class="box24">
                                        <span>{lang}tourneysystem.tourney.controlpanel.header{/lang}</span></a></li>
                            {/content}
                        </ul>
                    </li>
                    {/hascontent}
                </ul>
            {else}
                {hascontent}
                    <nav class="contentHeaderNavigation">
                        <ul>
                            {content}
                            {if $tourney->rulebookID != null}
                                <li><a href="{link application='tourneysystem' controller='Rulebook' object=$rulebook}{/link}"
                                       title="{lang}tourneysystem.tourney.rulebook.header{/lang}" class="button"><span
                                                class="icon icon16 fa-book"></span>
                                        <span>{lang}tourneysystem.tourney.rulebook.header{/lang}</span></a></li>
                            {/if}
                            {if $tourney->isReferee($__wcf->user->userID)}
                                <li><a href="{link application='tourneysystem' controller='ControlPanel' tourneyID=$tourney->tourneyID}{/link}"
                                       title="{lang}tourneysystem.tourney.controlpanel.header{/lang}" class="button"><span
                                                class="icon icon16 fa-user-secret"></span>
                                        <span>{lang}tourneysystem.tourney.controlpanel.header{/lang}</span></a></li>
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
        {/if}
    </header>
{/capture}

<body id="tpl{$templateName|ucfirst}">

{include file='tourneySidebar'  application='tourneysystem' assign='sidebar'}

{include file='header' sidebarOrientation='right'}

{if $tourney->getTourneyStatusID() == 0}
    <div class="container marginTop">
        <p class="info">{lang}tourneysystem.tourney.page.invisible{/lang}</p>
    </div>
{elseif $tourney->getTourneyStatusID() < 3}

    <header class="boxHeadline boxSubHeadline">
        <h2>{lang}tourneysystem.tourney.participants{/lang} <span class="badge">{$signUp->count()}</span></h2>
    </header>

    {if $signUp|count > 0}
        <div class="section sectionContainerList">
            <ol class="containerList userList">
                {foreach from=$signUp item=team}
                    {include file='teamItem' application='tourneysystem'}
                {/foreach}
            </ol>
        </div>
    {else}
        <p class="info">{lang}tourneysystem.team.overview.noTeams{/lang}</p>
    {/if}

{/if}



{include file='footer'}

