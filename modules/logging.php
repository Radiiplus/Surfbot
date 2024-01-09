<?php

function logVisit($db, $url, $httpCode, $userAgent) {
    $timestamp = time();
    $query = "INSERT INTO visits (timestamp, url, http_code, user_agent) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);

    if (!$stmt) {
        die(colorize("Error preparing statement: " . $db->lastErrorMsg(), 'red'));
    }

    $stmt->bindParam(1, $timestamp, SQLITE3_INTEGER);
    $stmt->bindParam(2, $url, SQLITE3_TEXT);
    $stmt->bindParam(3, $httpCode, SQLITE3_INTEGER);
    $stmt->bindParam(4, $userAgent, SQLITE3_TEXT);

    if (!$stmt->execute()) {
        die(colorize("Error executing statement: " . $stmt->lastErrorMsg(), 'red'));
    }
}

function logVisitDetails($iteration, $url, $time, $httpCode) {
    echo colorize("Visit $iteration at " . date('Y-m-d H:i:s') . " - ", 'green');
    if ($httpCode == 200) {
        echo colorize("Visited $url. Spent $time seconds\n", 'green');
    } else {
        echo colorize("Failed to visit $url. HTTP code: $httpCode\n", 'red');
    }
}

function logFailedVisit($db, $url, $httpCode) {
    echo colorize("Failed to visit $url. HTTP code: $httpCode\n", 'red');
    logVisit($db, $url, $httpCode, 'N/A');
}

?>