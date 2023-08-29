<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' and !isset($_GET['sse'])) {
    require_once 'front.php';
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' and isset($_GET['sse'])) {
    require_once 'sse.php';
} else {
    require_once 'back.php';
}