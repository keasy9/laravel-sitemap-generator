<?php

namespace Keasy9\SitemapGenerator\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Keasy9\SitemapGenerator\Enums\SitemapChangeFreqEnum;
use Keasy9\SitemapGenerator\Interfaces\SitemapSourceInterface;

/**
 * @mixin Model
 */
trait SitemapSource
{
    /**
     * @param int $perPage
     * @param int $page
     * @return Collection<SitemapSourceInterface>
     */
    public static function getSitemapList(int $perPage, int $page): Collection
    {
        return static::limit($perPage)
            ->offset(($page - 1) * $perPage)
            ->get();
    }

    public function getSitemapPriority(): ?float
    {
        return 0;
    }

    public function getSitemapChangefreq(): ?SitemapChangeFreqEnum
    {
        return null;
    }

    public function getSitemapLastmod(): ?Carbon
    {
        return $this->updated_at ?? null;
    }
}
