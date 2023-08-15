<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'poll_id',
    ];
    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function poll(){
        return $this->belongsTo(Poll::class);
    }
}

