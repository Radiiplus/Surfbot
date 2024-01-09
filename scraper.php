<?php

require_once 'modules/styling.php';
require_once 'modules/input.php';
require_once 'modules/database.php';
require_once 'modules/file_operations.php';
require_once 'modules/logging.php';
require_once 'modules/scraping.php';
require_once 'modules/error_handling.php';

printStyledSplashBanner();

$db = initializeDatabase();

$urls = getInputUrls();
$times = getInputTimes();
$maxIterations = getInputMaxIterations();

$scrollPositions = readFromFile('files/scroll_positions.txt');
$userAgents = readFromFile('files/user_agents.txt');

$ch = initializeCurl();

try {
    for ($iteration = 1; $iteration <= $maxIterations; $iteration++) {
        $randomTime = $times[array_rand($times)];
        $randomUrl = $urls[array_rand($urls)];
        curl_setopt($ch, CURLOPT_URL, trim($randomUrl));
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        logVisitDetails($iteration, $randomUrl, $randomTime, $httpCode);

        if ($httpCode == 200) {
            performScrapingActivities($ch, [], $scrollPositions, $userAgents, $db, $randomUrl, $httpCode);
        } else {
            logFailedVisit($db, $randomUrl, $httpCode);
        }

        sleep($randomTime);
    }
} finally {
    closeCurl($ch);
    closeDatabase($db);
}

?>