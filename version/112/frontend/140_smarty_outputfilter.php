<?php
/**
 * Insert meta tags, landing page and landing dialog if setting set
 *
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 */

if (class_exists('Shop')) {
    require_once $oPlugin->cFrontendPfad . '../include/class.plugin.helper.php';
    $pluginHelper = pluginHelper::getInstance($oPlugin);

    // Insert meta tag if neccessary
    if ($pluginHelper->getConfig('insert_meta') === 'on') {
        $ageHash = md5(filter_input(INPUT_SERVER, 'SERVER_ADDR').$oPlugin->dInstalliert);
        pq('head')
            ->prepend('<meta name="age-de-meta-label" content="age=' . $pluginHelper->getConfig('min_age') . ' hash: ' . $ageHash . ' v=1.0 kind=sl protocol=all" />')
            ->prepend('<meta name="age-meta-label" content="age=' . $pluginHelper->getConfig('min_age') . '" />');
    }

    // If we insert a dialog and/or a landing page we have to assign our smarty values
    if (($pluginHelper->getConfig('show_landing_page') === "on" && $pluginHelper->fskAccept() === false) ||
    ($pluginHelper->getConfig('show_dialog') === "on" && $pluginHelper->fskAccept() === false)) {
        $pluginHelper->assignSmartyValues();
    }
    
    // Insert landing page
    if ($pluginHelper->getConfig('show_landing_page') === "on" && $pluginHelper->fskAccept() === false) {
        $pluginHelper->insertLandingPage();
    }
    
    // Insert dialog
    if ($pluginHelper->getConfig('show_dialog') === "on" && $pluginHelper->fskAccept() === false) {
        $pluginHelper->insertDialog();
    }
}
