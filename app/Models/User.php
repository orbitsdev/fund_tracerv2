<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];


    public function assigned_project(): MorphOne
    {
        return $this->morphOne(AssignedProject::class, 'assigned_projectable');
    }

    public function is_admin(): bool{
        return $this->role == 'Admin';
    }
    public function is_financial(): bool{
        return $this->role == 'Financial Manager';
    }

    public function getUserImage()
    {
        switch ($this->account_type) {
            case 'Ordinary':
                if (!empty($this->profile_photo_path)) {
                    return asset('storage/' . $this->profile_photo_path);
                } else {
                    return asset('images/sksu.png');
                }
                break;
            case 'Google':
                return $this->google_profile ?? '';
                break;
            default:
                return asset('images/sksu.png');
                break;
        }
    }
    
}
