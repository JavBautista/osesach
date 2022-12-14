<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function directory(){
        return $this->belongsTo(Directory::class);
    }

    public function status(){
        return $this->belongsTo(VisitingStatus::class);
    }
}
