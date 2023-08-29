<?php
set_time_limit(0);

header('Content-Type: text/event-stream');
header('Connection: keep-alive');
header('Cache-Control: no-store');

header('Access-Control-Allow-Origin: *');

$dataDir = 'data';

while (true) {
if (connection_aborted()) break;

    $files = array_diff(scandir($dataDir), array('.', '..'));
    if (count($files)) {
        natsort($files);
        foreach ($files as $file) {
            $file = $dataDir . '/' . $file;
            if (file_exists($file)) {
                $data = file_get_contents($file);
                unlink($file);
                echo 'data: ' . $data;
                echo "\n\n";
            }
        }
    }

ob_flush();
flush();

sleep(1);
}