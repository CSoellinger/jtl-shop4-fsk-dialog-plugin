{if !empty($pcfwl_agexml_feature_desc) || !empty($pcfwl_agexml_feature_desc_extra)}
<feature-descriptors>

    {if !empty($pcfwl_agexml_content_desc)}
    {foreach from=$pcfwl_agexml_feature_desc item=$item key=$key}
        {if !empty($item)}
        <fd-{$item}>
            <fd-{$item}-exist>true</fd-{$item}-exist>
            <fd-{$item}-desc></fd-{$item}-desc>
            <fd-{$item}-icon></fd-{$item}-icon>
        </fd-{$item}>
        {/if}
    {/foreach}
    {/if}

    {if !empty($pcfwl_agexml_feature_desc_extra)}
    {foreach from=$pcfwl_agexml_feature_desc_extra item=$item key=$key}
        {if !empty($itemt)}
        <fd-other>
            <fd-add class="{$item}">
                <fd-add-exist>true</fd-add-exist>
                <fd-add-icon></fd-add-icon>
            </fd-add>
        </fd-other>
        {/if}
    {/foreach}
    {/if}

</feature-descriptors>
{/if}
