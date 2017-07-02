<?php

/**
 * Function to convert srtToVtt with a srt string as the input
 * @param string $srtInput An SRT file as a string
 * @return string A string in VTT format
 */
function srtToVtt($srtInput) {

	$subtitlesWithoutCarriageReturns = trim(str_replace("\r\n", "\n", $srtInput)); // Remove \r carriage return character from the initial SRT string
	$seperatedSubtitles = explode("\n\n", $subtitlesWithoutCarriageReturns); // Seperate the subtitle string into an array by seperating at the double newline
	
	$vtt = "WEBVTT\n\n"; // Start final VTT string with the VTT decleration and a double newline

	// Run through each subtitle
	foreach ($seperatedSubtitles as $subtitleNumber=>$subtitle) {
		// Seperate the subtitle into its number, time, and text components by seperating at the newline character
		$splitUpSubtitle = explode("\n", $subtitle);

		// If the first member of the subtitle array is an integer (indicating a subtitle number). Note that strval(intval()) is performed in order to remove any rogue whitespace characters.
		if (ctype_digit(strval(intval($splitUpSubtitle[0])))) { 
			// Then remove this number from the array, making the array only timecode and subtitle. 
			$splitUpSubtitle = array_splice($splitUpSubtitle, 1);
		}

		// Make timecode VTT compliant by replacing the comma with a period to represent the decimal point. Set $newTimecode to this by popping from the start of the array using array_shift.
		$newTimecode = str_replace(",", ".", array_shift($splitUpSubtitle));
		// Form new individual subtitle by concatenating the subtitle number (index + 1 due to index starting at 0) with the compliant timecode and the text of the subtitle, each seperated by a newline character, and finished with a double newline to start the new subtitle.
		$newSubtitle = $subtitleNumber + 1 . "\n" . $newTimecode . "\n" . implode("\n", $splitUpSubtitle). "\n\n";
		// Append the new subtitle to the whole subtitle string
		$vtt .= $newSubtitle;
	}

	// Return the new vtt string after fully iterating through every subtitle and concatenating them all
	return $vtt;

}