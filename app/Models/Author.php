<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Thesis;

class Author extends Model
{
    use HasFactory;

    public function theses()
    {
        return $this->belongsToMany(Thesis::class, 'author_thesis', 'author_id', 'thesis_id');
    }
}
