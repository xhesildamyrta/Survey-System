<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'poll_id'
      ];

    public function question(){
        return $this->belongsTo(Poll::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
