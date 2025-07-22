<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cooperado extends Model {
    /** @use HasFactory<\Database\Factories\CooperadoFactory> */
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpf_cnpj',
        'data_nascimento_constituicao',
        'renda_faturamento',
        'telefone',
        'email',
    ];
}
