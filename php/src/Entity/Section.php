<?php

namespace App\Entity;

use ArrayObject;

class Section
{
    public string $name;
    public string $description;
    public string $section_id;
    public ArrayObject $professions;
    public function __construct(string $name, string $description, string $section_id, ArrayObject $professions)
    {
        $this->name = $name;
        $this->description = $description;
        $this->section_id = $section_id;
        $this->professions = $professions;
    }

}