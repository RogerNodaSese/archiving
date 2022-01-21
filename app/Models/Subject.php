<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Thesis;

class Subject extends Model
{
    use HasFactory;

    public function theses()
    {
        return $this->belongsToMany(Thesis::class, 'subject_thesis', 'subject_id', 'thesis_id');
    }
}
