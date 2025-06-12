<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CenterGovernorate extends Model
{
    //
    protected $fillable = ['name', 'governorate_id'];
     public $casts=[
            'governorate_id'=>'integer',
        ];
    public function subservices()
    {
        return $this->hasMany(Service::class);
    }
    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }
}
