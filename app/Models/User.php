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
use App\Traits\EmailVerifiable;
use App\Models\DireccionesUser;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use EmailVerifiable;

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
        'has_approved_certifications',
        'has_active_payment_methods',
        'review_stats', 
        'addresses',
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
    
    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class, 'user_id');
    }

    public function reviewUsers()
    {
        return $this->hasMany(ReviewUser::class);
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

    /**
     * Definir el atributo personalizado `has_approved_certifications`.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function hasApprovedCertifications(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->checkApprovedCertifications(),
        );
    }

    /**
     * Método privado para verificar si el usuario tiene una o más certificaciones aprobadas.
     *
     * @return bool
     */
    private function checkApprovedCertifications(): bool
    {
        return $this->certifications()
            ->where('is_verified', true)
            ->exists();
    }

    /**
     * Definir el atributo personalizado `has_active_payment_methods`.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function hasActivePaymentMethods(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->checkActivePaymentMethods(),
        );
    }

    /**
     * Definir el atributo personalizado `addresses`.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function addresses(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getAllAddresses(),
        );
    }

    /**
     * Método privado para obtener todas las direcciones asociadas al usuario.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getAllAddresses()
    {
        return $this->hasMany(DireccionesUser::class, 'user_id')->get();
    }

    /**
     * Método privado para verificar si el usuario tiene uno o más métodos de pago activos.
     *
     * @return bool
     */
    private function checkActivePaymentMethods(): bool
    {
        return $this->paymentMethods()
            ->where('status', true)
            ->exists();
    }

    /**
     * Definir el atributo personalizado `review_stats`.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function reviewStats(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->calculateReviewStats(),
        );
    }

    /**
     * Método privado para calcular las estadísticas de reviews.
     *
     * @return object
     */
    private function calculateReviewStats(): object
    {
        $reviews = $this->reviewUsers();
        $count = $reviews->count();
        $average = $reviews->avg('score');

        return (object) [
            'count' => $count,
            'average' => $average,
        ];
    }

    public function emailVerification()
    {
        return $this->hasOne(VerificationEmail::class);
    }

}
