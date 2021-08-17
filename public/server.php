<?php

declare(strict_types=1);

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

ob_end_clean();

$id = getallheaders()['Last-Event-Id'] ?? 0;

while (true) {
    $id++;
    echo <<<TEXT
        id: $id
        data: ping
        
        event: pong
        data: pong


        TEXT;

    sleep(1);

    // Break the loop if the client aborted the connection (closed the page)
    flush(); // needed to check if the connection aborted
    if (connection_aborted() === 1) {
        break;
    }
}
