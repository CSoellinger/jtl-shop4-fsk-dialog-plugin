<?php
/**
 * Create age-[country].xml file
 *
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 */

include_once 'inc/pre-export.php';

// Fetch country from export file name. For example: age-de.xml = de; age-at.xml = at,...
$ageCountry = preg_replace('/age[_\-]{1}([a-z]*)/', '$1', substr($exportformat->cDateiname, 0, strrpos($exportformat->cDateiname, '.')));

$pluginHelper->assignXmlSmartyValues($ageCountry);

$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->loadXML($pluginHelper->getXml('age-country.xml'));
$xml_string = $doc->saveXML();

include_once 'inc/post-export.php';
