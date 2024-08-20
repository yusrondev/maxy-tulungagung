<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    protected $fillable = [
        'website_name', 'logo', 'image', 'primary_color', 'secondary_color',
    ];
}
