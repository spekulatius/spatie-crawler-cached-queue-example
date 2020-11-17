<?php

namespace App\Console\Commands;

use Spatie\Crawler\Crawler;
use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:run {site}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepares and runs the crawler';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $queue = null;
        $site = $this->argument('site');

        if (is_null($queue)) {
            $this->info('Preparing a new crawler queue');

            $queue = new \Spekulatius\SpatieCrawlerToolkit\Queues\CacheCrawlQueue($site);
        }

        // Crawler
        $this->info('Start crawling');

        Crawler::create()
            ->addCrawlObserver(new \Spekulatius\SpatieCrawlerToolkit\Observers\CrawlLogger)
            ->setTotalCrawlLimit(5)
            ->setCrawlQueue($queue)
            ->setCrawlProfile(new \Spatie\Crawler\CrawlProfiles\CrawlSubdomains($site))
            ->startCrawling($site);

        $this->info('Finished crawling');

        $this->info($queue->hasPendingUrls() ? 'Has URLs left' : 'Has no URLs left');

        return 0;
    }
}
