<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mode'
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
        'has_all_verifications',
    ];

    public function basicInformation()
    {
        return $this->hasOne(BasicInformationUser::class, 'user_id');
    }

    public function verificationIds()
    {
        return $this->belongsToMany(VerificationID::class, 'user_verificationid', 'user_id', 'verification_id');
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class, 'user_id');
    }

    /**
     * Definir el atributo personalizado `has_all_verifications`.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function hasAllVerifications(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->checkAllVerifications(),
        );
    }

    /**
     * Método privado para verificar si el usuario tiene todas las verificaciones requeridas.
     *
     * @return bool
     */
    private function checkAllVerifications(): bool
    {
        $requiredTypes = ['front', 'back'];
        $hasAllVerifications = $this->verificationIds()
            ->whereIn('type', $requiredTypes)
            ->where('is_verified', true)
            ->pluck('type')
            ->unique()
            ->count() === count($requiredTypes);

        return $hasAllVerifications;
    }
}
