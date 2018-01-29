<?php
/**
 * Dynamic options for feature description setting
 *
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 */

$options = array();

$option  = new stdClass();
$option->cWert = 'inapppurchase';
$option->cName = 'InApp Kaeufe / Shopping';
$option->nSort = 1;
$options[]     = $option;

$option        = new stdClass();
$option->cWert = 'personaldatasharing';
$option->cName = 'Teilen von persoenlichen Daten';
$option->nSort = 2;
$options[]     = $option;

$option        = new stdClass();
$option->cWert = 'locationdatasharing';
$option->cName = 'Teilen von Orts-Daten';
$option->nSort = 3;
$options[]     = $option;

$option        = new stdClass();
$option->cWert = 'chat';
$option->cName = 'Anonymer Chat';
$option->nSort = 4;
$options[]     = $option;

return $options;
