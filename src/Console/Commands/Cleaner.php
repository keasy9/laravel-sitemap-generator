<?php

namespace Keasy9\SitemapGenerator\Console\Commands;

use Illuminate\Console\Command;
use Keasy9\SitemapGenerator\Services\SitemapGeneratorService;

class Cleaner extends Command
{
    protected $signature = 'sitemap:clear';

    protected $description = 'Delete all sitemap files';

    public function __construct(
        protected SitemapGeneratorService $sitemapService,
    )
    {
        parent::__construct();
    }

    public function handle()
    {
        if ($this->sitemapService->clearSitemap()) {
            $this->info('Sitemap cleared.');
            return static::SUCCESS;
        }
        $this->error('Can\'t clear sitemap.');
        return 1;
    }
}
