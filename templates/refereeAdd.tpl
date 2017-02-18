<body id="tpl{$templateName|ucfirst}">

{include file='tourneySidebar'  application='tourneysystem' assign='sidebar'}

{include file='header' sidebarOrientation='right'}

{include file='formError'}

<form method="post" action="{link application='tourneysystem' controller='RefereeAdd' tourneyID=$tourney->tourneyID}{/link}">
    <div class="container containerPadding marginTop">
        <fieldset>

            <dl{if $errorField == 'username'} class="formError"{/if}>
                <dt><label for="username">{lang}wcf.user.username{/lang}</label></dt>
                <dd>
                    <input type="text" id="username" name="username" value="{$username}" class="medium" />
                    {if $errorField == username}
                        <small class="innerError">
                            {if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
                            {if $errorType == 'notValid'}{lang}tourneysystem.tourney.referee.username.error.notValid{/lang}{/if}
                            {if $errorType == 'notUnique'}{lang}tourneysystem.tourney.referee.username.error.notUnique{/lang}{/if}
                        </small>
                    {/if}
                </dd>
            </dl>

        </fieldset>

    </div>

    <div class="formSubmit">
        <input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
        {@SECURITY_TOKEN_INPUT_TAG}
    </div>
</form>

<script data-relocate="true">
    $(function() {
        new WCF.Search.User($('#username'), function(data) {
            $('#username').val(data.label);//.focus();
        });
    });
</script>

{include file='footer' sandbox=false}
</body>
</html>
