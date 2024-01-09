<?php

function initializeCurl() {
    $ch = curl_init();
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true]);
    return $ch;
}

function closeCurl($ch) {
    curl_close($ch);
}

function performScrapingActivities($ch, $activities, $scrollPositions, $userAgents, $db, $url, $httpCode) {
    foreach ($activities as $activity) {
        echo colorize("Performing $activity...\n", 'yellow');
    }

    $randomUserAgent = $userAgents[array_rand($userAgents)];
    curl_setopt($ch, CURLOPT_USERAGENT, $randomUserAgent);
    echo colorize("User Agent: $randomUserAgent\n", 'cyan');

    logVisit($db, $url, $httpCode, $randomUserAgent);
}

?>