<?php

namespace App\Service;

class FormatYoutubeLink
{
    /* convert videos link like : https://www.youtube.com/watch?v=OztPdc3pwYU
    TO => https://www.youtube.com/embed/OztPdc3pwYU */
    public function format(string $link): ?string
    {
        $regex = "/\watch\?v=/i";
        return preg_replace($regex, "embed/", $link);
    }
}
