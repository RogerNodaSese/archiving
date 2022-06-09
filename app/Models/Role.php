<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    //REMOVE
    public const ADMIN = 1;
    public const STUDENT = 2;
    public const STAFF = 3;
}
