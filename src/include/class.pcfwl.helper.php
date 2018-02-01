<?php
/**
 * Plugin helper with all the magic. Write cookie, parse dialog and much more.
 *
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 */

class pcfwlHelper
{

    /**
     * @var null|pcfwlHelper Self instance
     */
    private static $_instance = null;

    /**
     * @var null|Plugin Plugin instance
     */
    private $plugin = null;

    /**
     * @var null|JTLSmarty Smarty instance
     */
    private $smarty = null;

    /**
     * @var String Cookie name
     */
    const COOKIE_NAME = 'JTLFSKACC';

    /**
     * @var Number Cookie lifetime (default 30 days if global setting is 0)
     */
    const COOKIE_EXTRA_LIFETIME = 60 * 60 * 24 * 30;

    /**
     * @var String Value if fsk warning accepted
     */
    const COOKIE_VALUE_ACCEPT = 'Y';

    /**
     * @var String Value if fsk warning is declined
     */
    const COOKIE_VALUE_DECLINE = 'N';

    /**
     * @var null|String Cookie value
     */
    private $cookie = null;

    /**
     * @var null|Array Cookie settings like lifetime, domain,...
     */
    private $cookieSettings = null;

    /**
     * constructor
     * 
     * @param Plugin $oPlugin
     * @param JTLSmarty $smarty
     */
    public function __construct(Plugin $oPlugin, JTLSmarty $smarty)
    {
        $this->plugin = $oPlugin;
        $this->smarty = $smarty;
        
        $this->initCookie();
    }
    
    /**
     * singleton getter
     * 
     * @param Plugin $oPlugin
     * @param JTLSmarty $smarty
     * @return pcfwlHelper
     */
    public static function getInstance(Plugin $oPlugin, JTLSmarty $smarty)
    {
        return (self::$_instance === null) ? new self($oPlugin, $smarty) : self::$_instance;
    }

    /**
     * Initialize cookie and cookie settings
     * 
     * @return pcfwlHelper $this
     */
    private function initCookie()
    {
        // Set cookie settings like lifetime,..
        if ($this->cookieSettings === null) {
            $conf = Shop::getConfig(array(CONF_GLOBAL));
            $cookieDefaults = session_get_cookie_params();

            if ($conf['global']['global_cookie_path']) {
                $path = $conf['global']['global_cookie_path'];
            }
            if (!$path && $cookieDefaults['path']) {
                $path = $cookieDefaults['path'];
            }
            if (!$path) {
                $path = '/';
            }

            $domain = '';
            if (!$domain && $conf['global']['global_cookie_domain']) {
                $domain = $conf['global']['global_cookie_domain'];
            }
            if (!$domain && $cookieDefaults['domain']) {
                $domain = $cookieDefaults['domain'];
            }

            $secure = false;
            if (!$secure && $conf['global']['global_cookie_secure']) {
                $secure = true;
            }
            if (!$secure && $cookieDefaults['secure']) {
                $secure = true;
            }
            
            $httpOnly = false;
            if (!$httpOnly && $conf['global']['global_cookie_httponly']) {
                $httpOnly = $conf['global']['global_cookie_httponly'] ? true : false;
            }
            if (!$httpOnly && $cookieDefaults['httponly']) {
                $httpOnly = $cookieDefaults['httponly'] ? true : false;
            }

            $lifetime = time() + $this->getCookieLifetime();

            $this->cookieSettings = array(
                'lifetime' => $lifetime,
                'domain' => $domain,
                'path' => $path,
                'secure' => $secure,
                'httpOnly' => $httpOnly
            );
        }

        // Read existing cookie value
        $this->cookie = filter_input(INPUT_COOKIE, self::COOKIE_NAME, FILTER_DEFAULT);
        // If there is no cookie create one by default with decline value
        if ($this->cookie !== self::COOKIE_VALUE_ACCEPT && $this->cookie !== self::COOKIE_VALUE_DECLINE) {
            $this->writeCookie(self::COOKIE_VALUE_DECLINE);
        }
        
        return $this;
    }
    
    /**
     * Write value into cookie
     * 
     * @return pcfwlHelper $this
     */
    public function writeCookie($value = null)
    {
        setcookie(
            self::COOKIE_NAME,
            $value,
            $this->cookieSettings['lifetime'],
            $this->cookieSettings['path'],
            $this->cookieSettings['domain'],
            $this->cookieSettings['secure'],
            $this->cookieSettings['httpOnly']
        );

        $this->cookie = $value;

        return $this;
    }

    /**
     * Check if FSK is accepted.
     * 
     * @return boolean
     */
    public function fskAccept()
    {
        return ($this->cookie === self::COOKIE_VALUE_ACCEPT);
    }

