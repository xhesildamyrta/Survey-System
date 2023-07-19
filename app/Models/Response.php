<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'computer_id',
        'poll_id',
        'answer_id',
    ];
    public function poll(){
        return $this->belongsTo(Poll::class);
    }
}
