<?php

namespace App\Models;

use App\Models\Profile;
use App\Models\RestaurantStaff;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use \Illuminate\Auth\MustVerifyEmail;
    use InteractsWithMedia;
    use HasRoles;


    const AVATAR_COLLECTION = 'avatars';

    const ADMIN = 'admin';

    const SUPER_ADMIN = 'super admin';

    const RESTUARANT_OWNER = 'restuarant owner';

    const RESTUARANT_STAFF = 'restuarant staff';

    const CUSTOMERS = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $with = [
        'wallet'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'avatar_url',
        'highest_role',
        'active'
    ];
    /**
     * Get the profile associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::AVATAR_COLLECTION)
            ->singleFile()
            ->useFallbackPath(asset('dist/img/user2-160x160.jpg'))
            ->useFallbackUrl('/dist/img/user2-160x160.jpg');
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl(self::AVATAR_COLLECTION)
        );
    }


    protected function highestRole(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getHighestRole()
        );
    }

    protected function active(): Attribute
    {
        return Attribute::make(
            get: fn () => is_null($this->profile) ? false : $this->profile->active
        );
    }

    public function getHighestRole()
    {
        if ($this->hasRole(self::SUPER_ADMIN)) {
            return self::SUPER_ADMIN;
        } else if ($this->hasRole(self::ADMIN)) {
            return self::ADMIN;
        } else if ($this->hasRole(self::RESTUARANT_OWNER)) {
            return self::RESTUARANT_OWNER;
        } else if ($this->hasRole(self::RESTUARANT_STAFF)) {
            return self::RESTUARANT_STAFF;
        } else {
            return self::CUSTOMERS;
        }
    }

    /**
     * Get all of the restaurants for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function restaurants(): HasMany
    {
        return $this->hasMany(Restaurant::class);
    }

    /**
     * Get all of the restaurantStaff for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function restaurantStaff(): HasManyThrough
    {
        return $this->hasManyThrough(RestaurantStaff::class, Restaurant::class);
    }
    public function restaurantTables(): HasManyThrough
    {
        return $this->hasManyThrough(RestaurantTable::class, Restaurant::class);
    }

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class, 'restaurant_owner_id');
    }

    /**
     * Get all of the Order for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Order(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all of the restaurantOwnerOrders for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function restaurantOwnerOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'restaurant_owner_id');
    }

    /**
     * Get all of the restaurantStaffOrders for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function restaurantStaffOrders(): HasManyThrough
    {
        return $this->hasManyThrough(Order::class, RestaurantStaff::class, 'staff_id', 'restaurant_id');
    }

    /**
     * Get the wallet associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }
}
