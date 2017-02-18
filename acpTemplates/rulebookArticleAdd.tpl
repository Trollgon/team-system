{include file='header' pageTitle='wcf.acp.menu.link.tourneysystem.rulebookArticle.add'}

<header class="contentHeader">
    <div class="contentHeaderTitle">
        <h1 class="contentTitle">{lang}wcf.acp.menu.link.tourneysystem.rulebookArticle.add{/lang}</h1>
    </div>

    <nav class="contentHeaderNavigation">
        <ul>
            <li><a href="{link application='tourneysystem' controller='RulebookArticleList' rulebookID=$rulebook->rulebookID}{/link}" class="button"><span class="icon icon16 fa-list"></span> <span>{lang}wcf.acp.menu.link.tourneysystem.rulebookArticle.list{/lang}</span></a></li>

            {event name='contentHeaderNavigation'}
        </ul>
    </nav>
</header>

{include file='formError'}

{if $success|isset}
    <p class="success">{lang}tourneysystem.acp.rulebookArticle.save{/lang}</p>
{/if}

<form method="post" action="{if $action == 'add'}{link application='tourneysystem' controller='RulebookArticleAdd' rulebookID=$rulebook->rulebookID}{/link}{else}{link application='tourneysystem' controller='RulebookArticleEdit' object=$rulebookArticle rulebookID=$rulebook->rulebookID}{/link}{/if}">
    <fieldset>
        <dl{if $errorField == 'articleOrder'} class="formError"{/if} class="articleOrder">
            <dt><label for="articleOrder">{lang}tourneysystem.acp.rulebookArticle.articleOrder{/lang}</label></dt>
            <dd>
                <input type="number" min="0" step="1" id="articleOrder" name="articleOrder" value="{$articleOrder}" class=""/>
            </dd>
        </dl>
        <dl>
            <dt><label for="rulebookArticleName">{lang}tourneysystem.acp.general.title{/lang}</label></dt>
            <dd>
                <input type="text" id="rulebookArticleName" name="rulebookArticleName" value="{$rulebookArticleName}" class="long">
                {if $errorField == 'rulebookArticleName'}
                    <small class="innerError">
                        {if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
                        {if $errorType == 'notUnique'}{lang}tourneysystem.acp.rulebookArticleName.error.notUnique{/lang}{/if}
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