<?php

namespace App;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Dir
{
    private const BASE_DIR = '/releases';
    public static function getDir(): string
    {
        return dirname(__DIR__, 2).self::BASE_DIR;
    }
    public function makeDir(string $slug, string $path = null): string
    {
        $pathDir = !$path ? self::getDir() : $path;
        $fullPath = $pathDir.'/'.$slug;
        if(is_dir($fullPath)){
            $this->deleteDirectory($fullPath);
        }
        $result = mkdir($fullPath);
        if($result === false){
            throw new \DomainException("Unable to create directory $fullPath");
        }
        return $fullPath;
    }
    public function deleteDirectory(string $dir): bool
    {
        if (!is_dir($dir)) {
            return false;
        }
        $it = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
            RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }

        return rmdir($dir);
    }
}