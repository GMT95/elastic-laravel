<?php

namespace App\Console\Commands;
use App\Models\Headline;
use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;

class ReindexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all headlines to Elasticsearch';

    /** @var \Elasticsearch\Client */
    private $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
    }

    public function handle()
    {
        $this->info('Indexing all Headlines. This might take a while...');

        foreach (Headline::cursor() as $headline)
        {
            
            $this->elasticsearch->index([
                'index' => $headline->getSearchIndex(),
                'type' => $headline->getSearchType(),
                'id' => $headline->getKey(),
                'body' => $headline->toSearchArray(),
            ]);

            // PHPUnit-style feedback
            $this->output->write('.');
        }

        $this->info("\nDone!");
    }
}