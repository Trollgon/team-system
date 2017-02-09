{include file='header' pageTitle='wcf.acp.menu.link.tourneysystem.rule.list'}

<script data-relocate="true">
    $(function () {
        new WCF.Action.Delete('tourneysystem\\data\\rulebook\\rule\\RulebookRuleAction', '.jsRulebookRow');
    });
</script>

<header class="contentHeader">
    <div class="contentHeaderTitle">
        <h1 class="contentTitle">{lang}wcf.acp.menu.link.tourneysystem.rulebookRule.list{/lang}</h1>
    </div>

    <nav class="contentHeaderNavigation">
        <ul>
            <li><a href="{link application='tourneysystem' controller='RulebookArticleList' rulebookID=$article->getRulebook()->rulebookID}{/link}" class="button"><span
                            class="icon icon16 fa-list"></span>
                    <span>{lang}wcf.acp.menu.link.tourneysystem.rulebookArticle.list{/lang}</span></a></li>
            <li><a href="{link application='tourneysystem' controller='RulebookRuleAdd' rulebookArticleID=$article->rulebookArticleID}{/link}" class="button"><span
                            class="icon icon16 fa-plus"></span>
                    <span>{lang}wcf.acp.menu.link.tourneysystem.rulebookRule.add{/lang}</span></a></li>

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
                    {lang}wcf.global.objectID{/lang}
                </th>
                <th class="columnText columnClassName">
                    {lang}tourneysystem.acp.general.title{/lang}
                </th>
                {event name='headColumns'} </tr>
            </thead>
            <tbody>
            {foreach from=$objects item=rule}
                <tr class="jsRulebookRow">
                    <td class="columnIcon">
                        {* toggle, edit, delete *}
                        <a href="{link application='tourneysystem' controller='RulebookRuleEdit' object=$rule rulebookArticleID=$article->rulebookArticleID}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip"><span class="icon icon16 fa-pencil"></span></a>
                        <span class="icon icon16 fa-times jsDeleteButton jsTooltip pointer" title="{lang}wcf.global.button.delete{/lang}" data-object-id="{@$rule->ruleID}" data-confirm-message-html="{lang __encode=true}tourneysystem.acp.rulebookRule.sure{/lang}"></span>
                        {event name='buttons'}
                    </td>
                    <td class="columnID"><p>{@$rule->ruleOrder}</p></td>
                    <td class="columnText columnClassName"><p>{$rule->getTitle()}</p></td>
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
                        <li><a href="{link application='tourneysystem' controller='RulebookArticleList' rulebookID=$article->getRulebook()->rulebookID}{/link}" class="button"><span
                                        class="icon icon16 fa-list"></span>
                                <span>{lang}wcf.acp.menu.link.tourneysystem.rulebookArticle.list{/lang}</span></a></li>
                        <li><a href="{link application='tourneysystem' controller='RulebookRuleAdd' rulebookArticleID=$article->rulebookArticleID}{/link}" class="button"><span
                                        class="icon icon16 fa-plus"></span>
                                <span>{lang}wcf.acp.menu.link.tourneysystem.rulebookRule.add{/lang}</span></a></li>
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
