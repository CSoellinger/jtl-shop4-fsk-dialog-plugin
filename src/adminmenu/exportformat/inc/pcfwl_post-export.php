<?php
/**
 * Always include this file when ending exports
 *
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 */

fwrite($f, $xml_string);

fclose($f);

// If export exists we delete it before
if (file_exists($cDateipfad)) {
    unlink($cDateipfad);
}

// Now copy the temp file with new content to normal file
copy($cTmpDateipfad, $cDateipfad);

// Delete the temp file
unlink($cTmpDateipfad);

// At least set new export date and delete it from queue
Shop::DB()->query('UPDATE texportformat SET dZuletztErstellt = now() WHERE texportformat.kExportformat = ' . $exportformat->kExportformat, 4);
Shop::DB()->delete('texportqueue', 'kExportqueue', $queue->kExportqueue);

if ($_GET['back'] === 'admin') {
    header('Location: exportformate.php');
    exit;
}
