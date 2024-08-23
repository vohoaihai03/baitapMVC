<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Address;
use App\Services\ElasticsearchService;

class SyncAddressesImage extends Command
{
    protected $signature = 'sync:image';

    protected $description = 'Sync addresses update image';

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
            if (!empty($address) && !empty($address->image_url)) {
                $data = explode("https://", $address->image_url);
                if (count($data) > 2) {
                    $address->image_url = str_replace('https://lh5.googleusercontent.com/p/', '', $address->image_url);
                    $address->save();
                }
            }
            
        }

        $this->info('Updated completed!');
    }
}
