<?php

require_once 'modules/styling.php';
require_once 'modules/database.php';

$db = initializeDatabase();

printStyledSplashBanner();

$tables = getAvailableTables($db);
echo colorize("Available tables:\n", 'green');
foreach ($tables as $table) {
    echo colorize($table . "\n", 'cyan');
}

echo colorize("Enter the table name: ", 'yellow');
$tableName = trim(fgets(STDIN));
if (!isTableNameValid($tableName)) {
    die(colorize("Invalid table name. Exiting.\n", 'red'));
}

if (!isTableExists($db, $tableName)) {
    die(colorize("Table '$tableName' does not exist. Exiting.\n", 'red'));
}

echo colorize("Enter the number of rows to preview: ", 'yellow');
$numRows = intval(trim(fgets(STDIN)));

previewData($db, $tableName, $numRows);

closeDatabase($db);

function previewData($db, $tableName, $numRows) {
    $query = "SELECT * FROM $tableName LIMIT $numRows";
    $result = $db->query($query);

    if (!$result) {
        die(colorize("Error executing query: " . $db->lastErrorMsg(), 'red'));
    }

    echo colorize("ID\tTimestamp\tURL\t\t\tHTTP Code\tUser Agent\n", 'blue');

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        echo colorize("{$row['id']}\t{$row['timestamp']}\t\t{$row['url']}\t\t{$row['http_code']}\t\t{$row['user_agent']}\n", 'white');
    }
}

?>