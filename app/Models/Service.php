<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Override;

#[Fillable([
    'name',
    'price',
    'description',
    'status',
])]
class Service extends Model
{
    #[Override]
    protected function casts():array
    {
        return [
            "status" => "boolean",
            "price" => "integer",
        ];
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
