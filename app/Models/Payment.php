<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['complaint_id', 'payment_token', 'amount','status'];
    
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}
