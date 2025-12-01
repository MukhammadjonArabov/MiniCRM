<?php

namespace App\Services;

class ProfileApiService
{
    public function getProfile()
    {
        return auth()->user();
    }
}
