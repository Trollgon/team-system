{include file='header' pageTitle='wcf.acp.menu.link.tourneysystem.platform.add'}

<header class="contentHeader">
    <div class="contentHeaderTitle">
        <h1 class="contentTitle">{lang}wcf.acp.menu.link.tourneysystem.platform.add{/lang}</h1>
    </div>

    <nav class="contentHeaderNavigation">
        <ul>
            <li><a href="{link application='tourneysystem' controller='PlatformList'}{/link}" class="button"><span class="icon icon16 fa-list"></span> <span>{lang}wcf.acp.menu.link.tourneysystem.platform.list{/lang}</span></a></li>

            {event name='contentHeaderNavigation'}
        </ul>
    </nav>
</header>

{include file='formError'}

{if $success|isset}
    <p class="success">{lang}tourneysystem.acp.platform.save{/lang}</p>
{/if}

<form method="post" action="{link application='tourneysystem' controller='PlatformAdd'}{/link}">
    <fieldset>
        <dl>
            <dt><label for="platformName">{lang}tourneysystem.acp.platform.title{/lang}</label></dt>
            <dd>
                <input type="text" id="platformName" name="platformName" value="{$platformName}" class="long">
                {if $errorField == 'platformName'}
                    <small class="innerError">
                        {if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
                        {if $errorType == 'notUnique'}{lang}tourneysystem.acp.platform.error.notUnique{/lang}{/if}
                    </small>
                {/if}
            </dd>
        </dl>
        <dl>
            <dt><label for="userOption">{lang}tourneysystem.acp.userOption.title{/lang}</label></dt>
            <dd>
                <select id="userOption" name="userOption">
                    <option value="">{lang}tourneysystem.team.overview.platform.choose{/lang}</option>
                    {foreach from=$userOptionArray item=option}
                        <option value="{$option->optionID}" {if $optionID == $option->optionID} selected="selected" {/if}>{lang}wcf.user.option.{$option->optionName}{/lang}</option>
                    {/foreach}
                </select>
                {if $errorField == 'userOption'}
                    <small class="innerError">
                        {lang}wcf.global.form.error.empty{/lang}
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