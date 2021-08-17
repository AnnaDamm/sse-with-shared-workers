<?php

declare(strict_types=1);

// only for example
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: *');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    die();
}

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

ob_end_clean(); // directly send to the browser without buffering

$id = getallheaders()['Last-Event-ID'] ?? 0;
$ping = (bool)$id % 2;

for ($i = 0; $i < 10; $i++) {
    $id++;
    $ping = !$ping;

    // there must be one empty line between messages.
    // Messages look like this:
    //
    // [event: <event to listen to (default: "message")>]
    // data: <text message>
    // [id: <id>]
    // <new line>
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
