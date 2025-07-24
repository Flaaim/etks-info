<?php

namespace App;

use Twig\Loader\FilesystemLoader;

class Template
{
    private array $templates;
    public function __construct(FilesystemLoader $loader, array $templates)
    {
        if (empty($templates)) {
            throw new \DomainException("Templates name cannot be empty");
        }
        foreach ($templates as $template) {
            if(!$loader->exists($template)) {
                throw new \DomainException("Template '{$template}' does not exist");
            }
        }

        $this->templates = $templates;
    }

    public function get(string $key): string
    {
        if(!array_key_exists($key, $this->templates)) {
            throw new \DomainException("Template '{$key}' does not exist");
        }
        return $this->templates[$key];
    }
}