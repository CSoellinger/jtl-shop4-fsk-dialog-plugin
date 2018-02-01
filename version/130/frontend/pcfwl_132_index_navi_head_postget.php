<?php
/**
 * Check for FSK accept and send HTTP header if settings set.
 *
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 * @global JTLSmarty $smarty
 * @global Plugin $oPlugin
 */

if (class_exists('Shop')) {
    require_once $oPlugin->cFrontendPfad . '../include/class.pcfwl.helper.php';
    $pcfwlHelper = pcfwlHelper::getInstance($oPlugin);

    // Check if tFsk query string is set
    if (strtoupper(filter_input(INPUT_GET, 'acceptFsk', FILTER_SANITIZE_STRING)) === pcfwlHelper::COOKIE_VALUE_ACCEPT) {
        $pcfwlHelper->writeCookie(pcfwlHelper::COOKIE_VALUE_ACCEPT);

        if (filter_input(INPUT_POST, 'ajaxSubmit', FILTER_SANITIZE_STRING) === 1 && $pcfwlHelper->getConfig('pcfwl_ajax_submit')) {
            exit;
        }

        $url = str_replace(
            array(
                '?acceptFsk=' . $pcfwlHelper::COOKIE_VALUE_ACCEPT,
                '&acceptFsk=' . $pcfwlHelper::COOKIE_VALUE_ACCEPT
            ),
            '',
            Shop::getURL() . '/' . Shop::getRequestUri()
        );
        
        header('Location: ' . $url);
        exit;
    }

    // Send header if necessary
    if ($pcfwlHelper->getConfig('header_content_age') === 'on') {
        $pcfwlHelper->setContentAgeHeader();
    }
    
    // Send header if necessary
    if ($pcfwlHelper->getConfig('header_age_hash') === 'on') {
        $pcfwlHelper->setAgeHashHeader();
    }
}
