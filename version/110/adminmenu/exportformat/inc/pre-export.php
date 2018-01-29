<?php
/**
 * Always include this file before starting export
 *
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 */

require_once PFAD_ROOT . PFAD_ADMIN . PFAD_INCLUDES . 'admininclude.php';
require_once PFAD_ROOT . PFAD_ADMIN . PFAD_INCLUDES . 'exportformat_inc.php';
require_once $oPlugin->cFrontendPfad . '../include/class.plugin.helper.php';

@ini_set('max_execution_time', 0);

if (!isset($_GET['e']) || !((int)$_GET['e'] > 0) || !validateToken()) {
    die('0');
}

$pluginHelper = pluginHelper::getInstance($oPlugin);

$cDateiname = $exportformat->cDateiname;
$cDateipfad = PFAD_ROOT . PFAD_EXPORT . $exportformat->cDateiname;

$cTmpDateiname = substr($cDateiname, 0, strrpos($cDateiname, '.')) . '_.xml';
$cTmpDateipfad = PFAD_ROOT . PFAD_EXPORT . $cTmpDateiname;

// If temp file exists we delete it before
if (file_exists($cTmpDateipfad)) {
    unlink($cTmpDateipfad);
}

$f = fopen($cTmpDateipfad, 'a');

$pluginHelper->assignSmartyValues();
