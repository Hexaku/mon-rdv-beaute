<?php

namespace App\Service;

use Symfony\Component\Dotenv\Dotenv;

class Mailer
{
    public function sender()
    {
        $dotenv = new Dotenv();
        $dotenv->load('../.env.local');
        $mail = $_ENV['MAILER_ADMIN'];
        return $mail;
    }
}
