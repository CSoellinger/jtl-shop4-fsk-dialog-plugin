<?php
/**
 * Insert meta tags, landing page and landing dialog if setting set
 *
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 * @global JTLSmarty $smarty
 * @global Plugin $oPlugin
 */

if (class_exists('Shop')) {
    require_once $oPlugin->cFrontendPfad . '../include/class.pcfwl.helper.php';
    $pcfwlHelper = pcfwlHelper::getInstance($oPlugin);

    // Insert meta tag if necessary
    if ($pcfwlHelper->getConfig('insert_meta') === 'on') {
        $pcfwlHelper->insertMetaTags();
    }

    $session = Session::getInstance();
    $isBot   = isset($_SERVER['HTTP_USER_AGENT'])
        ? $session::getIsCrawler($_SERVER['HTTP_USER_AGENT'])
        : false;

    // Don't show the warning to bots if its not allowed to them ;)
    if (!$isBot || ($isBot && $pcfwlHelper->getConfig('allow_bots') === 'on')) {
        // If we insert a dialog and/or a landing page we have to assign our smarty values
        if (($pcfwlHelper->getConfig('show_landing_page') === 'on' && $pcfwlHelper->fskAccept() === false) ||
        ($pcfwlHelper->getConfig('show_dialog') === 'on' && $pcfwlHelper->fskAccept() === false)) {
            $pcfwlHelper->assignSmartyValues();
        }
        
        // Insert landing page
        if ($pcfwlHelper->getConfig('show_landing_page') === 'on' && $pcfwlHelper->fskAccept() === false) {
            $pcfwlHelper->insertLandingPage();
        }
        
        // Insert dialog
        if ($pcfwlHelper->getConfig('show_dialog') === 'on' && $pcfwlHelper->fskAccept() === false) {
            $pcfwlHelper->insertDialog();
        }
    }
}
