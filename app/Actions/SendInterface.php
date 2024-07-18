<?php

namespace App\Actions;

use App\Models\Joke;

interface SendInterface
{
    public function send(Joke $joke);

}