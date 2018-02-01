<?php
/**
 * Create age-[country].xml file
 *
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 * 
 * @global Plugin $oPlugin
 * @global Exportformat  $exportformat
 */

include_once 'inc/pcfwl_pre-export.php';

// Fetch country from export file name. For example: age-de.xml = de; age-at.xml = at,...
$ageCountry = preg_replace('/age[_\-]{1}([a-z]*)/', '$1', substr($exportformat->cDateiname, 0, strrpos($exportformat->cDateiname, '.')));

$pcfwlHelper->assignXmlSmartyValues($ageCountry);

$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->loadXML($pcfwlHelper->getXmlFromTpl('age-country.xml'));
$xml_string = $doc->saveXML();

include_once 'inc/pcfwl_post-export.php';
