{include file='header' pageTitle='wcf.acp.menu.link.tourneysystem.gamemode.add'}

<header class="contentHeader">
    <div class="contentHeaderTitle">
        <h1 class="contentTitle">{lang}wcf.acp.menu.link.tourneysystem.gamemode.add{/lang}</h1>
    </div>

    <nav class="contentHeaderNavigation">
        <ul>
            <li><a href="{link application='tourneysystem' controller='GamemodeList'}{/link}" class="button"><span class="icon icon16 fa-list"></span> <span>{lang}wcf.acp.menu.link.tourneysystem.gamemode.list{/lang}</span></a></li>

            {event name='contentHeaderNavigation'}
        </ul>
    </nav>
</header>

{include file='formError'}

{if $success|isset}
    <p class="success">{lang}tourneysystem.acp.gamemode.save{/lang}</p>
{/if}

<form method="post" action="{if $action == 'add'}{link application='tourneysystem' controller='GamemodeAdd'}{/link}{else}{link application='tourneysystem' controller='GamemodeEdit' object=$gamemode}{/link}{/if}">
    <fieldset>
        <dl>
            <dt><label for="gamemodeName">{lang}tourneysystem.acp.general.title{/lang}</label></dt>
            <dd>
                <input type="text" id="gamemodeName" name="gamemodeName" value="{$gamemodeName}" class="long">
                {if $errorField == 'gamemodeName'}
                    <small class="innerError">
                        {if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
                        {if $errorType == 'notUnique'}{lang}tourneysystem.acp.gamemode.error.notUnique{/lang}{/if}
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