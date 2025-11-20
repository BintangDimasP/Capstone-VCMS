<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['page_id', 'section_key', 'title', 'content', 'image', 'order'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
