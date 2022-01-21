<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\College;

class Directory extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'college_id'
    ];

    public function college()
    {
       $this->belongsTo(College::class, 'college_id', 'id'); 
    }
}
