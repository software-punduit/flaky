<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantTable extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    const PENCE_TO_POUNDS= 100;
    const MEDIA_COLLECTION = 'restaurant-tables';

    protected $fillable = [
        'restaurant_id',
        'name',
        'reservation_fee', 
        'active'
    ];

    protected $appends = [
        'photo_url'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION)
            ->singleFile();
            // ->useFallbackPath(asset('dist/img/user2-160x160.jpg'))
            // ->useFallbackUrl('/dist/img/user2-160x160.jpg');
    }


    protected function photoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl(self::MEDIA_COLLECTION)
        );
    }

    function restaurant() : BelongsTo {

       return $this->belongsTo(Restaurant::class); 
    }

    protected function reservationFee():Attribute {
        return Attribute::make(
            set:fn (string $value) => ($value * SELF::PENCE_TO_POUNDS),
            get:fn (string $value) => ($value / SELF::PENCE_TO_POUNDS),
        );
    }
}
