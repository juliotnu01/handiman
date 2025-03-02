<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ReviewUser extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'reviewer_name', // Añadimos el nuevo atributo
    ];

    // Relación con el modelo User para el reviewer
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    // Accesor para obtener el nombre del reviewer
    protected function reviewerName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->reviewer ? $this->reviewer->name : 'N/A',
        );
    }
}
