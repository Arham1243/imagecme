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
if (! function_exists('getRelativeType')) {
    function getRelativeType(string $type): string
    {
        $typeMapping = [
            'share_image_diagnosis' => 'Share Case',
            'challenge_image_diagnosis' => 'Challenge Case',
            'ask_image_diagnosis' => 'Help Case',
            'ask_ai_image_diagnosis' => 'AI Case',
        ];

        return $typeMapping[$type] ?? 'Unknown Type';
    }
}
if (! function_exists('formatBigNumber')) {
    function formatBigNumber($num)
    {
        if ($num >= 1_000_000_000) {
            return rtrim(number_format($num / 1_000_000_000, 1, '.', '0'), '.0').'B';
        }
        if ($num >= 1_000_000) {
            return rtrim(number_format($num / 1_000_000, 1, '.', '0'), '.0').'M';
        }
        if ($num >= 1_000) {
            return rtrim(number_format($num / 1_000, 1, '.', '0'), '.0').'K';
        }

        return (string) $num;
    }
}
