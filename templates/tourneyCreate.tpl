<body id="tpl{$templateName|ucfirst}">

{include file='header' sandbox='false'}

{include file='formError'}

<form method="post" action="{link application='tourneysystem' controller='TourneyCreate'}{/link}">
    <fieldset>
        <legend>{lang}tourneysystem.team.overview.basic{/lang}</legend>

        <dl{if $errorField == 'game'} class="formError"{/if}>
            <dt><label for="gameID">{lang}tourneysystem.tourney.create.game{/lang}</label></dt>
            <dd>
                <select id="gameID" name="gameID">
                    <option value="">{lang}tourneysystem.team.overview.platform.choose{/lang}</option>
                    {foreach from=$gameArray item=game}
                        <option value="{$game->gameID}" {if $gameID == $game->gameID} selected="selected" {/if}>{$game->gameName}</option>
                    {/foreach}
                </select>
                {if $errorField == 'game'}
                    <small class="innerError">
                        {lang}wcf.global.form.error.empty{/lang}
                    </small>
                {/if}
                <small>{lang}tourneysystem.tourney.create.game.description{/lang}</small>
            </dd>
        </dl>

        <dl{if $errorField == 'gamemode'} class="formError"{/if}>
            <dt><label for="gamemodeID">{lang}tourneysystem.tourney.create.gameMode{/lang}</label></dt>
            <dd>
                <select id="gamemodeID" name="gamemodeID">
                    <option value="">{lang}tourneysystem.team.overview.platform.choose{/lang}</option>
                    {foreach from=$gameModeArray item=gamemode}
                        <option value="{$gamemode->gamemodeID}" {if $gamemodeID == $gamemode->gamemodeID} selected="selected" {/if}>{$gamemode->gamemodeName}</option>
                    {/foreach}
                </select>
                {if $errorField == 'gamemode'}
                    <small class="innerError">
                        {lang}wcf.global.form.error.empty{/lang}
                    </small>
                {/if}
                <small>{lang}tourneysystem.tourney.create.gameMode.description{/lang}</small>
            </dd>
        </dl>

        <dl{if $errorField == 'platform'} class="formError"{/if}>
            <dt><label for="platformID">{lang}tourneysystem.team.overview.platform{/lang}</label></dt>
            <dd>
                <select id="platformID" name="platformID">
                    <option value="">{lang}tourneysystem.team.overview.platform.choose{/lang}</option>
                    {foreach from=$platformArray item=platform}
                        <option value="{$platform->platformID}" {if $platformID == $platform->platformID} selected="selected" {/if}>{$platform->platformName}</option>
                    {/foreach}
                </select>
                {if $errorField == 'platform'}
                    <small class="innerError">
                        {lang}wcf.global.form.error.empty{/lang}
                    </small>
                {/if}
                <small>{lang}tourneysystem.tourney.create.platform.description{/lang}</small>
            </dd>
        </dl>

        {if $rulebookArray|count > 0}
            <dl{if $errorField == 'rulebook'} class="formError"{/if}>
                <dt><label for="rulebookID">{lang}tourneysystem.tourney.create.rulebook{/lang}</label></dt>
                <dd>
                    <select id="rulebookID" name="rulebookID">
                        <option value="">{lang}tourneysystem.team.overview.platform.choose{/lang}</option>
                        {foreach from=$rulebookArray item=rulebook}
                            <option value="{$rulebook->rulebookID}" {if $rulebookID == $rulebook->rulebookID} selected="selected" {/if}>{$rulebook->rulebookName}</option>
                        {/foreach}
                    </select>
                    {if $errorField == 'rulebook'}
                        <small class="innerError">
                            {lang}wcf.global.form.error.empty{/lang}
                        </small>
                    {/if}
                    <small>{lang}tourneysystem.tourney.create.rulebook.description{/lang}</small>
                </dd>
            </dl>
        {/if}

        {if $__wcf->getSession()->getPermission('admin.tourneySystem.canCreateOfficialTourneys')}
            <dl>
                <dt><label for="officialTourney">{lang}tourneysystem.tourney.create.officialTourney{/lang}</label></dt>
                <dd>
                    <input type="checkbox" id="officialTourney" name="officialTourney" value="{$officialTourney}" {if $officialTourney == true} checked {/if}>
                </dd>
            </dl>
        {/if}

        <dl{if $errorField == 'tourneyName'} class="formError"{/if}>
            <dt><label for="tourneyName">{lang}tourneysystem.tourney.create.name{/lang}</label></dt>
            <dd>
                <input type="text" id="tourneyName" name="tourneyName" value="{$tourneyName}" class=""/>
                {if $errorField == tourneyName}
                    <small class="innerError">
                        {if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
                        {if $errorType == 'notValid'}{lang}tourneysystem.tourney.create.name.error.notValid{/lang}{/if}
                        {if $errorType == 'notUnique'}{lang}tourneysystem.tourney.create.name.error.notUnique{/lang}{/if}
                    </small>
                {/if}
            </dd>
        </dl>
    </fieldset>

    <fieldset>
        <legend>{lang}tourneysystem.tourney.create.settings{/lang}</legend>

        <dl{if $errorField == 'minParticipants'} class="formError"{/if} class="minParticipants">
            <dt><label for="minParticipants">{lang}tourneysystem.tourney.create.minParticipants{/lang}</label></dt>
            <dd>
                <input type="number" min="2" step="1" id="minParticipants" name="minParticipants" value="{$minParticipants}" class=""/>
                {if $errorField == 'minParticipants'}
                    <small class="innerError">
                        {lang}wcf.global.form.error.empty{/lang}
                    </small>
                {/if}
            </dd>
        </dl>

        <dl>
            <dt><label for="enableMaxParticipants">{lang}tourneysystem.tourney.create.enableMaxParticipants{/lang}</label></dt>
            <dd>
                <input type="checkbox" id="enableMaxParticipants" name="enableMaxParticipants" value="{$enableMaxParticipants}" {if $enableMaxParticipants == true} checked {/if}>
            </dd>
        </dl>

        <dl{if $errorField == 'maxParticipants'} class="formError"{/if} class="maxParticipants">
            <dt></dt>
            <dd>
                <input type="number" min="4" step="1" id="maxParticipants" name="maxParticipants" value="{$maxParticipants}" class=""/>
                {if $errorField == 'maxParticipants'}
                    <small class="innerError">
                        {if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
                        {if $errorType == 'tooHigh'}{lang}tourneysystem.tourney.create.maxParticipants.error.tooHigh{/lang}{/if}
                    </small>
                {/if}
            </dd>
        </dl>

        <dl{if $errorField == 'time'} class="formError"{/if}>
            <dt><label for="time">{lang}wcf.global.date{/lang}</label></dt>
            <dd>
                <input type="datetime" id="time" name="time" value="{$time}" class="medium">
                {if $errorField == 'time'}
                    <small class="innerError">
                        {if $errorType == 'empty'}
                            {lang}wcf.global.form.error.empty{/lang}
                        {else}
                            {lang}wcf.acp.article.time.error.{@$errorType}{/lang}
                        {/if}
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