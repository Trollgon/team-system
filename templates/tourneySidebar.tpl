<section class="box">
    <h2 class="boxTitle">{lang}tourneysystem.tourney.details{/lang}</h2>

    <div class="boxContent">
        <dl class="plain dataList">
            {event name='stats'}

            {if ($templateName != 'tourney')}

                <dt>{lang}wcf.global.date{/lang}</dt>
                <dd>{@$tourney->tourneyStartTime|time}</dd>

                <dt>{lang}tourneysystem.team.overview.platform{/lang}</dt>
                <dd>{@$tourney->getPlatformName()}</dd>

                <dt>{lang}tourneysystem.tourney.create.game{/lang}</dt>
                <dd>{@$tourney->getGameName()}</dd>

                <dt>{lang}tourneysystem.tourney.create.gameMode{/lang}</dt>
                <dd>{@$tourney->getGamemodeName()}</dd>
            {/if}

            <dt>{lang}tourneysystem.tourney.type{/lang}</dt>
            <dd>Round Robin</dd>

            <dt>{lang}tourneysystem.tourney.participants{/lang}</dt>
            <dd>{$tourney->getSignUp()|count}{if $tourney->maxParticipants != null}/{$tourney->maxParticipants}{/if}</dd>

            <dt>{lang}tourneysystem.tourney.minParticipants{/lang}</dt>
            <dd>{$tourney->minParticipants}</dd>

        </dl>
    </div>
</section>

{if $juryArray}
    <section class="box">
        <h2 class="boxTitle">{lang}tourneysystem.tourney.jury{/lang} <span class="badge">{$juryArray->count()}</span></h2>

        <div class="boxContent">
            <ul class="userAvatarList">
                {foreach from=$juryArray item=member}
                    <li><a href="{link controller='User' object=$member}{/link}" title="{$member->username}" class="jsTooltip">{@$member->getAvatar()->getImageTag(48)}</a></li>
                {/foreach}
            </ul>
        </div>
    </section>
{/if}