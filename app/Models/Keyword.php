<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Thesis;

class Keyword extends Model
{
    use HasFactory;

    public function theses()
    {
        return $this->belongsToMany(Thesis::class, 'keyword_thesis', 'keyword_id', 'thesis_id');
    }
}
