<?php

function printStyledSplashBanner() {
    $splashBanner = "
\033[1;36m┓┏┳┳┓┏┓┏┓
┃┃┃┣┫┣ ┗┓
┗┛┻┻┛┗┛┗┛\033[0m
\033[1;36mPowered by Radiiplus - https://x.com/radiiplus\033[0m
    ";
    echo $splashBanner;
}

function colorize($text, $color) {
    $colors = [
        'black' => '0;30',
        'red' => '0;31',
        'green' => '0;32',
        'yellow' => '0;33',
        'blue' => '0;34',
        'purple' => '0;35',
        'cyan' => '0;36',
        'white' => '0;37',
    ];

    return "\033[" . $colors[$color] . "m" . $text . "\033[0m";
}

?>￼Enter
