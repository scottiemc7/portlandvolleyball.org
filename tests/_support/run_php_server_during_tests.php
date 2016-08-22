<?php

// Command that starts the built-in web server
$command = sprintf(
    'php -S %s:%d -t %s >/dev/null 2>&1 & echo $!',
    'localhost',
    8001,
    dirname(__FILE__) . '/../../' // Sets the document root to the app root
);

// Execute the command and store the process ID
$output = array();
exec($command, $output);
$pid = (int) $output[0];

echo sprintf(
    '%s - Web server started on %s:%d with PID %d',
    date('r'),
    'localhost',
    8001,
    $pid
) . PHP_EOL;

// Kill the web server when the process ends
register_shutdown_function(function() use ($pid) {
    echo sprintf('%s - Killing process with ID %d', date('r'), $pid) . PHP_EOL;
    exec('kill ' . $pid);
});

// More bootstrap code