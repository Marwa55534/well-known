<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SubServiceGovernment;
class SubService extends Model
{
    //
    protected $fillable = ['title', 'description', 
     'image', 'whatsapp', 'phone', 'service_id','governorate_id',
    'center_governorate_id',];
     public $casts=[
            'service_id'=>'integer',
            'governorate_id'=>'integer',
            'center_governorate_id'=>'integer',
        ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    public function centerGovernorate()
    {
        return $this->belongsTo(CenterGovernorate::class);
    }
    public function subServicesGovernments(){
        return $this->hasMany(SubServiceGovernment::class);
    } 


}
