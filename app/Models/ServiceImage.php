<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceImage extends Model
{
    //
    protected $fillable = ['service_id', 'image_url'];
     public $casts=[
            'service_id'=>'integer',
        ];
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
