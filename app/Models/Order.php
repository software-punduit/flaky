<?php

namespace App\Models;

use App\Models\Constants;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';

    const STATUS_COMPLETED = 'completed';

    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'sub_total',
        'discount',
        'net_total',
        'status',
        'restaurant_id',
        'restaurant_owner_id',
        'order_number'
    ];

    public static function getStatusList()
    {
        return [
            self::STATUS_COMPLETED,
            self::STATUS_PENDING,
            self::STATUS_CANCELLED,
        ];
    }

    public static function getOrderNumber()
    {
        return Str::random(10);
    }


    protected function subTotal(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ($value  / Constants::PENCE_TO_POUNDS),
            set: fn (string $value) => ($value * Constants::PENCE_TO_POUNDS),
        );
    }

    protected function discount(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ($value  / Constants::PENCE_TO_POUNDS),
            set: fn (string $value) => ($value * Constants::PENCE_TO_POUNDS),
        );
    }

    protected function netTotal(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ($value  / Constants::PENCE_TO_POUNDS),
            set: fn (string $value) => ($value * Constants::PENCE_TO_POUNDS),
        );
    }

    /**
     * Get all of the orderItems for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the restaurant that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
