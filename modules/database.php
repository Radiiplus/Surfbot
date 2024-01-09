<?php

define('DB_FILE', 'database/progress_log.db');

function initializeDatabase() {
    $db = new SQLite3(DB_FILE);
    if (!$db) {
        die(colorize("Error opening database: " . $db->lastErrorMsg(), 'red'));
    }

    $db->exec("CREATE TABLE IF NOT EXISTS visits (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        timestamp INTEGER NOT NULL,
        url TEXT NOT NULL,
        http_code INTEGER NOT NULL,
        user_agent TEXT NOT NULL
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS errors (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        timestamp INTEGER NOT NULL,
        message TEXT NOT NULL
    )");

    return $db;
}

function closeDatabase($db) {
    $db->close();
}

function getAvailableTables($db) {
    $tables = $db->query("SELECT name FROM sqlite_master WHERE type='table';");
    $tableNames = [];
    while ($table = $tables->fetchArray(SQLITE3_ASSOC)) {
        $tableNames[] = $table['name'];
    }
    return $tableNames;
}

function isTableNameValid($tableName) {
    return ctype_alnum($tableName);
}

function isTableExists($db, $tableName) {
    $result = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='$tableName'");
    return $result->fetchArray() !== false;
}

?>