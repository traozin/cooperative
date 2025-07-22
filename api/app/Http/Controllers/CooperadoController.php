<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreCooperadoRequest;
use App\Http\Requests\UpdateCooperadoRequest;
use App\Models\Cooperado;
use App\Services\CooperadoService;
use Illuminate\Http\JsonResponse;
use Exception;

class CooperadoController extends Controller {
    protected $cooperadoService;

    public function __construct(CooperadoService $cooperadoService) {
        $this->cooperadoService = $cooperadoService;
    }

    public function index(): JsonResponse {
        return response()->json(Cooperado::all());
    }

    public function store(StoreCooperadoRequest $request): JsonResponse {
        try {
            $cooperado = $this->cooperadoService->create($request->validated());
            return response()->json($cooperado, 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function show(Cooperado $cooperado): JsonResponse {
        return response()->json($cooperado);
    }

    public function update(UpdateCooperadoRequest $request, Cooperado $cooperado): JsonResponse {
        try {
            $cooperado = $this->cooperadoService->update($cooperado, $request->validated());
            return response()->json($cooperado);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function destroy(Cooperado $cooperado): JsonResponse {
        $cooperado->delete();
        return response()->json(null, 204);
    }
}
