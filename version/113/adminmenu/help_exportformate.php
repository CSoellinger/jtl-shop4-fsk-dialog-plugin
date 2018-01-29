<?php
/**
 * Read some texts from README.md and parse it as HTML
 *
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 */

global $oPlugin;

require_once $oPlugin->cFrontendPfad . '../vendor/markdownSplit.php';

if (!class_exists('Parsedown')) {
    require_once $oPlugin->cFrontendPfad . '../vendor/Parsedown.php';
}

// Get content from README.md
$text = file_get_contents($oPlugin->cFrontendPfad . '../../../README.md');
$s = new \diversen\markdownSplit();

$res = $s->splitMarkdownAtLevel($text, $setext = true, $level = 4);

// @todo Find a better way to extract neccessary markdown texts
$res = array($res[6], $res[7], $res[8]);
$texts = array();

$Parsedown = new Parsedown();

foreach ($res as $key => $value) {
    array_push($texts, array(
        "header" => utf8_decode($value['header_md']),
        "header_html" => $Parsedown->text(utf8_decode($value['header_md'])),
        "body" => utf8_decode($value['body']),
        "body_html" => str_replace('&amp;', '&', $Parsedown->text(htmlentities(utf8_decode($value['body']))))
    ));
}

$smarty->assign('help_exportformate_texts', $texts);
$smarty->display($oPlugin->cAdminmenuPfad . 'template/help-exportformate.tpl');
