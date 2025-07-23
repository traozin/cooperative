<?php

namespace Tests\Feature;

use App\Models\Cooperado;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CooperadoRoutesTest extends TestCase {
    
    use RefreshDatabase;

    public function test_ping_route_returns_pong() {
        $response = $this->getJson('/api/v1/ping');

        $response->assertOk()
            ->assertJsonStructure(['message']);
    }

    public function test_create_cooperado() {
        $payload = [
            'nome' => 'João',
            'cpf_cnpj' => '62806045002',
            'data_nascimento_constituicao' => '2000-01-01',
            'renda_faturamento' => 8000,
            'telefone' => '(11) 99999-9999',
            'email' => 'joao@example.com',
        ];

        $response = $this->postJson('/api/v1/cooperados', $payload);

        $response->assertCreated()
            ->assertJsonFragment(['nome' => 'João']);
    }

    public function test_list_cooperados() {
        Cooperado::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/cooperados');

        $response->assertOk()
            ->assertJsonCount(3);
    }

    public function test_show_cooperado() {
        $cooperado = Cooperado::factory()->create();

        $response = $this->getJson("/api/v1/cooperados/{$cooperado->id}");

        $response->assertOk()
            ->assertJsonFragment(['id' => $cooperado->id]);
    }

    public function test_update_cooperado() {
        $cooperado = Cooperado::factory()->create();

        $response = $this->putJson("/api/v1/cooperados/{$cooperado->id}", [
            'nome' => 'Atualizado',
            'cpf_cnpj' => '08540740079',
            'data_nascimento_constituicao' => $cooperado->data_nascimento_constituicao,
            'renda_faturamento' => $cooperado->renda_faturamento,
            'telefone' => $cooperado->telefone,
            'email' => $cooperado->email,
        ]);

        $response->assertOk()
            ->assertJsonFragment(['nome' => 'Atualizado']);
    }

    public function test_delete_cooperado() {
        $cooperado = Cooperado::factory()->create();

        $response = $this->deleteJson("/api/v1/cooperados/{$cooperado->id}");

        $response->assertNoContent();
        $this->assertDatabaseMissing('cooperados', ['id' => $cooperado->id]);
    }
}