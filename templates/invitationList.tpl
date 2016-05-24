{include file='documentHeader'}

<head>
	<title>{if $__wcf->getPageMenu()->getLandingPage()->menuItem != 'teamsystem.header.menu.teams'}{lang}teamsystem.header.menu.teams{/lang} - {/if}{PAGE_TITLE|language}</title>
	
	{include file='headInclude' sandbox=false}
</head>



<body id="tpl{$templateName|ucfirst}">
{include file='header' sandbox=false}

<header class="boxHeadline">
	{if $__wcf->getPageMenu()->getLandingPage()->menuItem == 'teamsystem.header.menu.teams'}
		<h1>{PAGE_TITLE|language}</h1>
		{hascontent}<h2>{content}{PAGE_DESCRIPTION|language}{/content}</h2>{/hascontent}
	{else}
		<h1>{lang}teamsystem.header.menu.teams{/lang}</h1>
	{/if}
</header>

{include file='userNotice'}

{if $objects|count > 0}
	<div class="container marginTop">
		<ol class="containerList userList">
			{foreach from=$objects item=invitation}
  			   	{include file='invitationItem' application='teamsystem'}
			{/foreach}
		</ol>
	</div>
{else}
    <p class="info">{lang}teamsystem.team.invitations.noInvitations{/lang}</p>
{/if}

<div class="contentNavigation">
	{hascontent}
		<nav>
			<ul>
				{content}
					{event name='contentNavigationButtonsBottom'}
				{/content}
			</ul>
		</nav>
	{/hascontent}
</div>

{include file='footer'}

</body>
</html>





