<?php
$folder = 'data';

$data = file_get_contents('php://input');
$microtime = microtime();
if (!is_dir($folder)) {
    mkdir($folder, 0777);
}
file_put_contents($folder . '/' . $microtime . '.json', $data);