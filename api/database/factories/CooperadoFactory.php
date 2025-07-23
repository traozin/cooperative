<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cooperado>
 */
class CooperadoFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'nome' => $this->faker->name(),
            'cpf_cnpj' => $this->faker->unique()->numerify('###########'), // ou cnpj
            'data_nascimento_constituicao' => $this->faker->date(),
            'renda_faturamento' => $this->faker->randomFloat(2, 1000, 100000),
            'telefone' => $this->faker->numerify('(##) #####-####'),
            'email' => $this->faker->safeEmail(),
        ];
    }
}
