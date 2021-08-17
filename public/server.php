<?php

declare(strict_types=1);

header('Access-Control-Allow-Origin: *'); // only for example

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

ob_end_clean();

$id = getallheaders()['Last-Event-Id'] ?? 0;
$ping = (bool) $id % 2;

while (true) {
    $id++;
    $ping = !$ping;
    echo <<<TEXT
        id: $id
        data: id: $id


        TEXT;

    if ($ping) {
        echo <<<PING
        event: ping
        data: ping?


        PING;
    } else {
        echo <<<PONG
        event: pong
        data: pong!


        PONG;
    }
    sleep(1);

    // Break the loop if the client aborted the connection (closed the page)
    flush(); // needed to check if the connection aborted
    if (connection_aborted() === 1) {
        break;
    }
}
