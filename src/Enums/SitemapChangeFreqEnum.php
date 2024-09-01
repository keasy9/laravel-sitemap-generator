<?php

declare(strict_types=1);

namespace Keasy9\SitemapGenerator\Enums;

enum SitemapChangeFreqEnum: string
{
    case ALWAYS = 'always';
    case HOURLY = 'hourly';
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';
    case NEVER = 'never';

    public static function values(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }
}
