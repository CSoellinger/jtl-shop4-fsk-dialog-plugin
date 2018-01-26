<div class="{$css_prefix}content fsk-info-content">
    <div class="{$css_prefix}header">
        <h4 class="{$css_prefix}title" id="fskPixelCrabModalLabel">{$txt_fsk_pc_headline}</h4>
    </div>
    <div class="{$css_prefix}body">
        <div class="{$css_prefix}body-content">{$txt_fsk_pc_text}</div>
    </div>

    <form id="pixelcrabFskForm" action="//{$smarty.server.HTTP_SCHEMA}{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}?acceptFsk={$COOKIE_VALUE_ACCEPT}" method="post">
        {if $check_birthdate}
        <div class="{$css_prefix}footer">
            
            <div class="birthdate-container" style="display: inline-block;">
                {$txt_fsk_pc_label_birthdate}<br />

                <input name="day" type="number" placeholder="{$txt_fsk_pc_placeholder_day}" min="1" max="31" maxlength="2" style="width: 50px; text-align: center;" /> 
                <input name="month" type="number" placeholder="{$txt_fsk_pc_placeholder_month}" min="1" max="12" maxlength="2" style="width: 50px; text-align: center;" /> 
                <input name="year" type="number" placeholder="{$txt_fsk_pc_placeholder_year}" min="1900" max="{$max_birthdate_year}" maxlength="4" style="width: 70px; text-align: center;" /> 
            </div>
        </div>
        {/if}

        <div class="{$css_prefix}footer">
            <a class="btn btn-danger" href="{$decline_url}">{$txt_fsk_pc_btn_decline}</a>
            <button type="submit" class="btn btn-success{$ajax_accept}">{$txt_fsk_pc_btn_accept}{$txt_fsk_pc_btn_accept_agb}</button>
            <input type="hidden" name="minAge" value="{$min_age}" />
                
            {if $css_prefix == 'modal-'}
            <input type="hidden" name="ajaxSubmit" value="{$ajax_submit}" />
            {/if}

        </div>
    </form>
</div>
