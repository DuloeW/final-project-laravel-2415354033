<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'customer_id',
    'service_id',
    'start_date',
    'end_date',
    'status',
])]
class Subscription extends Model
{
    protected function casts():array
    {
        return [
            "start_date" => "date",
            "end_date" => "date",
        ];
    }
}
