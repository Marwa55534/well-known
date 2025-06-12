<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = ['title', 'description'];

    public function files()
{
    return $this->hasMany(Attachment::class);
}

public function payments()
{
    return $this->hasMany(Payment::class);
}
}
