<?php
/**
 * Create age.xml file
 *
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 */

include_once 'inc/pre-export.php';

$pcfwlHelper->assignXmlSmartyValues();

$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->loadXML($pcfwlHelper->getXml('age.xml'));
$xml_string = $doc->saveXML();

include_once 'inc/post-export.php';