    /**
     * Check if FSK is declined.
     * 
     * @return boolean
     */
    public function fskDecline()
    {
        return ($this->cookie === self::COOKIE_VALUE_DECLINE);
    }

    /**
     * Get cookie lifetime in seconds. If global value is 0 it will use a 30days value from this class.
     *
     * @return pcfwlHelper $this
     */
    public function getCookieLifetime()
    {
        $conf = Shop::getConfig(array(CONF_GLOBAL));
        $cookieDefaults = session_get_cookie_params();

        $lifetime = 0;

        if ($conf['global']['global_cookie_lifetime']) {
            $lifetime = $conf['global']['global_cookie_lifetime'];
        }

        if (!$lifetime && $cookieDefaults['lifetime']) {
            $lifetime = $cookieDefaults['lifetime'];
        }

        // If lifetime is 0
        if ($lifetime === 0) {
            $lifetime = self::COOKIE_EXTRA_LIFETIME;
        }

        return $lifetime;
    }

    /**
     * Assign values to smarty
     *
     * @return pcfwlHelper $this
     */
    public function assignSmartyValues()
    {
        $min_age = (int)$this->getConfig('min_age');
        $show_text = (int)$this->getConfig('text');

        $text = '';

        if ($show_text === 1) {
            $text = gibAGBWRB(Shop::$kSprache, 1)->cAGBContentHtml;
        }

        if ($show_text === 2) {
            $text = htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('text')));
        }

        $this->smarty->assign('pcfwl_txt_headline', htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('headline'))));
        $this->smarty->assign('pcfwl_txt_label_birthdate', htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('label_birthdate'))));
        $this->smarty->assign('pcfwl_txt_placeholder_day', htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('placeholder_day'))));
        $this->smarty->assign('pcfwl_txt_placeholder_month', htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('placeholder_month'))));
        $this->smarty->assign('pcfwl_txt_placeholder_year', htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('placeholder_year'))));
        $this->smarty->assign('pcfwl_txt_text', $text);
        $this->smarty->assign('pcfwl_txt_btn_accept', htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('btn_accept'))));

        if ($show_text === 1) {
            $this->smarty->assign('pcfwl_txt_btn_accept_agb', ($this->getLangVar('btn_accept_agb') ? ' ' : '') . htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('btn_accept_agb'))));
        }

        $this->smarty->assign('pcfwl_txt_btn_decline', htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('btn_decline'))));

        $this->smarty->assign('pcfwl_min_age', $min_age);
        $this->smarty->assign('pcfwl_decline_url', $this->getConfig('decline_url'));
        $this->smarty->assign('pcfwl_ajax_submit', ($this->getConfig('ajax_submit') === 'on'));
        $this->smarty->assign('pcfwl_check_birthdate', ($this->getConfig('check_birthdate') === 'on'));
        $this->smarty->assign('pcfwl_max_birthdate_year', date('Y') - $min_age);

        $this->smarty->assign('pcfwl_shop_url', Shop::getURL());

        $this->smarty->assign('pcfwl_COOKIE_VALUE_ACCEPT', self::COOKIE_VALUE_ACCEPT);

        return $this;
    }

    /**
     * Assign XML relevant values to smarty
     *
     * @param String $exportCountry Default is "de"
     * @return pcfwlHelper $this
     */
    public function assignXmlSmartyValues($exportCountry = 'de')
    {
        $this->smarty->assign('pcfwl_agexml_issuer', $this->getConfig('agexml_issuer'));

        $this->smarty->assign('pcfwl_agexml_country', $exportCountry);
        $this->smarty->assign('pcfwl_agexml_shop_scope', preg_replace('/http[s]?:\/\//', '', Shop::getURL()) . '/*');

        if ($this->getConfig('agexml_extra_scopes')) {
            $this->smarty->assign('pcfwl_age_xml_extra_scopes', split(';', $this->getConfig('agexml_extra_scopes')));
        }

        $this->smarty->assign('pcfwl_using_http_header', $this->getConfig('header_content_age') === 'on' ? 'true' : 'false');
        $this->smarty->assign('pcfwl_using_html_meta', $this->getConfig('insert_meta') === 'on' ? 'true' : 'false');
        $this->smarty->assign('pcfwl_using_label_z', $this->getConfig('agexml_insert_label_z') === 'on' ? 'true' : 'false');
        $this->smarty->assign('pcfwl_using_landing_page_or_dialog', $this->getConfig('show_landing_page') === 'on' || $this->getConfig('show_dialog') === 'on' ? 'true' : 'false');
        $this->smarty->assign('pcfwl_using_birthdate_input', $this->getConfig('check_birthdate') === 'on' ? 'true' : 'false');

        $this->smarty->assign('pcfwl_cookie_lifetime_d', floor($this->getCookieLifetime() / (24 * 60 * 60)));

        if (count($this->getConfig('agexml_content_desc')) > 0 && join('', $this->getConfig('agexml_content_desc')) !== '') {
            $this->smarty->assign('pcfwl_agexml_content_desc', $this->getConfig('agexml_content_desc'));
        }

        $content_desc_extra = split(';', strtolower($this->getConfig('agexml_content_desc_extra')));
        if (count($content_desc_extra) > 0 && join('', $content_desc_extra) !== '') {
            $this->smarty->assign('pcfwl_agexml_content_desc_extra', $content_desc_extra);
        }

        if (count($this->getConfig('agexml_feature_desc')) > 0 && join('', $this->getConfig('agexml_feature_desc')) !== '') {
            $this->smarty->assign('pcfwl_agexml_feature_desc', $this->getConfig('agexml_feature_desc'));
        }

        $feature_desc_extra = split(';', strtolower($this->getConfig('agexml_feature_desc_extra')));
        if (count($featuer_desc_extra) > 0 && join('', $featuer_desc_extra) !== '') {
            $this->smarty->assign('pcfwl_agexml_feature_desc_extra', $feature_desc_extra);
        }

        return $this;
    }

    /**
     * Inserts a dialog into the dom.
     *
     * @return pcfwlHelper $this
     */
    public function insertDialog()
    {
        $tpl = $this->plugin->cFrontendPfad . 'template/pcfwl_dialog.tpl';
        $html = $this->smarty->fetch($tpl);

        pq('#main-wrapper')->before($html);

        return $this;
    }

    /**
     * Inserts a landing page into the dom.
     *
     * @return pcfwlHelper $this
     */
    public function insertLandingPage()
    {
        $tpl = $this->plugin->cFrontendPfad . 'template/pcfwl_landing_page.tpl';
        $html = $this->smarty->fetch($tpl);

        if ($this->getConfig('hide_page_header') == 'on') {
            pq('header')->remove();
        }

        if ($this->getConfig('hide_page_nav') == 'on') {
            pq('nav')->remove();
        }

        if ($this->getConfig('hide_page_aside') == 'on') {
            pq('aside')->remove();
            pq('#content')->replaceWith('<div id="content" class="col-xs-12">');
        }

        if ($this->getConfig('hide_page_footer') == 'on') {
            pq('footer')->remove();
        }

        pq('#main-wrapper #content-wrapper #content')->empty()->append($html);

        return $this;
    }

    /**
     * Insert age meta tags
     *
     * @return pcfwlHelper $this
     */
    public function insertMetaTags() {
        pq('head')
            ->prepend('<meta name="age-de-meta-label" content="age=' . $this->getConfig('min_age') . ' hash: ' . $this->getContentAgeHash() . ' v=1.0 kind=sl protocol=all" />')
            ->prepend('<meta name="age-meta-label" content="age=' . $this->getConfig('min_age') . '" />');

        return $this;
    }

    /**
     * Set content age header
     *
     * @return pcfwlHelper $this
     */
    public function setContentAgeHeader() {
        header('X-content-age: "' . $this->getConfig('min_age') . '"');
        return $this;
    }

    /**
     * Set age hash header
     *
     * @return pcfwlHelper $this
     */
    public function setAgeHashHeader() {
        header('X-age-hash: "' . $this->getContentAgeHash() . '"');
        return $this;
    }

    /**
     * Get age hash which is a md5 hash generated from SERVER_ADDR and plugin install date.
     *
     * @return String
     */
    public function getContentAgeHash() {
        return md5(filter_input(INPUT_SERVER, 'SERVER_ADDR') . $this->plugin->dInstalliert);
    }

    /**
     * Fetch XML Template with smarty and return html code
     *
     * @param String $xmlFile Which file to parse. We can give age.xml or age-de.xml and it will convert to age-xml,...
     * @return String XML file parsed from template
     */
    public function getXmlFromTpl($xmlFile)
    {
        if (!$xmlFile) {
            return '';
        }

        $tpl = $this->plugin->cFrontendPfad . '../adminmenu/template/pcfwl_' . str_replace('.xml', '-xml', $xmlFile) . '.tpl';
        $html = $this->smarty->fetch($tpl);

        return $html;
    }

    /**
     * Get a language variable
     *
     * @param String $langVar
     * @return String
     */
    public function getLangVar($langVar)
    {
        return $this->plugin->oPluginSprachvariableAssoc_arr['xmlp_lang_pcfwl_' . $langVar];
    }

    /**
     * Get a config variable
     *
     * @param String $cfg
     * @return String
     */
    public function getConfig($cfg)
    {
        return $this->plugin->oPluginEinstellungAssoc_arr['pcfwl_' . $cfg];
    }

}
