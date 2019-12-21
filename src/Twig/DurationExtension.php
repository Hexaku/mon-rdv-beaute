<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DurationExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('duration', [$this, 'formatDuration']),
        ];
    }

    public function formatDuration($duration)
    {
        $hours = floor($duration / 60);
        $minutes = ($duration % 60);
        return $hours . "h" . $minutes . "mn";
    }
}
