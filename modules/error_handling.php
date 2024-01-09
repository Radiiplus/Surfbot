<?php

require_once 'database.php';

function logError($message) {
    echo colorize("Error: $message\n", 'red');

    $db = initializeDatabase();
    $query = "INSERT INTO errors (timestamp, message) VALUES (?, ?)";
    $stmt = $db->prepare($query);

    if ($stmt) {
        $timestamp = time();
        $stmt->bindParam(1, $timestamp, SQLITE3_INTEGER);
        $stmt->bindParam(2, $message, SQLITE3_TEXT);

        if (!$stmt->execute()) {
            echo colorize("Error inserting error log into the database.\n", 'red');
        }

        $db->close();
    } else {
        echo colorize("Error preparing statement for error log.\n", 'red');
    }
}

function handleException($exception) {
    logError($exception->getMessage());
}

set_exception_handler('handleException');

?>