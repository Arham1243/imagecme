<?php

use Carbon\Carbon;

if (! function_exists('buildUrl')) {
    function buildUrl($base, $resource = null, $slug = null)
    {
        $url = $base;
        if ($resource) {
            $url .= '/'.$resource;
        }
        if ($slug) {
            $url .= '/'.$slug;
        }

        return $url;
    }
}

if (! function_exists('sanitizedLink')) {
    function sanitizedLink($url)
    {
        return '//'.preg_replace('/^(https?:\/\/)?(www\.)?/', '', $url);
    }
}

if (! function_exists('formatPrice')) {
    function formatPrice($price)
    {
        $formattedPrice = number_format($price, 2, '.', ',');

        return env('APP_CURRENCY').' '.$formattedPrice;
    }
}

if (! function_exists('formatDateTime')) {
    function formatDateTime($date)
    {
        return Carbon::parse($date)->format('M j, Y - g:i A');
    }
}

if (! function_exists('formatDate')) {
    function formatDate($date)
    {
        return Carbon::parse($date)->format('M j, Y');
    }
}

if (! function_exists('format_type')) {
    function format_type($string)
    {
        return ucwords(str_replace('_', ' ', $string));
    }
}
