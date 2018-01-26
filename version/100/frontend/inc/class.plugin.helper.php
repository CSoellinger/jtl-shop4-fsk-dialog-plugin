<?php
/**
 * Simple FSK landing warning plugin.
 * Show a dialog or a landing page before user can enter.
 *
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 */

class pluginHelper {

    /**
     * @var null|pluginHelper Self instance
     */
    private static $_instance = null;

    /**
     * @var null|Plugin Plugin instance
     */
    private $plugin = null;

    /**
     * @var null|Smarty Smarty instance
     */
    private $smarty = null;

    /**
     * @var string Cookie name
     */
    const COOKIE_NAME = 'JTLFSKPCACC';

    /**
     * @var int Cookie lifetime (default 30 days)
     */
    const COOKIE_EXTRA_LIFETIME = 60 * 60 * 24 * 30;

    /**
     * @var string Value if fsk warning accepted
     */
    const COOKIE_VALUE_ACCEPT = 'Y';

    /**
     * @var string Value if fsk warning is declined
     */
    const COOKIE_VALUE_DECLINE = 'N';

    /**
     * @var null|String Cookie value
     */
    protected $cookie = null;

    /**
     * @var null|Array Cookie settings like lifetime, domain,...
     */
    protected $cookieSettings = null;

    /**
     * constructor
     * 
     * @param Plugin $oPlugin
     */
    public function __construct(Plugin $oPlugin) {
        $this->plugin = $oPlugin;
        $this->smarty = Shop::Smarty();

        $this->initCookie();
    }

    /**
     * singleton getter
     * 
     * @param Plugin $oPlugin
     * @return pluginHelper
     */
    public static function getInstance(Plugin $oPlugin) {
        return (self::$_instance === null) ? new self($oPlugin) : self::$_instance;
    }

    /**
     * Initialize cookie and cookie settings
     * 
     * @return pluginHelper
     */
    private function initCookie() {
        // Set cookie settings like lifetime,..
        if ($this->cookieSettings === null) {
            $conf = Shop::getConfig(array(CONF_GLOBAL));
            $cookieDefaults = session_get_cookie_params();

            $lifetime = intval($conf['global']['global_cookie_lifetime'] || $cookieDefaults['lifetime'] || 0);
            $path = $conf['global']['global_cookie_path'] || $cookieDefaults['path'] || '';
            $domain = $cookieDefaults['domain'] || '';
            $secure = ($conf['global']['global_cookie_secure'] === 'Y') || $cookieDefaults['secure'] || false;
            $httpOnly = ($conf['global']['global_cookie_httponly'] === 'Y') || $cookieDefaults['httponly'] || false;

            $this->cookieSettings = array(
                'lifetime' => $lifetime + (self::COOKIE_EXTRA_LIFETIME > 0 ? time() + self::COOKIE_EXTRA_LIFETIME : 0),
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
     * @return pluginHelper
     */
    public function writeCookie($value = null) {
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
    public function fskAccept() {
        return ($this->cookie === self::COOKIE_VALUE_ACCEPT);
    }

    /**
     * Check if FSK is declined.
     * 
     * @return boolean
     */
    public function fskDecline() {
        return ($this->cookie === self::COOKIE_VALUE_DECLINE);
    }

    /**
     * Assign values to smarty
     *
     * @return pluginHelper
     */
    public function assignSmartyValues() {
        $min_age = (int) $this->getConfig('min_age');
        $show_text = (int) $this->getConfig('text');

        $text = '';

        if ($show_text === 1) {
            $text = gibAGBWRB(Shop::$kSprache, 1)->cAGBContentHtml;
        }

        if ($show_text === 2) {
            $text = htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('text')));
        }

        $this->smarty->assign('txt_fsk_pc_headline', htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('headline'))));
        $this->smarty->assign('txt_fsk_pc_label_birthdate', htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('label_birthdate'))));
        $this->smarty->assign('txt_fsk_pc_placeholder_day', htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('placeholder_day'))));
        $this->smarty->assign('txt_fsk_pc_placeholder_month', htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('placeholder_month'))));
        $this->smarty->assign('txt_fsk_pc_placeholder_year', htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('placeholder_year'))));
        $this->smarty->assign('txt_fsk_pc_text', $text);
        $this->smarty->assign('txt_fsk_pc_btn_accept', htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('btn_accept'))));

        if ($show_text === 1) {
            $this->smarty->assign('txt_fsk_pc_btn_accept_agb', ($this->getLangVar('btn_accept_agb') ? ' ' : '') . htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('btn_accept_agb'))));
        }

        $this->smarty->assign('txt_fsk_pc_btn_decline', htmlentities(str_replace('{MIN_AGE}', $min_age, $this->getLangVar('btn_decline'))));

        $this->smarty->assign('min_age', $min_age);
        $this->smarty->assign('decline_url', $this->getConfig('decline_url'));
        $this->smarty->assign('ajax_submit', ($this->getConfig('ajax_submit') === "on"));
        $this->smarty->assign('check_birthdate', ($this->getConfig('check_birthdate') === "on"));
        $this->smarty->assign('max_birthdate_year', date('Y') - $min_age);
        
        $this->smarty->assign('COOKIE_VALUE_ACCEPT', self::COOKIE_VALUE_ACCEPT);

        return $this;
    }

    /**
     * Inserts a dialog into the dom.
     *
     * @return pluginHelper $this
     */
    public function insertDialog() {
        $tpl = $this->plugin->cFrontendPfad . 'template/dialog.tpl';
        $html = $this->smarty->fetch($tpl);

        pq('#main-wrapper')->after($html);

        return $this;
    }

    /**
     * Inserts a landing page into the dom.
     *
     * @return pluginHelper $this
     */
    public function insertLandingPage() {
        $tpl = $this->plugin->cFrontendPfad . 'template/landing_page.tpl';
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
     * Get a language variable
     *
     * @param String $langVar
     * @return void
     */
    public function getLangVar($langVar) {
        return $this->plugin->oPluginSprachvariableAssoc_arr['xmlp_lang_pc_fsk_' . $langVar];
    }

    /**
     * Get a config variable
     *
     * @param String $cfg
     * @return void
     */
    public function getConfig($cfg) {
        return $this->plugin->oPluginEinstellungAssoc_arr['pixelcrab_fsk_' . $cfg];
    }

}
