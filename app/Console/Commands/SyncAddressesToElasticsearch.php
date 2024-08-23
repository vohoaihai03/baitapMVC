<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Address;
use App\Services\ElasticsearchService;

class SyncAddressesToElasticsearch extends Command
{
    protected $signature = 'sync:addresses';

    protected $description = 'Sync addresses data to Elasticsearch';

    protected $elasticsearchService;

    public function __construct(ElasticsearchService $elasticsearchService)
    {
        parent::__construct();

        $this->elasticsearchService = $elasticsearchService;
    }

    public function handle()
    {
        $addresses = Address::all();

        foreach ($addresses as $address) {
            $this->elasticsearchService->indexAddress($address);
        }

        $this->info('Sync completed!');
    }
}
