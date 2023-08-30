<?php 
namespace App\Traits;

trait ActivatesResource{
    //const ACTIVE = 1;
    //const INACTIVE = 0;

    public function scopeActive($query){
        return $query->where('active', self::ACTIVE);
    }
}

