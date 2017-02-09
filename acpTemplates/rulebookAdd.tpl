{include file='header' pageTitle='wcf.acp.menu.link.tourneysystem.rulebook.add'}

<header class="contentHeader">
    <div class="contentHeaderTitle">
        <h1 class="contentTitle">{lang}wcf.acp.menu.link.tourneysystem.rulebook.add{/lang}</h1>
    </div>

    <nav class="contentHeaderNavigation">
        <ul>
            <li><a href="{link application='tourneysystem' controller='RulebookList'}{/link}" class="button"><span class="icon icon16 fa-list"></span> <span>{lang}wcf.acp.menu.link.tourneysystem.rulebook.list{/lang}</span></a></li>

            {event name='contentHeaderNavigation'}
        </ul>
    </nav>
</header>

{include file='formError'}

{if $success|isset}
    <p class="success">{lang}tourneysystem.acp.rulebook.save{/lang}</p>
{/if}

<form method="post" action="{if $action == 'add'}{link application='tourneysystem' controller='RulebookAdd'}{/link}{else}{link application='tourneysystem' controller='RulebookEdit' object=$rulebook}{/link}{/if}">
    <fieldset>
        <dl>
            <dt><label for="officialRulebook">{lang}tourneysystem.acp.rulebook.official{/lang}</label></dt>
            <dd>
                <input type="checkbox" id="officialRulebook" name="officialRulebook" value="{$officialRulebook}" {if $officialRulebook == 1} checked {/if}>
            </dd>
        </dl>

        <dl>
            <dt><label for="rulebookName">{lang}tourneysystem.acp.general.title{/lang}</label></dt>
            <dd>
                <input type="text" id="rulebookName" name="rulebookName" value="{$rulebookName}" class="long">
                {if $errorField == 'rulebookName'}
                    <small class="innerError">
                        {if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
                        {if $errorType == 'notUnique'}{lang}tourneysystem.acp.rulebook.error.notUnique{/lang}{/if}
                    </small>
                {/if}
            </dd>
        </dl>
    </fieldset>
    <div class="formSubmit">
        <input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
        {@SECURITY_TOKEN_INPUT_TAG}
    </div>
</form>

{include file='footer'}