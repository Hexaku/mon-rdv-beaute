<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ObjectiveExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('objective', [$this, 'formatObjective']),
        ];
    }

    public function formatObjective(int $objective): string
    {
        switch ($objective) {
            case 1:
                return "Prestations";
                break;
            case 2:
                return "Professionnels";
                break;
            case 3:
                return "Membres";
                break;
            case 4:
                return "Clients";
                break;
        }
    }
}
