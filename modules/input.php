<?php

function getInputUrls() {
    echo colorize("Enter URLs (separated by commas): ", 'cyan');
    $urls = explode(',', trim(fgets(STDIN)));
    $urls = array_map('trim', $urls);
    return validateUrls($urls);
}

function getInputTimes() {
    echo colorize("Enter time per page (seconds, separated by commas): ", 'cyan');
    $times = explode(',', trim(fgets(STDIN)));
    return validateTimes($times);
}

function getInputMaxIterations() {
    echo colorize("Enter max iterations: ", 'cyan');
    $maxIterations = intval(trim(fgets(STDIN)));
    return validateMaxIterations($maxIterations);
}

function validateUrls($urls) {
    $urls = array_filter($urls, 'filterValidURL');
    if (empty($urls)) {
        die(colorize("Invalid URLs entered.", 'red'));
    }
    return $urls;
}

function validateTimes($times) {
    $times = array_map('intval', $times);
    if (in_array(0, $times)) {
        die(colorize("Invalid time duration entered.", 'red'));
    }
    return $times;
}

function validateMaxIterations($maxIterations) {
    if ($maxIterations <= 0) {
        die(colorize("Invalid max iterations value.", 'red'));
    }
    return $maxIterations;
}

function filterValidURL($url) {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

?>