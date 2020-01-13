<?php

namespace App\Services;

class SlugService
{
    public function slugify($text)
    {
        return strtolower(str_replace(' ','-', $text));
    }
}