<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\College;
use App\Models\Role;
use App\Models\Thesis;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        // 'college_id',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function theses()
    {
        return $this->hasMany(Thesis::class);
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdministrator()
    {
        return $this->role()->where('description','admin')->exists();
    }

    public function isStudent()
    {
        return $this->role()->where('description','student')->exists();
    }

    public function isStaff()
    {
        return $this->role()->where('description','staff')->exists();
    }
}
