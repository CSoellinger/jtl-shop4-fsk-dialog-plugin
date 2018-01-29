<?xml version="1.0" encoding="utf-8"?>
<label xmlns="http://www.miracle-label.eu/ns/2.0/">
    <age-declaration>
        <issuer>
            <age-issuer>{$agexml_issuer}</age-issuer>
            <last-change>{$smarty.now|date_format:"%Y-%m-%d"}</last-change>
            <country>
                <country-code>all</country-code>
            </country>
            <custom></custom>
        </issuer>
        <scope>
            <scope-urls>
                {include file="./inc/scope-xml.tpl" mainScope=$agexml_shop_scope scopeArr=$age_xml_extra_scopes scopeUrl=true}
            </scope-urls>
        </scope>
        <rating>
            <age>{$min_age}</age>
        </rating>

        {include file="./inc/content-desc-xml.tpl" agexml_content_desc=$agexml_content_desc agexml_content_desc_extra=$agexml_content_desc_extra}

        {include file="./inc/feature-desc-xml.tpl" agexml_feature_desc=$agexml_feature_desc agexml_feature_desc_extra=$agexml_feature_desc_extra}

    </age-declaration>
</label>
