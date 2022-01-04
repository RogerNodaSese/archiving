<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program;

class College extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'slug'
    ];


    public function programs()
    {
        return $this->hasMany(Program::class);
    }

}
