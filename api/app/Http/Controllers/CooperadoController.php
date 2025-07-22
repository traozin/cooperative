<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCooperadoRequest;
use App\Http\Requests\UpdateCooperadoRequest;
use App\Models\Cooperado;

class CooperadoController extends Controller {
    public function index() {
        return Cooperado::all();
    }

    public function store(StoreCooperadoRequest $request) {
        $cooperado = Cooperado::create($request->validated());
        return response()->json($cooperado, 201);
    }

    public function show(Cooperado $cooperado) {
        return $cooperado;
    }

    public function update(UpdateCooperadoRequest $request, Cooperado $cooperado) {
        $cooperado->update($request->validated());
        return response()->json($cooperado);
    }

    public function destroy(Cooperado $cooperado) {
        $cooperado->delete();
        return response()->noContent();
    }
}
