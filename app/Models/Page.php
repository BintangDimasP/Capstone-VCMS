<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title', 'slug', 'content'];

    // TAMBAHKAN INI
    protected $casts = [
        'content' => 'array',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class)->orderBy('order');
    }
}