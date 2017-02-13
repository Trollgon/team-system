{capture assign='contentHeader'}
    <header class="contentHeader articleContentHeader">

        {hascontent}
        <nav class="contentHeaderNavigation">
            <ul class="userProfileButtonContainer">

                {content}
                    <li><a href="{link application='tourneysystem' controller='RefereeAdd' tourneyID=$tourney->tourneyID}{/link}"
                           title="{lang}tourneysystem.tourney.referee.add{/lang}" class="button"><span
                                    class="icon icon16 fa-plus"></span>
                            <span>{lang}tourneysystem.tourney.referee.add{/lang}</span></a></li>
                {/content}
            </ul>
        </nav>
        {/hascontent}
    </header>
{/capture}

<body id="tpl{$templateName|ucfirst}">

{include file='tourneySidebar'  application='tourneysystem' assign='sidebar'}

{include file='header' sidebarOrientation='right'}

<div class="section sectionContainerList">
    <ul class="containerList">
        <li>
            <div>
                <div class="containerHeadline">
                    {foreach from=$refereeList item=referee}
                        <h3><a href="{link application='tourneysystem' controller='RefereeKick' tourneyID=$tourney->tourneyID userID=$referee->userID}{/link}"
                               title="{lang}tourneysystem.tourney.referee.kick.this{/lang}">
                                <span class="icon icon16 fa-remove"></span></a>
                            {@$referee->getUsername()}</h3>
                    {/foreach}
                </div>
            </div>
        </li>
    </ul>
</div>

{include file='footer' sandbox=false}
</body>