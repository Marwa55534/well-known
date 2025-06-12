<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $fillable = ['name', 'description', 'images',
];


    
    public function subServices()
    {
        return $this->hasMany(SubService::class);
    }
    public function images()
    {
        return $this->hasMany(ServiceImage::class);
    }
    
}
