<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Image;

abstract class Controller
{
    public function __construct()
    {
        $logo = Image::where('type', 'logo')->latest()->first();
        View()->share('config', $this->getConfig());
        View()->share('logo', $logo);
    }

    public static function getConfig()
    {
        return Config::where('is_active', 1)
            ->pluck('flag_value', 'flag_type')
            ->toArray();
    }
}
