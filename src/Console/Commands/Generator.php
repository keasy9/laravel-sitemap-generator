<?php

namespace Keasy9\SitemapGenerator\Console\Commands;

use Illuminate\Console\Command;
use Keasy9\SitemapGenerator\Services\SitemapGeneratorService;

class Generator extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate sitemap';

    public function __construct(
        protected SitemapGeneratorService $sitemapService,
    )
    {
        parent::__construct();
    }

    public function handle()
    {
        if ($this->sitemapService->generate()) {
            $this->info('Sitemap generated.');
            return static::SUCCESS;
        }
        $this->error('Can\'t generate sitemap.');
        return 1;
    }
}
