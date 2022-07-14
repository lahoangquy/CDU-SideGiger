<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    const ADMIN_ROLE = 'admin';
    const POSTER_ROLE = 'poster';
    const TASKER_ROLE = 'tasker';

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->name = $model->first_name . ' ' . $model->last_name;
            $model->password = Hash::make($model->password);
        });
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

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

    public function getRoleName(): String
    {
        return $this->getRoleNames()[0];
    }

    public function isPoster(): bool
    {
        return $this->getRoleNames()[0] === self::POSTER_ROLE;
    }

    public function isTasker(): bool
    {
        return $this->getRoleNames()[0] === self::TASKER_ROLE;
    }

    public function invites()
    {
        return $this->hasMany(Invite::class, 'student_id');
    }

    public function applicates(): HasMany
    {
        return $this->hasMany(ProjectOffer::class);
    }

    public function requestCompleted()
    {
        return $this->hasOne(RequestCompleted::class, 'student_id');
    }
}
