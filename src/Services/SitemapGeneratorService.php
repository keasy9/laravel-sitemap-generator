<?php

namespace Keasy9\SitemapGenerator\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class SitemapGeneratorService
{
    protected array $sources = [];

    public function registerSource(string $source): static
    {
        if (!in_array($source, $this->sources)) {
            $this->sources[] = $source;
        }

        return $this;
    }

    public function generate(): bool
    {
        if (empty($this->sources)) {
            return true;
        }

        $linksPerFile = config('sitemap-generator.links_per_file');
        $sitemaps = [];

        foreach ($this->sources as $source) {
            $page = 1;
            $items = $source::getSitemapList($linksPerFile, $page);
            while ($items->isNotEmpty()) {
                $tags = [];
                foreach ($items as $item) {
                    $tags[] = [
                        'tag'        => 'url',
                        'loc'        => $item->getSitemapUrl(),
                        'lastmod'    => $item->getSitemapLastMod(),
                        'changefreq' => $item->getSitemapChangeFreq(),
                        'priority'   => $item->getSitemapPriority(),
                    ];
                }

                $sitemap = sprintf(
                    config('sitemap-generator.sitemap_filename'),
                    count($sitemaps),
                );

                $sitemaps[] = [
                    'tag'     => 'sitemap',
                    'loc'     => url($sitemap),
                    'lastmod' => Carbon::now(),
                ];

                if (!$this->writeSitemapFile(
                    public_path($sitemap),
                    view('sitemap-generator::sitemap', ['tags' => $tags])->render()
                )) {
                    $this->clearSitemap();
                    return false;
                }

                $page++;
                $items = $source::getSitemapList($linksPerFile, $page);
            }
        }

        if (!$this->writeSitemapFile(
            public_path(config('sitemap-generator.index_sitemap_filename')),
            view('sitemap-generator::sitemap', ['tags' => $sitemaps, 'rootTag' => 'sitemapindex'])->render()
        )) {
            $this->clearSitemap();
            return false;
        }

        return true;
    }

    public function clearSitemap(): bool
    {
        $files = glob(str_replace('%s', '*', public_path(config('sitemap-generator.sitemap_filename'))), GLOB_NOSORT);
        $files[] = public_path(config('sitemap-generator.index_sitemap_filename'));

        $result = true;
        foreach ($files as $file) {
            try {
                unlink($file);
            } catch (Exception $e) {
                $result = false;
                Log::channel('daily')->error($e->getMessage());
            }
        }

        return $result;
    }

    public function getSitemapDate(): ?Carbon
    {
        if (!$this->isSitemapExists()) {
            return null;
        }

        return Carbon::createFromTimestamp(filemtime($this->getSitemapPath()));
    }

    public function isSitemapExists(): bool
    {
        return file_exists($this->getSitemapPath());
    }

    public function getSitemapUrl(): string
    {
        return url(config('sitemap-generator.index_sitemap_filename'));
    }

    public function getSitemapPath(): string
    {
        return public_path(config('sitemap-generator.index_sitemap_filename'));
    }

    protected function writeSitemapFile(string $path, string $sitemapContent): bool
    {
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        try {
            file_put_contents($path, $sitemapContent);
        } catch (Exception $e) {
            Log::channel('daily')->error($e->getMessage());
            return false;
        }
        return true;
    }
}
