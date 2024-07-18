<?php

namespace App\Trait;

trait ClearPhoneTrait
{
    public function clearPhone($phone): string
    {
        return preg_replace('/\D/', '', $phone);
    }
}
