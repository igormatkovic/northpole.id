<?php
// router.php — a minimal router for PHP's built-in server

// If the requested file exists, serve it directly
if (php_sapi_name() === 'cli-server') {
    $filePath = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($filePath)) {
        return false;
    }
}

// Route /record/XXXX → show.php?id=XXXX
if (preg_match('#^/record/([^/]+)/?$#', $_SERVER['REQUEST_URI'], $matches)) {
    $_GET['id'] = $matches[1];
    include __DIR__ . '/show.php';
    exit;
}

// Default route → index.php
include __DIR__ . '/index.php';