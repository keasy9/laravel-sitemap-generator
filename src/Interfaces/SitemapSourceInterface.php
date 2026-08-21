<?php

namespace Keasy9\SitemapGenerator\Interfaces;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Keasy9\SitemapGenerator\Enums\SitemapChangeFreqEnum;

interface SitemapSourceInterface
{
    public function getSitemapLastmod(): ?Carbon;

    public function getSitemapUrl(): string;

    public function getSitemapPriority(): ?float;

    public function getSitemapChangefreq(): ?SitemapChangeFreqEnum;

    /**
     * @param int $perPage
     * @param int $page
     * @return Collection<array-key, SitemapSourceInterface>
     */
    public static function getSitemapList(int $perPage, int $page): Collection;
}
