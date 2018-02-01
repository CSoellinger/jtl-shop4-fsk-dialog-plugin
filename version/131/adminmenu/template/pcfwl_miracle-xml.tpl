<?xml version="1.0" encoding="utf-8"?>
<label xmlns="http://www.miracle-label.eu/ns/2.0/">
    <age-declaration>
        <issuer>
            <age-issuer>{$pcfwl_agexml_issuer}</age-issuer>
            <last-change>{$smarty.now|date_format:"%Y-%m-%d"}</last-change>
            <country>
                <country-code>all</country-code>
            </country>
            <custom></custom>
        </issuer>
        <scope>
            <scope-urls>
                {include 
                    file="./inc/pcfwl_scope-xml.tpl"
                    pcfwl_mainScope=$pcfwl_agexml_shop_scope 
                    pcfwl_scopeArr=$pcfwl_age_xml_extra_scopes
                    pcfwl_scopeUrl=true
                }
            </scope-urls>
        </scope>
        <rating>
            <age>{$min_age}</age>
        </rating>

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

    </age-declaration>
</label>
