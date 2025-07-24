<?php

namespace App\Entity;

use ArrayObject;

class Release
{
    public string $release_id;
    public string $title;
    public string $slug;
    public string $description;

    public ArrayObject $sections;

    public function __construct(
        string $release_id,
        string $title,
        string $description,
        ArrayObject $sections
    )
    {
        $this->release_id = $release_id;
        $this->title = $title;
        $this->description = $description;
        $this->sections = $sections;
    }
    public function getSections(): ArrayObject
    {
        return $this->sections;
    }

}