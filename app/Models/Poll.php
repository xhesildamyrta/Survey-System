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

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function responses(){
        return $this->hasMany(Response::class);
    }
}
