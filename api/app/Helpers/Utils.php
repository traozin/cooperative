<?php

namespace App\Helpers;

class Utils {
    private static function validarCPF(string $cpf): bool {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $digitoVerificador = ((10 * $d) % 11) % 10;
            if ((int) $cpf[$t] !== $digitoVerificador) {
                return false;
            }
        }

        return true;
    }

    private static function validarCNPJ(string $cnpj): bool {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $tamanho = strlen($cnpj) - 2;
        $numeros = substr($cnpj, 0, $tamanho);
        $digitos = substr($cnpj, $tamanho);
        $soma = 0;
        $pos = $tamanho - 7;

        for ($i = $tamanho; $i >= 1; $i--) {
            $soma += $numeros[$tamanho - $i] * $pos--;
            if ($pos < 2)
                $pos = 9;
        }

        $resultado = ($soma % 11 < 2) ? 0 : 11 - ($soma % 11);
        if ($resultado != $digitos[0])
            return false;

        $tamanho++;
        $numeros = substr($cnpj, 0, $tamanho);
        $soma = 0;
        $pos = $tamanho - 7;

        for ($i = $tamanho; $i >= 1; $i--) {
            $soma += $numeros[$tamanho - $i] * $pos--;
            if ($pos < 2)
                $pos = 9;
        }

        $resultado = ($soma % 11 < 2) ? 0 : 11 - ($soma % 11);
        return $resultado == $digitos[1];
    }

    public static function validarCpfCnpj(?string $documento): bool {
        if (!$documento) {
            return false;
        }

        $documento = preg_replace('/\D/', '', $documento);

        if (strlen($documento) === 11) {
            return self::validarCPF($documento);
        }

        if (strlen($documento) === 14) {
            return self::validarCNPJ($documento);
        }

        return false;
    }
}
