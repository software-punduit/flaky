<?php

namespace App\Models;

use App\Models\Constants;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'menu_id',
        'restaurant_id',
        'restaurant_owner_id',
        'quantity',
        'total',
        'user_id'
    ];

    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ($value  / Constants::PENCE_TO_POUNDS),
            set: fn (string $value) => ($value * Constants::PENCE_TO_POUNDS),
        );
    }

    /**
     * Get the menu that owns the OrderItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}
