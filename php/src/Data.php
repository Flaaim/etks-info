<?php

namespace App;

class Data
{
    public static function getPath(): string
    {
        return dirname(__DIR__, 2).'/_data/';
    }
    public function get(string $file): string
    {
        return self::getPath().'/'.basename($file);
    }
    public function getAll(): array
    {
        return array_map(
            fn($file) => self::getPath().'/'.basename($file),
            array_diff(scandir(self::getPath()), ['.', '..'])
        );
    }
    public function read(string $file): string
    {
        if (!file_exists($file)) {
            throw new \DomainException('File not found');
        }
        $string = file_get_contents($file);
        if ($string === false) {
            throw new \DomainException("File '$file' not found");
        }
        return $string;
    }


}