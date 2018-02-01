<?xml version="1.0" encoding="UTF-8" standalone="yes"?>

<age-declaration>

    <ageblock-basic>
        <age-issuer>{$pcfwl_agexml_issuer}</age-issuer>
        <last-change>{$smarty.now|date_format:"%Y-%m-%d"}</last-change>
        <country>{$pcfwl_agexml_country}</country>
        <label-version>1.0</label-version>
        <revisit-after>{$pcfwl_cookie_lifetime_d}days</revisit-after>
    </ageblock-basic>

    <ageblock-labeltype>
        <httpheader>{$pcfwl_using_http_header}</httpheader>
        <htmlmeta>{$pcfwl_using_html_meta}</htmlmeta>
        <label-z>{$pcfwl_using_label_z}</label-z>
        <xmlfile>true</xmlfile>
        <default-age>{$pcfwl_min_age}</default-age>

        {if $pcfwl_decline_url !== ''}
            <alternate>{$pcfwl_decline_url}</alternate>
        {/if}

    </ageblock-labeltype>

    <ageblock-labeltype-definition>

        {if $pcfwl_using_http_header === 'true'}
        <labeltype-httpheader-definition>
            <label class="name1">
                {include
                    file="./inc/pcfwl_scope-xml.tpl"
                    pcfwl_mainScope=$pcfwl_agexml_shop_scope
                    pcfwl_scopeArr=$pcfwl_age_xml_extra_scopes
                }
            </label>
        </labeltype-httpheader-definition>
        {/if}

        {if $pcfwl_using_html_meta === 'true'}
        <labeltype-htmlmeta-definition>
            <label class="name1">
                {include
                    file="./inc/pcfwl_scope-xml.tpl"
                    pcfwl_mainScope=$pcfwl_agexml_shop_scope
                    pcfwl_scopeArr=$pcfwl_age_xml_extra_scopes
                }
            </label>
        </labeltype-htmlmeta-definition>
        {/if}

        {if $pcfwl_using_label_z === 'true'}
        <labeltype-label-z-definition>
            <label class="default">
                <min-age>{$pcfwl_min_age}</min-age>
            </label>
            <label class="label-z">
                <label-z-type>all</label-z-type>
                {include
                    file="./inc/pcfwl_scope-xml.tpl"
                    pcfwl_mainScope=$pcfwl_agexml_shop_scope
                    pcfwl_scopeArr=$pcfwl_age_xml_extra_scopes
                }
                {* <min-age>{$min_age}</min-age> *}
            </label>
        </labeltype-label-z-definition>
        {/if}

        <labeltype-xmlfile>
          <label class="default">
            <min-age>0</min-age>
            <default-age>{$pcfwl_min_age}</default-age>
          </label>
          <label class="website">
            <age>{$pcfwl_min_age}</age>
            <min-age>0</min-age>
            <default-age>{$pcfwl_min_age}</default-age>
            {include
                file="./inc/pcfwl_scope-xml.tpl"
                pcfwl_mainScope=$pcfwl_agexml_shop_scope
                pcfwl_scopeArr=$pcfwl_age_xml_extra_scopes
            }
          </label>
        </labeltype-xmlfile>

    </ageblock-labeltype-definition>

</age-declaration>
