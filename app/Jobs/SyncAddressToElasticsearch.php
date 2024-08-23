<?php

namespace App\Jobs;

use App\Services\ElasticsearchService;
use App\Models\Address;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

class SyncAddressToElasticsearch implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $address;

    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    public function handle(ElasticsearchService $elasticsearchService)
    {
        $elasticsearchService->indexAddress($this->address);
    }
}
