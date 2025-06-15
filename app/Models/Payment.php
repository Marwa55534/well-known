<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
      'type',
    'related_id',
    'paymob_order_id',
    'paymob_payment_token',
    'amount',
    'status',
];

    public function related()
{
    return $this->morphTo();
}
}
