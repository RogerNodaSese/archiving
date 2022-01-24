<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Thesis;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'path'
    ];

    public function thesis()
    {
        return $this->belongsTo(Thesis::class, 'id', 'file_id');
    }
}
