{if !empty($agexml_content_desc) || !empty($agexml_content_desc_extra)}
<content-descriptors>
    
    {if !empty($agexml_content_desc)}
    {foreach from=$agexml_content_desc item=$item key=$key}
        {if !empty($item)}
        <cd-{$item}>
            <cd-{$item}-exist>true</cd-{$item}-exist>
            <cd-{$item}-desc></cd-{$item}-desc>
            <cd-{$item}-icon></cd-{$item}-icon>
        </cd-{$item}>
        {/if}
    {/foreach}
    {/if}

    {if !empty($agexml_content_desc_extra)}
    {foreach from=$agexml_content_desc_extra item=$item key=$key}
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
