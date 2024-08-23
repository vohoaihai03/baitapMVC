<?php

namespace App\GraphQL\Queries;

use App\Services\ElasticsearchService;
use App\Models\Address;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class SearchAddresses
{
    private $elasticsearch;

    public function __construct(ElasticsearchService $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function resolveKeyword($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $keyword = $args['keyword'] ?? '';
        $page = $args['page'] ?? 1;
        $perPage = $args['perPage'] ?? 10;

        $esResults = $this->elasticsearch->searchAddressIds($keyword, $page, $perPage);

        if (empty($esResults['ids'])) {
            return [
                'data' => [],
                'pagination' => [
                    'currentPage' => $page,
                    'perPage' => $perPage,
                    'total' => 0,
                ],
            ];
        }

        $address = Address::whereIn('id', $esResults['ids'])
            ->orderBy('ratings_and_comments', 'desc')
            ->get();

        return [
            'data' => $address,
            'pagination' => [
                'currentPage' => $page,
                'perPage' => $perPage,
                'total' => $esResults['total'],
            ],
        ];
    }


    public function resolveNearby($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $page = $args['page'] ?? 1;
        $perPage = $args['perPage'] ?? 10;

        $esResults = $this->elasticsearch->searchNearby(
            $args['lat'],
            $args['lon'],
            $args['distance'] ?? '10km',
            $page,
            $perPage
        );

        if (empty($esResults['ids'])) {
            return [
                'data' => [],
                'pagination' => [
                    'currentPage' => $page,
                    'perPage' => $perPage,
                    'total' => 0,
                ],
            ];
        }

        $address = Address::whereIn('id', $esResults['ids'])
            ->orderBy('ratings_and_comments', 'desc')
            ->get();

        return [
            'data' => $address,
            'pagination' => [
                'currentPage' => $page,
                'perPage' => $perPage,
                'total' => $esResults['total'],
            ],
        ];
    }

    public function resolveRecommendedAccommodationsNearby($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        $page = $args['page'] ?? 1;
        $perPage = $args['perPage'] ?? 10;

        $esResults = $this->elasticsearch->searchRecommendedAccommodationsNearby(
            $args['type_hotel'],
            $args['lat'],
            $args['lon'],
            $args['maxDistance'] ?? '10km',
            $args['minRating'] ?? 4.0,
            $page,
            $perPage
        );

        if (empty($esResults['ids'])) {
            return [
                'data' => [],
                'pagination' => [
                    'currentPage' => $page,
                    'perPage' => $perPage,
                    'total' => 0,
                ],
            ];
        }

        $address = Address::whereIn('id', $esResults['ids'])
            ->orderBy('ratings_and_comments', 'desc')
            ->get();

        return [
            'data' => $address,
            'pagination' => [
                'currentPage' => $page,
                'perPage' => $perPage,
                'total' => $esResults['total'],
            ],
        ];
    }

    public function resolveTopRatedAccommodationsNearby($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        $type = $args['type_hotel'];
        $lat = $args['lat'];
        $lon = $args['lon'];
        $maxDistance = $args['maxDistance'] ?? '10km';
        $minRating = $args['minRating'] ?? 4.0;
        $page = $args['page'] ?? 1;
        $perPage = $args['perPage'] ?? 10;
    
        $esResults = $this->elasticsearch->searchTopRatedAccommodationsNearby(
            $type,
            $lat,
            $lon,
            $maxDistance,
            $minRating,
            $page,
            $perPage
        );
    
        if (empty($esResults['ids'])) {
            return [
                'data' => [],
                'pagination' => [
                    'currentPage' => $page,
                    'perPage' => $perPage,
                    'total' => 0,
                ],
            ];
        }
    
        $address = Address::whereIn('id', $esResults['ids'])
            ->orderBy('ratings_and_comments', 'desc')
            ->get();
    
        return [
            'data' => $address,
            'pagination' => [
                'currentPage' => $page,
                'perPage' => $perPage,
                'total' => $esResults['total'],
            ],
        ];
    }
}
