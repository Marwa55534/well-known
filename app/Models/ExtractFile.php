<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtractFile extends Model
{
    protected $fillable = ['document_id', 'file_path'];


    public function Document()
{
    return $this->belongsTo(Document::class);
}
}
