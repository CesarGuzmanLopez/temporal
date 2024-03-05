<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntUsuario extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table="ent_usuario";
    protected $fillable = [
        
        'usuario',
        'contrasenia',
        'bloqueado',
        'password'
    ];    

    public function user_rol(){
        return $this->belongsTo(RmmUsuarioRol::class, 'id','usuario_id');
    }

    public function registro() { 

        return $this->belongsTo(EntRegistro::class, 'id','usuario_id');
    }
}
