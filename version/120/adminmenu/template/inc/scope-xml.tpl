<scope{if $scopeUrl === true}-url class="web-url"{/if}>{$mainScope}</scope{if $scopeUrl === true}-url{/if}>

{if !empty($scopeArr) && !empty(join("", scopeArr))}
{foreach from=$scopeArr item=$item key=$key}
    {if !empty($item)}
    <scope{if $scopeUrl === true}-url class="web-url"{/if}>{$item}</scope{if $scopeUrl === true}-url{/if}>
    {/if}
{/foreach}
{/if}
