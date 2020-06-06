<?php

/**
 * Function to convert srtToVtt with a srt string as the input
 * @param string $srtInput An SRT file as a string
 * @return string A string in VTT format
 */
function srtToVtt($srtInput) {

	$subtitlesWithoutCarriageReturns = trim(str_replace("\r\n", "\n", $srtInput)); // Strip \r carriage-return char
	$separatedSubtitles = explode("\n\n", $subtitlesWithoutCarriageReturns);
	$vtt = "WEBVTT\n\n"; // Final VTT file must start with this
	foreach ($separatedSubtitles as $subtitleNumber=>$subtitle) {
        $newSubtitle = individualSrtToVtt($subtitle, $subtitleNumber);
        $vtt .= $newSubtitle;
	}
	return $vtt;
}

/**
 * @param $subtitle
 * @param $subtitleNumber
 * @return string
 */
function individualSrtToVtt($subtitle, $subtitleNumber)
{
    $splitUpSubtitle = explode("\n", $subtitle); // Separate subtitle into number, time, and text components

    // Check if there is a subtitle number. strval(intval()) strips rogue whitespace.
    if (ctype_digit(strval(intval($splitUpSubtitle[0])))) {
        $splitUpSubtitle = array_splice($splitUpSubtitle, 1); // If so, strip that number
    }

    // Replace comma with a period for decimal point (main difference between SRT/VTT)
    $newTimecode = str_replace(",", ".", array_shift($splitUpSubtitle));
    // Final subtitle with number, timecode, text
    $newSubtitle = $subtitleNumber + 1 . "\n" . $newTimecode . "\n" . implode("\n", $splitUpSubtitle) . "\n\n";
    return $newSubtitle;
}