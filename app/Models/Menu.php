<?php

namespace App\Models;


use App\Models\User;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Menu extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    const MEDIA_COLLECTION = 'menu-items';

    protected $fillable = [
        'restaurant_id',
        'restaurant_owner_id',
        'name',
        'price',
        'active'
    ];

    protected function price(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ($value * CONSTANTS::PENCE_TO_POUNDS),
            get: fn (string $value) => ($value / CONSTANTS::PENCE_TO_POUNDS),
        );
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION)
            ->singleFile();
        // ->useFallbackPath(asset('dist/img/menu-placeholder.jpg'))
        // ->useFallbackUrl('/dist/img/menu-placeholder.jpg');
    }

    protected function photoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl(self::MEDIA_COLLECTION),
        );
    }

    /**
     * Get the restaurantOwner that owns the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function RestaurantOwner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'restaurant_owner_id');
    }

    /**
     * Get the restaurant that owns the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}
