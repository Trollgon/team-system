<body id="tpl{$templateName|ucfirst}">

{include file='tourneySidebar'  application='tourneysystem' assign='sidebar'}

{include file='header' sidebarOrientation='right'}

{include file='formError'}

<p class="warning">{lang}tourneysystem.tourney.referee.kick.warning{/lang}</p>

<form method="post" action="{link application='tourneysystem' controller='RefereeKick' tourneyID=$tourney->tourneyID userID=$userID}{/link}">

    <div class="formSubmit">
        <fieldset>
            <input type="submit" value="{lang}wcf.user.register.disclaimer.accept{/lang}" accesskey="s" />

            <a class="button" href="{link application='tourneysystem' controller='RefereeList' tourneyID=$tourney->tourneyID}{/link}">{lang}wcf.user.register.disclaimer.decline{/lang}</a>

            {@SECURITY_TOKEN_INPUT_TAG}
        </fieldset>

    </div>

</form>

{include file='footer' sandbox=false}
</body>
