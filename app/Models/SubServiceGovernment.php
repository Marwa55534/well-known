<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubServiceGovernment extends Model
{
    //
    
    protected $fillable = ['sub_service_id', 'government_id','center_governorate_id'];
    public  $casts=[
            'government_id'=>'int',
            'center_governorate_id'=>'int',
            'sub_service_id'=>'int',
        ];
        public $table='sub_service_governments';

}
