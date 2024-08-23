<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address';

    protected $fillable = [
        'user_id',
        'email',
        'type_address',
        'business_model',
        'status',
        'name_hotel',
        'tel_hotel',
        'address',
        'full_address',
        'city',
        'zipcode',
        'city_search',
        'district',
        'district_search',
        'ward',
        'ward_search',
        'country_code',
        'summary',
        'phone_2',
        'image_url',
        'website',
        'coordinates',
        'place_id',
        'services',
        'latitude',
        'longitude',
        'ratings_and_comments',
        'average_price',
        'intro_text',
        'google_map'
    ];

    public function saleOrders()
    {
        return $this->hasMany(SaleOrder::class, 'hotel_id');
    }
}
