<?php
/**
 * Check for FSK accept and send HTTP header if settings set.
 *
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 */

if (class_exists('Shop')) {
    require_once $oPlugin->cFrontendPfad . '../include/class.plugin.helper.php';
    $pluginHelper = pluginHelper::getInstance($oPlugin);

    // Check if accepFsk query string is set
    if (strtoupper(filter_input(INPUT_GET, 'acceptFsk', FILTER_SANITIZE_STRING)) === pluginHelper::COOKIE_VALUE_ACCEPT) {
        $pluginHelper->writeCookie(pluginHelper::COOKIE_VALUE_ACCEPT);

        if (filter_input(INPUT_POST, 'ajaxSubmit', FILTER_SANITIZE_STRING) === 1 && $pluginHelper->getConfig('ajax_submit')) {
            exit;
        }

        $url = str_replace(
            array(
                '?acceptFsk=' . $pluginHelper::COOKIE_VALUE_ACCEPT,
                '&acceptFsk=' . $pluginHelper::COOKIE_VALUE_ACCEPT
            ),
            '',
            Shop::getURL() . '/' . Shop::getRequestUri()
        );
        
        header('Location: ' . $url);
        exit;
    }

    // Send header if neccessary
    if ($pluginHelper->getConfig('header_content_age') === 'on') {
        header('X-content-age: "' . $pluginHelper->getConfig('min_age') . '"');
    }
    
    // Send header if neccessary
    if ($pluginHelper->getConfig('header_age_hash') === 'on') {
        $ageHash = md5(filter_input(INPUT_SERVER, 'SERVER_ADDR').$oPlugin->dInstalliert);
        header('X-age-hash: "' . $ageHash . '"');
    }
}
