<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('md5', [$this, 'md5']),
        ];
    }

    public function md5($str)
    {
        return md5($str);
    }
}