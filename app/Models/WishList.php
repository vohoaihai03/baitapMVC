<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class WishList extends Model
{
    use HasFactory;

    protected $table = 'wish_list';

    protected $fillable = ['user_id', 'id_hotel'];
    public $timestamps = false;

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'id_hotel');
    }
}
