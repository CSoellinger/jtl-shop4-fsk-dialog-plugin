<?php
/**
 * Create age.xml file
 *
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 */

include_once 'inc/pcfwl_pre-export.php';

$pcfwlHelper->assignXmlSmartyValues();

$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->loadXML($pcfwlHelper->getXmlFromTpl('age.xml'));
$xml_string = $doc->saveXML();

include_once 'inc/pcfwl_post-export.php';
