<div class="{$css_prefix}content fsk-info-content">
    <div class="{$css_prefix}header">
        <h4 class="{$css_prefix}title" id="fskPixelCrabModalLabel">{$txt_fsk_pc_headline}</h4>
    </div>
    <div class="{$css_prefix}body">
        <div class="{$css_prefix}body-content{if $check_birthdate} birthdate-next{/if}">{$txt_fsk_pc_text}</div>
    </div>

    <form id="pixelcrabFskForm" action="//{$smarty.server.HTTP_SCHEMA}{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}?acceptFsk={$COOKIE_VALUE_ACCEPT}" method="post">
        {if $check_birthdate}
        <div class="{$css_prefix}footer">
            
            <div class="row birthdate-container">
                <div class="col-xs-12">
                    {$txt_fsk_pc_label_birthdate}
                </div>
                <div class="col-xs-12">
                    <input name="day" type="number" placeholder="{$txt_fsk_pc_placeholder_day}" min="on" max="31" maxlength="2" style="width: 50px; text-align: center;" /> 
                    <input name="month" type="number" placeholder="{$txt_fsk_pc_placeholder_month}" min="on" max="12" maxlength="2" style="width: 50px; text-align: center;" /> 
                    <input name="year" type="number" placeholder="{$txt_fsk_pc_placeholder_year}" min="1900" max="{$max_birthdate_year}" maxlength="4" style="width: 70px; text-align: center;" /> 
                </div>
            </div>
        </div>
        {/if}

        <div class="{$css_prefix}footer">
            <div class="row">
                <div class="col-xs-12 col-sm-4 text-left margin-for-mobile">
                    <a class="btn btn-danger" href="{if $decline_url !== ''}{$decline_url}{else}javascript:window.close();{/if}">{$txt_fsk_pc_btn_decline}</a>
                </div>
                <div class="col-xs-12 col-sm-8 text-right">
                    <button type="submit" class="btn btn-success{$ajax_accept}">{$txt_fsk_pc_btn_accept}{$txt_fsk_pc_btn_accept_agb}</button>
                </div>

                <input type="hidden" name="minAge" value="{$min_age}" />

                {if $css_prefix == 'modal-'}
                <input type="hidden" name="ajaxSubmit" value="{$ajax_submit}" />
                {/if}

            </div>
        </div>
    </form>
</div>
