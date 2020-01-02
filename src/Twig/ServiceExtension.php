<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ServiceExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('service', [$this, 'formatService']),
        ];
    }

    public function formatService($service)
    {
        switch ($service) {
            case 1:
                return "Sur place";
                break;
            case 2:
                return "À domicile";
                break;
        }
    }
}
