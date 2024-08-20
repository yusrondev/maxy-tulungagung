<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat_content extends Model
{
    protected $fillable = [
        'username_font', 'chat_font', 'username_color', 'chat_color', 'chat_sizeName', 'chat_size',
    ];
}
