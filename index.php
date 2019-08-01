<?php
require __DIR__ . '/vendor/autoload.php';
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$downManager = new DownloadManager();
$downManager->downloadFilesWithStructure("test.txt");
