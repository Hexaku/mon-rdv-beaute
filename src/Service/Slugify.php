<?php

namespace App\Service;

class Slugify
{
    public function generate($input)
    {
        $input = strtolower($input);

        $special = ['à', 'â', 'ä', 'ç', 'é', 'è', 'ê', 'ë', 'î', 'ï', 'ô', 'ö', '.', '!', '?', '\''];
        $replacement = ['a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'o', 'o', ''];
        $input = str_replace($special, $replacement, $input);

        $input = trim($input);

        $input = preg_replace('!\s+!', '-', $input);

        return $input;
    }
}
