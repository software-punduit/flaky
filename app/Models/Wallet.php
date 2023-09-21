<?php

namespace App\Models;

use App\Models\Constants;
use App\Traits\ConvertsDenominations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory, ConvertsDenominations;

    protected $fillable = [
        'user_id',
        'balance'
    ];

    protected function balance(): Attribute
    {
        return $this->convertDenomination();
    }
}
