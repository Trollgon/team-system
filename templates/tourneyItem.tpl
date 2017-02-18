<li data-object-id="{@$tourney->tourneyID}">
    <div class="box48">
        <a href="{link application='tourneysystem' controller='Tourney' object=$tourney}{/link}" >{@$tourney->getAvatar()->getImageTag(48)}</a>

        <div class="details userInformation">
            <div class="containerHeadline">
                <h3><a href="{link application='tourneysystem' controller='Tourney' object=$tourney}{/link}">{$tourney->getTitle()} ({$tourney->getPlatformName()})</a></h3>
            </div>

            <ul class="inlineList commaSeparated">

                <li>{@$tourney->getGameName()} ({@$tourney->getGamemodeName()})</li>
                <li>{lang}wcf.global.date{/lang}: {@$tourney->tourneyStartTime|time}</li>
                {event name='userData'}
            </ul>
        </div>
    </div>
</li>