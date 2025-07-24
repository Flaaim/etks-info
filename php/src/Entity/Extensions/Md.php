<?php

namespace App\Entity\Extensions;

use App\Interface\Extension;

class Md implements Extension
{
    const EXTENSION_NAME = '.md';
    public function get(): string
    {
        return self::EXTENSION_NAME;
    }
}