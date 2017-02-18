{capture assign='contentHeader'}
    <header class="contentHeader articleContentHeader">
        <div class="contentHeaderTitle">
            <h1 class="contentTitle" itemprop="name headline">{lang}tourneysystem.tourney.signUp.title{/lang}</h1>
        </div>
    </header>
{/capture}

<body id="tpl{$templateName|ucfirst}">

{include file='tourneySidebar'  application='tourneysystem' assign='sidebar'}

{include file='header' sidebarOrientation='right'}

{include file='formError'}

{if $memberMissing == true}
    <p class="error">{lang}tourneysystem.team.page.notEnoughMembers{/lang}</p>
{elseif $subMissing == true}
    <p class="info">{lang}tourneysystem.team.page.noSubs{/lang}</p>
{/if}
{if $missingContactInfo == true}
    <p class="error">{lang}tourneysystem.team.page.missingContactinfo{/lang}</p>
{/if}

<form method="post" action="{link application='tourneysystem' controller='TourneySignUp' tourneyID=$tourneyID}{/link}">
    <fieldset>
        <div class="formSubmit">
            {if $memberMissing == false && $missingContactInfo == false}
                <input type="submit" value="{lang}wcf.user.register.disclaimer.accept{/lang}" accesskey="s" />
            {/if}

            <a class="button" href="{link application='tourneysystem' controller='Tourney' object=$tourney}{/link}">{lang}wcf.user.register.disclaimer.decline{/lang}</a>

            {@SECURITY_TOKEN_INPUT_TAG}
        </div>
    </fieldset>

</form>

{include file='footer' sandbox=false}
</body>
