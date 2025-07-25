<?php

namespace App\Helpers;

class FileHelper
{
    public static function formatSize($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        if ($bytes <= 0) return '0 B';

        $pow = floor(log($bytes) / log(1024));
        $pow = min($pow, count($units) - 1);

        $size = $bytes / (1024 ** $pow);

        return round($size, $precision) . ' ' . $units[$pow];
    }
}
