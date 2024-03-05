<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class RegUser extends Model
{
    protected $table = "ent_registro";

    const CREATED_AT = 'fechacreacion';
    const UPDATED_AT = 'fechamodificacion';

    protected $fillable = [
        'nombres',
        'correo',
        'tokenredessociales',
        'usuario_id',
        'contrasenia_plataforma',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    // public function getEmailForPasswordReset() {
    //     return $this->correo;
    // }
}
