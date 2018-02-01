<?xml version="1.0" encoding="UTF-8" standalone="yes"?>

<age-declaration>

    <ageblock-basic>
        <age-issuer>{$pcfwl_agexml_issuer}</age-issuer>
        <last-change>{$smarty.now|date_format:"%Y-%m-%d"}</last-change>
        <country>{$pcfwl_agexml_country}</country>
        <label-version>2.0</label-version>
        <revisit-after>{$pcfwl_cookie_lifetime_d}days</revisit-after>
    </ageblock-basic>

    <ageblock-country>
        <country class="age.xml">
            <country-code>all</country-code>
        </country>
        <country-default>age.xml</country-default>
    </ageblock-country>

    <ageblock-labeltype>
        <httpheader>{$pcfwl_using_http_header}</httpheader>
        <htmlmeta>{$pcfwl_using_html_meta}</htmlmeta>
        <phraselabel>false</phraselabel>
        <agesubmit>{$pcfwl_using_birthdate_input}</agesubmit>
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
            <label class="website">
                <age>{$pcfwl_min_age}</age>
                {include
                    file="./inc/pcfwl_scope-xml.tpl"
                    pcfwl_mainScope=$pcfwl_agexml_shop_scope
                    pcfwl_scopeArr=$pcfwl_age_xml_extra_scopes
                }
            </label>

            {include
                file="./inc/pcfwl_content-desc-xml.tpl"
                pcfwl_agexml_content_desc=$pcfwl_agexml_content_desc
                pcfwl_agexml_content_desc_extra=$pcfwl_agexml_content_desc_extra
            }

            {include
                file="./inc/pcfwl_feature-desc-xml.tpl"
                pcfwl_agexml_feature_desc=$pcfwl_agexml_feature_desc
                pcfwl_agexml_feature_desc_extra=$pcfwl_agexml_feature_desc_extra
            }

        </labeltype-xmlfile>

    </ageblock-labeltype-definition>
</age-declaration>
