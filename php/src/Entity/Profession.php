<?php

namespace App\Entity;

class Profession
{
    public string $name;
    public string $slug;
    public array $ranks;

    public function __construct(string $name, string $slug, array $ranks)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->ranks = $ranks;
    }
}