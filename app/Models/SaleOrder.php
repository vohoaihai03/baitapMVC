<?php

namespace App\Models;

use App\Models\Address;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleOrder extends Model
{
    use HasFactory;

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'hotel_id');
    }
}
