<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Thesis;
use App\Models\College;

class Program extends Model
{
    use HasFactory;


    public function theses()
    {
        return $this->hasMany(Thesis::class,'program_id','id');
    }

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'id');
    }
    
}
