<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['title', 'description'];
    
        public function extractFiles()
{
    return $this->hasMany(ExtractFile::class);
}
}
