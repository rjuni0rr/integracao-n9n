<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    protected $fillable = [

        'nome',
        'telefone',
        'cidade',

        'status_integracao',
        'enviado_em',
        'ultima_falha',

    ];

}
