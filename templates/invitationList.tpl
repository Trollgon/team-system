{capture assign='contentTitle'}{$__wcf->getActivePage()->getTitle()} <span class="badge">{#$items}</span>{/capture}

{include file='header'}

{if $objects|count > 0}
	<div class="section sectionContainerList">
		<ol class="containerList userList">
			{foreach from=$objects item=invitation}
  			   	{include file='invitationItem' application='teamsystem'}
			{/foreach}
		</ol>
	</div>
{else}
    <p class="info">{lang}teamsystem.team.invitation.noInvitations{/lang}</p>
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





