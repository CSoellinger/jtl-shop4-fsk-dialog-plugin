<?php
/**
 * Create age.xml file
 *
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 */

include_once 'inc/pre-export.php';

$pluginHelper->assignXmlSmartyValues();

$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->loadXML($pluginHelper->getXml('age.xml'));
$xml_string = $doc->saveXML();

include_once 'inc/post-export.php';
