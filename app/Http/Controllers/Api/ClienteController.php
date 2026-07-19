<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Services\ClienteService;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct(
        private ClienteService $clienteService
    ) {}

    public function index()
    {
        return response()->json(
            $this->clienteService->listar()
        );
    }

    public function show(Cliente $cliente)
    {
        return response()->json($cliente);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20|unique:clientes',
            'email' => 'nullable|email',
            'cidade' => 'nullable|string|max:255',
        ]);

        return response()->json(
            $this->clienteService->criar($dados),
            201
        );
    }

    public function update(Request $request, Cliente $cliente)
    {
        //
    }

    public function destroy(Cliente $cliente)
    {
        //
    }
}
