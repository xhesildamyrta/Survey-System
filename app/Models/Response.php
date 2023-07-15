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
        // 'question_id',
        // 'answer_id',
        'selected_option',
    ];
}
