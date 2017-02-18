{include file='header' pageTitle='wcf.acp.menu.link.tourneysystem.rulebookArticle.list'}

<script data-relocate="true">
    $(function () {
        new WCF.Action.Delete('tourneysystem\\data\\rulebook\\article\\RulebookArticleAction', '.jsRulebookArticleRow');
    });
</script>

<header class="contentHeader">
    <div class="contentHeaderTitle">
        <h1 class="contentTitle">{lang}wcf.acp.menu.link.tourneysystem.rulebookArticle.list{/lang}</h1>
    </div>

    <nav class="contentHeaderNavigation">
        <ul>
            <li><a href="{link application='tourneysystem' controller='RulebookArticleAdd' rulebookID=$rulebook->rulebookID}{/link}" class="button"><span
                            class="icon icon16 fa-plus"></span>
                    <span>{lang}wcf.acp.menu.link.tourneysystem.rulebookArticle.add{/lang}</span></a></li>

            {event name='contentHeaderNavigation'}
        </ul>
    </nav>
</header>

{if $objects|count}
    <div class="section tabularBox">
        <table class="table">
            <thead>
            <tr>
                <th class="columnID columnEntryID" colspan="2">
                    {lang}tourneysystem.acp.rulebookArticle.articleOrder{/lang}
                </th>
                <th class="columnText columnClassName">
                    {lang}tourneysystem.acp.general.title{/lang}
                </th>
                {event name='headColumns'} </tr>
            </thead>
            <tbody>
            {foreach from=$objects item=rulebookArticle}
                <tr class="jsRulebookArticleRow">
                    <td class="columnIcon">
                        {* toggle, edit, delete *}
                        <a href="{link application='tourneysystem' controller='RulebookArticleEdit' object=$rulebookArticle rulebookID=$rulebook->rulebookID}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip"><span class="icon icon16 fa-pencil"></span></a>
                        <a href="{link application='tourneysystem' controller='RulebookRuleList' rulebookArticleID=$rulebookArticle->rulebookArticleID}{/link}" title="{lang}tourneysystem.acp.general.list{/lang}" class="jsTooltip"><span class="icon icon16 fa-list"></span></a>
                        <a href="{link application='tourneysystem' controller='RulebookRuleAdd' rulebookArticleID=$rulebookArticle->rulebookArticleID}{/link}" title="{lang}wcf.acp.menu.link.tourneysystem.rulebookRule.add{/lang}" class="jsTooltip"><span class="icon icon16 fa-plus"></span></a>
                        <span class="icon icon16 fa-times jsDeleteButton jsTooltip pointer" title="{lang}wcf.global.button.delete{/lang}" data-object-id="{@$rulebook->rulebookID}" data-confirm-message-html="{lang __encode=true}tourneysystem.acp.rulebookArticle.sure{/lang}"></span>
                        {event name='buttons'}
                    </td>
                    <td class="columnID"><p>{@$rulebookArticle->articleOrder}</p></td>
                    <td class="columnText columnClassName"><p>{$rulebookArticle->rulebookArticleName}</p></td>
                    {event name='columns'} </tr>
            {/foreach}
            </tbody>
        </table>
    </div>

    <footer class="contentFooter">
        {hascontent}
            <nav class="contentFooterNavigation">
                <ul>
                    {content}
                        <li><a href="{link application='tourneysystem' controller='RulebookArticleAdd' rulebookID=$rulebook->rulebookID}{/link}" class="button"><span
                                        class="icon icon16 fa-plus"></span>
                                <span>{lang}wcf.acp.menu.link.tourneysystem.rulebookArticle.add{/lang}</span></a></li>
                    {event name='contentFooterNavigation'}
                    {/content}
                </ul>
            </nav>
        {/hascontent}
    </footer>
{else}
    <p class="info">{lang}tourneysystem.acp.general.noContent{/lang}</p>
{/if}

{include file='footer'}
