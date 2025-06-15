<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = ['title', 'description','amount','is_paid','payment_order_id','payment_token'];

    public function files()
{
    return $this->hasMany(Attachment::class);
}


public function payment()
{
    return $this->morphOne(Payment::class, 'related', 'type', 'related_id');
}
}
