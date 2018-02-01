<scope{if $pcfwl_scopeUrl === true}-url class="web-url"{/if}>
    {$pcfwl_mainScope}
</scope{if $pcfwl_scopeUrl === true}-url{/if}>

{if !empty($pcfwl_scopeArr) && !empty(join("", $pcfwl_scopeArr))}
{foreach from=$pcfwl_scopeArr item=$item key=$key}
    {if !empty($item)}
    <scope{if $pcfwl_scopeUrl === true}-url class="web-url"{/if}>
        {$item}
    </scope{if $pcfwl_scopeUrl === true}-url{/if}>
    {/if}
{/foreach}
{/if}
