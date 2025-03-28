<?php

namespace App\Traits;

use App\Models\VerificationEmail; // Corregido el nombre del modelo
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCode;

trait EmailVerifiable
{
    public function sendEmailVerificationNotification()
    {
        $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        VerificationEmail::updateOrCreate(
            ['user_id' => $this->id],
            [
                'code' => $code,
                'expires_at' => Carbon::now()->addMinutes(60), // Código expira en 60 minutos
                'verified' => false
            ]
        );

        Mail::to($this->email)->send(new VerificationCode($code, $this));
    }

    public function verifyEmail($code)
    {
        $verification = VerificationEmail::where('user_id', $this->id)
            ->where('code', $code)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if ($verification) {
            $verification->update([
                'verified' => true,
                'verified_at' => Carbon::now(),
            ]);

            $this->markEmailAsVerified(); // Marca el email del usuario como verificado
            return true;
        }

        return false;
    }

    public function markEmailAsVerified()
    {
        $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }
}