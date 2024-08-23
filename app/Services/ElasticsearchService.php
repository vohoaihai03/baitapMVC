<?php

namespace App\Services;

use  Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchService
{
    const STATUS = 1;
    private $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([env('ELASTICSEARCH_HOST', 'localhost:9200')])
            ->build();
    }

    public function indexAddress($address)
    {

        $params = [
            'index' => 'addresses',
            'id' => $address->id,
            'body' => [
                'id' => $address->id,
                'business_model' => $address->business_model,
                'name_hotel' => $address->name_hotel,
                'city' => $address->city,
                'district' => $address->district,
                'ward' => $address->ward,
                'tel_hotel' => $address->tel_hotel,
                'address' => $address->address,
                'zipcode' => $address->zipcode,
                'ratings_and_comments' => $address->ratings_and_comments,
                'average_price' => $address->average_price,
                'location'   => [
                    'lat' => (float) preg_replace('/[^0-9.-]/', '', $address->latitude),
                    'lon' => (float) preg_replace('/[^0-9.-]/', '', $address->longitude)
                ]
            ],
        ];

        $this->client->index($params);
    }

    public function deleteAddress($addressId)
    {
        $params = [
            'index' => 'addresses',
            'id' => $addressId,
        ];

        $response = $this->client->delete($params);

        return $response;
    }

    public function searchAddressIds($keyword, $page = 1, $perPage = 10)
    {
        $from = ($page - 1) * $perPage;
        $params = [
            'index' => 'addresses',
            'body'  => [
                'from' => $from,
                'size' => $perPage,
                'query' => [
                    'multi_match' => [
                        'query' => $keyword,
                        'fields' => ['name_hotel', 'city', 'district', 'ward'],
                    ],
                ],
            ]
        ];

        $response = $this->client->search($params);
        $ids = array_column($response['hits']['hits'], '_id');
        $totalHits = $response['hits']['total']['value'];

        return [
            'ids' => $ids,
            'total' => $totalHits
        ];
    }

    // Functipn make search nearby
    public function searchNearby($lat, $lon, $distance = '10km', $page = 1, $perPage = 10)
    {
        // pagging
        $from = ($page - 1) * $perPage;

        // params
        $params = [
            'index' => 'addresses',
            'body'  => [
                'from' => $from,
                'size' => $perPage,
                'query' => [
                    'bool' => [
                        'must' => [
                            'match_all' => new \stdClass()
                        ],
                        'filter' => [
                            'geo_distance' => [
                                'distance' => $distance,
                                'location' => [
                                    'lat' => $lat,
                                    'lon' => $lon
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $data= 1;
        if ($data == self::STATUS) {


        }

        // response
        $response = $this->client->search($params);
        $ids = array_column($response['hits']['hits'], '_id');
        $total = $response['hits']['total']['value'];

        return [
            'ids' => $ids,
            'total' => $total
        ];
    }

    public function searchNearbyLatLong($lat, $lon, $distance = '10km', $page = 1, $perPage = 10)
    {
        // pagging
        $from = ($page - 1) * $perPage;

       //  / params
        $params = [
            'index' => 'addresses',
            'body'  => [
                'from' => $from,
                'size' => $perPage,
                'query' => [
                    'bool' => [
                        'must' => [
                            'match_all' => new \stdClass()
                        ],
                        'filter' => [
                            'geo_distance' => [
                                'distance' => $distance,
                                'location' => [
                                    'lat' => $lat,
                                    'lon' => $lon
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        // response
        $response = $this->client->search($params);
        $ids = array_column($response['hits']['hits'], '_id');
        $total = $response['hits']['total']['value'];

        return [
            'ids' => $ids,
            'total' => $total
        ];
    }

    public function searchRecommendedAccommodationsNearby($type, $lat, $lon, $maxDistance = '10km', $minRating = 4.0, $page = 1, $size = 10)
    {
        $from = ($page - 1) * $size;
        $params = [
            'index' => 'addresses',
            'body'  => [
                'from' => $from,
                'size' => $size,
                'query' => [
                    'bool' => [
                        'must' => [
                            ['match' => ['business_model' => $type]],
                            ['range' => ['ratings_and_comments' => ['gte' => $minRating]]],
                        ],
                        'filter' => [
                            ['geo_distance' => [
                                'distance' => $maxDistance,
                                'location' => [
                                    'lat' => $lat,
                                    'lon' => $lon
                                ]
                            ]]
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->client->search($params);
        $hits = $response['hits']['hits'];
        $total = $response['hits']['total']['value']; 

        $ids = array_column($hits, '_id');

        return [
            'ids' => $ids,
            'total' => $total,
            'perPage' => $size,
            'page' => $page
        ];
    }

    public function searchTopRatedAccommodationsNearby($type, $lat, $lon, $maxDistance = '10km', $minRating = 4.0, $page = 1, $size = 10) {
        $from = ($page - 1) * $size;
        $params = [
            'index' => 'addresses',
            'body'  => [
                'from' => $from,
                'size' => $size,
                'sort' => [
                    'ratings_and_comments' => [
                        'order' => 'desc'
                    ]
                ],
                'query' => [
                    'bool' => [
                        'must' => [
                            ['match' => ['business_model' => $type]],
                            ['range' => ['ratings_and_comments' => ['gte' => $minRating]]],
                        ],
                        'filter' => [
                            ['geo_distance' => [
                                'distance' => $maxDistance,
                                'location' => [
                                    'lat' => $lat,
                                    'lon' => $lon
                                ]
                            ]]
                        ]
                    ]
                ]
            ]
        ];
    
        $response = $this->client->search($params);
        $hits = $response['hits']['hits'];
        $total = $response['hits']['total']['value'];
    
        $ids = array_column($hits, '_id');
    
        return [
            'ids' => $ids,
            'total' => $total,
            'perPage' => $size,
            'page' => $page
        ];
    }
    
}
