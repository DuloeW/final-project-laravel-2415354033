<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'email',
    'phone',
    'address',
    'status',
])]
class Customer extends Model
{
    protected function casts():array
    {
        return [
            "status" => "boolean",
        ];
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
