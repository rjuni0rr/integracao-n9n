<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    // const indica que o valor é uma constante, não pode ser alterado durante a execução do programa.
    public const STATUS_PENDENTE = 'pendente';
    public const STATUS_ENVIADO = 'enviado';
    public const STATUS_ERRO = 'erro';


    protected $fillable = [

        'nome',
        'telefone',
        'cidade',

        'status_integracao',
        'enviado_em',
        'ultima_falha',

    ];

}
