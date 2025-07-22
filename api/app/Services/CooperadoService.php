<?php

namespace App\Services;

use App\Models\Cooperado;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Helpers\Utils;

class CooperadoService {
    public function create(array $data): Cooperado {
        try {
            if (!Utils::validarCpfCnpj($data['cpf_cnpj'] ?? null)) {
                throw new Exception('CPF ou CNPJ inválido.');
            }

            return Cooperado::create($data);
        } catch (Exception $e) {
            Log::error('Erro ao criar cooperado', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function update(Cooperado $cooperado, array $data): Cooperado {
        try {
            if (isset($data['cpf_cnpj']) && !Utils::validarCpfCnpj($data['cpf_cnpj'])) {
                throw new Exception('CPF ou CNPJ inválido.');
            }

            $cooperado->update($data);
            return $cooperado->refresh();
        } catch (Exception $e) {
            Log::error('Erro ao atualizar cooperado', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
