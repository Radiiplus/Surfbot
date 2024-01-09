<?php

function readFromFile($filename) {
    $data = [];
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if ($lines) {
        foreach ($lines as $line) {
        
            $data[] = $line;
        }
    }

    return $data;
}
?>