<?php
/**
 * Program to output VTT subtitles from inputted SRT subtitles
*/

// Set MIME type of output to VTT (TextTrack)
header('Content-Type: text/vtt');

// Import conversion module
require_once("srtToVtt.php");

// Get file location of subtitles from get variable
$subtitlesLocation = $_GET['srt'];

// Read SRT subtitles from file
$inputSubs = file_get_contents($subtitlesLocation);
// Echo converted VTT subtitles
echo srtToVtt($inputSubs);