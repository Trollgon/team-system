{include file='header' pageTitle='wcf.acp.menu.link.tourneysystem.rulebookRule.add'}

<header class="contentHeader">
    <div class="contentHeaderTitle">
        <h1 class="contentTitle">{lang}wcf.acp.menu.link.tourneysystem.rulebookRule.add{/lang}</h1>
    </div>

    <nav class="contentHeaderNavigation">
        <ul>
            <li><a href="{link application='tourneysystem' controller='RulebookRuleList' rulebookArticleID=$article->rulebookArticleID}{/link}" class="button"><span class="icon icon16 fa-list"></span> <span>{lang}wcf.acp.menu.link.tourneysystem.rulebookRule.list{/lang}</span></a></li>

            {event name='contentHeaderNavigation'}
        </ul>
    </nav>
</header>

{include file='formError'}

{if $success|isset}
    <p class="success">{lang}tourneysystem.acp.rulebookRule.save{/lang}</p>
{/if}

<form method="post" action="{if $action == 'add'}{link application='tourneysystem' controller='RulebookRuleAdd' rulebookArticleID=$article->rulebookArticleID}{/link}{else}{link application='tourneysystem' controller='RulebookRuleEdit' rulebookArticleID=$article->rulebookArticleID object=$rule}{/link}{/if}">
    <fieldset>
        <dl{if $errorField == 'ruleOrder'} class="formError"{/if} class="articleOrder">
            <dt><label for="ruleOrder">{lang}tourneysystem.acp.rulebookRule.ruleOrder{/lang}</label></dt>
            <dd>
                <input type="number" min="0" step="1" id="ruleOrder" name="ruleOrder" value="{$ruleOrder}" class=""/>
            </dd>
        </dl>

        <dl{if $errorField == 'text'} class="formError"{/if}>
            <dt><label for="text">{lang}tourneysystem.acp.rulebookRule.text{/lang}</label></dt>
            <dd>
                <textarea id="text" name="text" rows="10" cols="40" maxlength="400">{@$text}</textarea>
                {if $errorField == 'text'}
                    <small class="innerError">
                        {lang}tourneysystem.team.page.description.error.length{/lang}
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