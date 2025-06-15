<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['title', 'description','amount','payment_order_id','payment_token','is_paid'];
    
    public function extractFiles(){
        return $this->hasMany(ExtractFile::class);
    }

public function payment()
{
    return $this->morphOne(Payment::class, 'related', 'type', 'related_id');
}
}
