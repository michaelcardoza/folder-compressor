<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpZip\ZipFile;
use PhpZip\Exception\ZipException;
use PhpZip\Util\Iterator\IgnoreFilesRecursiveFilterIterator;

$zipFile = new ZipFile();

// Nombres de las carpetas a comprimir
$folders = ['folder-1','folder-2'];

// Archivos o Carpetas que serán ignoradas
$ignoreFiles = ['node_modules/', 'src/', '.idea/', '.git/'];

// Folder donde se guardaran los archivos ZIP
$destFolder = 'zips';

try {
    if (!file_exists($destFolder) && !is_dir($destFolder)) {
        mkdir($destFolder);
    }

    foreach ( $folders as $folder ) {
        $directoryIterator = new RecursiveDirectoryIterator(__DIR__ . "/resources/{$folder}");
        $ignoreIterator = new IgnoreFilesRecursiveFilterIterator($directoryIterator, $ignoreFiles);

        $zipFile
            ->addFilesFromIterator($ignoreIterator)
            ->saveAsFile("{$destFolder}/{$folder}.zip")
            ->close();
    }

    echo "\n @ --- Compressed folders --- 😎 ! \n";
} catch ( ZipException $e ) {
    echo $e;
}