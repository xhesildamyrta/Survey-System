<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
      ];

    public function questions(){
        return $this->hasMany(Question::class);
    }


    public function responses(){
        return $this->hasMany(Response::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
