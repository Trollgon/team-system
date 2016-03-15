{include file='documentHeader'}

<head>
	<title>{if $__wcf->getPageMenu()->getLandingPage()->menuItem != 'tourneysystem.header.menu.index'}{lang}tourneysystem.header.menu.index{/lang} - {/if}{PAGE_TITLE|language}</title>
	
	{include file='headInclude' sandbox=false}
	
		<script data-relocate="true">
		//<![CDATA[
		$(function() {
			WCF.Language.addObject({
				'wcf.global.form.error.empty': '{lang}wcf.global.form.error.empty{/lang}',
				'wcf.user.username.error.notValid': '{lang}wcf.user.username.error.notValid{/lang}',
				'wcf.user.username.error.notUnique': '{lang}wcf.user.username.error.notUnique{/lang}',
			});
			
			new WCF.User.Registration.Validation.Username($('#{@$randomFieldNames[username]}', null, {
				minlength: {@REGISTER_USERNAME_MIN_LENGTH},
				maxlength: {@REGISTER_USERNAME_MAX_LENGTH}
			}));
		});
		//]]>
	</script>
	
	<style type="text/css">	
		#fieldset1 {
			display: none;
		}
	</style>
</head>

<body id="tpl{$templateName|ucfirst}">

{include file='header' sandbox=false}

<header class="boxHeadline">
		<h1>{lang}tourneysystem.header.addTeam{/lang}</h1>
</header>

{include file='userNotice'}

{include file='footer' sandbox=false}
</body>
</html>
