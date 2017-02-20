{capture assign='pageTitle'}{$rulebook->rulebookName}{/capture}

{capture assign='contentHeader'}
    <header class="contentHeader userProfileUser">
        <div class="contentHeaderTitle">
            <h1 class="contentTitle" itemprop="name headline">
                {$rulebook->rulebookName}
            </h1>
        </div>
    </header>
{/capture}

<body id="tpl{$templateName|ucfirst}">

{include file='header'}

<div class="section htmlContent">
    {foreach from=$rulebook->getArticles() item=article}
        <header class="boxHeadline boxSubHeadline">
            <h2>§{@$article->articleOrder}: {@$article->getTitle()}</h2>
        </header>
        <div class="container marginTop">
            <ol class="containerList userList">
                {foreach from=$article->getRules() item=rule}
                    <p>{if $rule->ruleOrder > 0}({@$rule->ruleOrder}) {/if}{@$rule->text}</p>
                {/foreach}
            </ol>
        </div>
    {/foreach}

    {event name='sections'}
</div>

{include file='footer'}

