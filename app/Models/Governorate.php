<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    //
    protected $fillable = ['name'];
    public $casts=[
            'id'=>'integer',
        ];
    public function subservices()
    {
        return $this->hasMany(Service::class);
    }
    public function centerGovernorates()
    {
        return $this->hasMany(CenterGovernorate::class);
    }
}
