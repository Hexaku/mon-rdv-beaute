<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DurationExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('duration', [$this, 'formatDuration']),
        ];
    }

    public function formatDuration(int $duration): string
    {
        $hours = floor($duration / 60);
        $minutes = ($duration % 60);
        return $hours . "h" . $minutes . "mn";
    }
}
