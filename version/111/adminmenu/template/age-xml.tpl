<?xml version="1.0" encoding="UTF-8" standalone="yes"?>

<age-declaration>

    <ageblock-basic>
        <age-issuer>{$agexml_issuer}</age-issuer>
        <last-change>{$smarty.now|date_format:"%Y-%m-%d"}</last-change>
        <country>{$agexml_country}</country>
        <label-version>2.0</label-version>
        <revisit-after>{$cookie_lifetime_d}days</revisit-after>
    </ageblock-basic>

    <ageblock-country>
        <country class="age.xml">
            <country-code>all</country-code>
        </country>
        <country-default>age.xml</country-default>
    </ageblock-country>

    <ageblock-labeltype>
        <httpheader>{$using_http_header}</httpheader>
        <htmlmeta>{$using_html_meta}</htmlmeta>
        <phraselabel>false</phraselabel>
        <agesubmit>{$using_birthdate_input}</agesubmit>
        <label-z>{$using_label_z}</label-z>
        <xmlfile>true</xmlfile>
        <default-age>{$min_age}</default-age>

        {if $decline_url !== ''}<alternate>{$decline_url}</alternate>{/if}

    </ageblock-labeltype>

    <ageblock-labeltype-definition>

        {if $using_http_header === 'true'}
        <labeltype-httpheader-definition>
            <label class="name1">
                {include file="./inc/scope-xml.tpl" mainScope=$agexml_shop_scope scopeArr=$age_xml_extra_scopes}
            </label>
        </labeltype-httpheader-definition>
        {/if}

        {if $using_html_meta === 'true'}
        <labeltype-htmlmeta-definition>
            <label class="name1">
                {include file="./inc/scope-xml.tpl" mainScope=$agexml_shop_scope scopeArr=$age_xml_extra_scopes}
            </label>
        </labeltype-htmlmeta-definition>
        {/if}

        {if $using_label_z === 'true'}
        <labeltype-label-z-definition>
            <label class="default">
                <min-age>{$min_age}</min-age>
            </label>
            <label class="label-z">
                <label-z-type>all</label-z-type>

                {include file="./inc/scope-xml.tpl" mainScope=$agexml_shop_scope scopeArr=$age_xml_extra_scopes}

                <min-age>{$min_age}</min-age>
            </label>
        </labeltype-label-z-definition>
        {/if}

        <labeltype-xmlfile>
            <label class="website">
                <age>{$min_age}</age>
                {include file="./inc/scope-xml.tpl" mainScope=$agexml_shop_scope scopeArr=$age_xml_extra_scopes}
            </label>

            {include file="./inc/content-desc-xml.tpl" agexml_content_desc=$agexml_content_desc agexml_content_desc_extra=$agexml_content_desc_extra}

            {include file="./inc/feature-desc-xml.tpl" agexml_feature_desc=$agexml_feature_desc agexml_feature_desc_extra=$agexml_feature_desc_extra}

        </labeltype-xmlfile>

    </ageblock-labeltype-definition>
</age-declaration>
