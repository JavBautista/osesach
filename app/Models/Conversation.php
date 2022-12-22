<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function supervisor(){
        return $this->belongsTo(Person::class);
    }

    public function agent(){
        return $this->belongsTo(Person::class);
    }
}
