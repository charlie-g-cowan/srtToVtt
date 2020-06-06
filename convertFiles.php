<?php
/**
 * Program to output VTT subtitles from inputted SRT subtitles
 */

// Set MIME type of output to VTT (TextTrack)
header('Content-Type: text/vtt');

// Import conversion module
require_once("srtToVtt.php");

if ($argv[1]) {
    $subtitlesLocation = $argv[1];
} else {
    die("No filename provided.\n");
}

$subsFile = fopen($subtitlesLocation, "r") or die("Unable to open file.\n");
$inputSubs = fread($subsFile,filesize($subtitlesLocation));
fclose($subsFile);

if ($argv[2]) {
    file_put_contents ($argv[2], srtToVtt($inputSubs));
} else {
    echo srtToVtt($inputSubs);
}

