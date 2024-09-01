<?php

namespace Keasy9\SitemapGenerator\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Keasy9\SitemapGenerator\Enums\SitemapChangeFreqEnum;
use Keasy9\SitemapGenerator\Interfaces\SitemapSourceInterface;
use Keasy9\SitemapGenerator\Traits\SitemapSource;

class SitemapUrl extends Model implements SitemapSourceInterface
{
    use HasFactory;
    use SitemapSource;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'active'   => 'bool',
        'lastmod'  => 'date',
        'priority' => 'float',
    ];

    public function getSitemapLastmod(): ?Carbon
    {
        return $this->lastmod;
    }

    public function getSitemapUrl(): string
    {
        return url($this->url);
    }

    public function getSitemapPriority(): ?float
    {
        return $this->priority;
    }

    public function getSitemapChangefreq(): ?SitemapChangeFreqEnum
    {
        return SitemapChangeFreqEnum::tryFrom($this->changefreq);
    }

    public static function getSitemapList(int $perPage, int $page): Collection
    {
        return static::limit($perPage)
            ->offset(($page - 1) * $perPage)
            ->where('active', '=', 1)
            ->get();
    }
}
