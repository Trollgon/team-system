{include file='documentHeader'}

<head>
    <title>{lang}teamsystem.team.create.dummy{/lang} - {PAGE_TITLE|language}</title>

    {include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">

{include file='header' sidebarOrientation='left'}

<header class="boxHeadline">
    <h1>{lang}teamsystem.team.create.dummy{/lang}</h1>
</header>

{include file='userNotice'}

{include file='formError'}

<form method="post" action="{link application='teamsystem' controller='TeamCreateDummy'}{/link}">

    <div class="formSubmit">

        <input type="submit" value="{lang}wcf.user.register.disclaimer.accept{/lang}" accesskey="s" />

        <a class="button" href="{link application='teamsystem' controller='TeamList'}{/link}">{lang}wcf.user.register.disclaimer.decline{/lang}</a>

        {@SECURITY_TOKEN_INPUT_TAG}

    </div>

</form>

{include file='footer' sandbox=false}
</body>
</html>
