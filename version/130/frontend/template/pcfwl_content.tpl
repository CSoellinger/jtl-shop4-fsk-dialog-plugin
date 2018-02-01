<div class="{$pcfwl_css_prefix}content fsk-info-content">
    <div class="{$pcfwl_css_prefix}header">
        <h4 class="{$pcfwl_css_prefix}title" id="pcfwlModalLabel">
            {$pcfwl_txt_headline}
        </h4>
    </div>
    <div class="{$pcfwl_css_prefix}body">
        <div class="{$pcfwl_css_prefix}body-content{if $pcfwl_check_birthdate} birthdate-next{/if}">
            {$pcfwl_txt_text}
        </div>
    </div>

    <form action="//{$smarty.server.HTTP_SCHEMA}{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}?acceptFsk={$pcfwl_COOKIE_VALUE_ACCEPT}" method="post">
        {if $pcfwl_check_birthdate}
        <div class="{$pcfwl_css_prefix}footer">
            
            <div class="row birthdate-container">
                <div class="col-xs-12">
                    {$pcfwl_txt_label_birthdate}
                </div>
                <div class="col-xs-12">
                    <input name="day" type="number" placeholder="{$pcfwl_txt_placeholder_day}" min="1" max="31" maxlength="2" /> 
                    <input name="month" type="number" placeholder="{$pcfwl_txt_placeholder_month}" min="1" max="12" maxlength="2" /> 
                    <input name="year" type="number" placeholder="{$pcfwl_txt_placeholder_year}" min="1900" max="{$pcfwl_max_birthdate_year}" maxlength="4" /> 
                </div>
            </div>
        </div>
        {/if}

        <div class="{$pcfwl_css_prefix}footer">
            <div class="row">
                <div class="col-xs-12 col-sm-4 text-left margin-for-mobile">
                    <a class="btn btn-danger" href="{if $pcfwl_decline_url !== ''}{$pcfwl_decline_url}{else}https://de.wikipedia.org/wiki/Jugendschutzgesetz{/if}">
                        {$pcfwl_txt_btn_decline}
                    </a>
                </div>
                <div class="col-xs-12 col-sm-8 text-right">
                    <button type="submit" class="btn btn-success{$pcfwl_ajax_accept}">
                        {$pcfwl_txt_btn_accept}{$pcfwl_txt_btn_accept_agb}
                    </button>
                </div>

                <input type="hidden" name="minAge" value="{$pcfwl_min_age}" />

                {if $pcfwl_css_prefix == 'modal-'}
                <input type="hidden" name="ajaxSubmit" value="{$pcfwl_ajax_submit}" />
                {/if}

            </div>
        </div>
    </form>
</div>
