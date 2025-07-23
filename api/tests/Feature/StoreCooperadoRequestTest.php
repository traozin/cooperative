<?php
namespace Tests\Unit\Http\Requests;

use App\Http\Requests\StoreCooperadoRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreCooperadoRequestTest extends TestCase {
    use RefreshDatabase;

    public function test_store_cooperado_request_validation_rules() {
        $request = new StoreCooperadoRequest();

        $rules = $request->rules();

        $this->assertArrayHasKey('nome', $rules);
        $this->assertArrayHasKey('cpf_cnpj', $rules);
        $this->assertArrayHasKey('data_nascimento_constituicao', $rules);
        $this->assertArrayHasKey('renda_faturamento', $rules);
        $this->assertArrayHasKey('telefone', $rules);
        $this->assertArrayHasKey('email', $rules);
    }

    public function test_store_cooperado_request_validates_correctly() {
        $data = [
            'nome' => 'João',
            'cpf_cnpj' => '12345678900',
            'data_nascimento_constituicao' => '2000-01-01',
            'renda_faturamento' => 5000,
            'telefone' => '(11) 99999-9999',
            'email' => 'teste@example.com',
        ];

        $request = new StoreCooperadoRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_store_cooperado_request_fails_with_invalid_data() {
        $data = [
            'nome' => '',
            'cpf_cnpj' => '',
            'data_nascimento_constituicao' => 'invalid-date',
            'renda_faturamento' => 'texto',
            'telefone' => 'telefone-invalido',
            'email' => 'not-an-email',
        ];

        $request = new StoreCooperadoRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
    }
}
