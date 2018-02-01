{if !empty($pcfwl_agexml_content_desc) || !empty($pcfwl_agexml_content_desc_extra)}
<content-descriptors>
    
    {if !empty($pcfwl_agexml_content_desc)}
    {foreach from=$pcfwl_agexml_content_desc item=$item key=$key}
        {if !empty($item)}
        <cd-{$item}>
            <cd-{$item}-exist>true</cd-{$item}-exist>
            <cd-{$item}-desc></cd-{$item}-desc>
            <cd-{$item}-icon></cd-{$item}-icon>
        </cd-{$item}>
        {/if}
    {/foreach}
    {/if}

    {if !empty($pcfwl_agexml_content_desc_extra)}
    {foreach from=$pcfwl_agexml_content_desc_extra item=$item key=$key}
        {if !empty($item)}
        <cd-other>
            <cd-add class="{$item}">
                <cd-add-exist>true</cd-add-exist>
                <cd-add-icon></cd-add-icon>
            </cd-add>
        </cd-other>
        {/if}
    {/foreach}
    {/if}

</content-descriptors>
{/if}
