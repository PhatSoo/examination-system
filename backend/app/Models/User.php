<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, CanResetPassword;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function categories() {
        return $this->hasMany(Category::class);
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }

    // Custom method
    public function sendPasswordResetNotification($token) {
        $url = env('APP_URL') . ":8000/api/v1/reset-password?token=$token";

        $this->notify(new ResetPasswordNotification($url));
    }
}