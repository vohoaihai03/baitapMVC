<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'brand',
        'price',
        'discounted_price',
        'quantity',
        'availability',
        'available_color',
        'available_size',
        'promotions',
        'image_main',
        'image_gallery',
    ];

    /**
     * Accessor for available_color
     * Converts a comma-separated string to an array
     */
    public function getAvailableColorAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * Mutator for available_color
     * Converts an array to a comma-separated string
     */
    public function setAvailableColorAttribute($value)
    {
        $this->attributes['available_color'] = is_array($value) ? implode(',', $value) : $value;
    }

    /**
     * Accessor for available_size
     * Converts a comma-separated string to an array
     */
    public function getAvailableSizeAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * Mutator for available_size
     * Converts an array to a comma-separated string
     */
    public function setAvailableSizeAttribute($value)
    {
        $this->attributes['available_size'] = is_array($value) ? implode(',', $value) : $value;
    }

    /**
     * Accessor for image_gallery
     * Converts a comma-separated string to an array
     */
    public function getImageGalleryAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * Mutator for image_gallery
     * Converts an array to a comma-separated string
     */
    public function setImageGalleryAttribute($value)
    {
        $this->attributes['image_gallery'] = is_array($value) ? implode(',', $value) : $value;
    }
}
