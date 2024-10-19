<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialista extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function servicios()  {
        return $this->belongsToMany(TipoServicio::class);
    }

    public function certificados()  {
        return $this->hasMany(DocumentosEspecialista::class);
    }
}
