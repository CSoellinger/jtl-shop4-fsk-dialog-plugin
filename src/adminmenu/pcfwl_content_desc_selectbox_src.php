<?php
/**
 * Dynamic options for content description setting
 *
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 */

$options = array();

$option  = new stdClass();
$option->cWert = 'sexuality';
$option->cName = 'Sex / Erotik / Nackter Inhalt';
$option->nSort = 1;
$options[]     = $option;

$option        = new stdClass();
$option->cWert = 'violence';
$option->cName = 'Gewalt / Waffen';
$option->nSort = 2;
$options[]     = $option;

$option        = new stdClass();
$option->cWert = 'discrimination';
$option->cName = 'Diskriminierung / Rassismus / Hass';
$option->nSort = 3;
$options[]     = $option;

$option        = new stdClass();
$option->cWert = 'cursing';
$option->cName = 'Obszoene Sprache / Schlechter Umgang / Fluchen';
$option->nSort = 4;
$options[]     = $option;

$option        = new stdClass();
$option->cWert = 'drugs';
$option->cName = 'Drogen / Tabak / Alkohol';
$option->nSort = 5;
$options[]     = $option;

$option        = new stdClass();
$option->cWert = 'fear';
$option->cName = 'Furcht / Erschuetternder Inhalt';
$option->nSort = 6;
$options[]     = $option;

$option        = new stdClass();
$option->cWert = 'gambling';
$option->cName = 'Gluecksspiel';
$option->nSort = 7;
$options[]     = $option;

return $options;
