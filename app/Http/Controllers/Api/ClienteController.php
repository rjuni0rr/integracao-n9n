<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Services\ClienteService;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;

class ClienteController extends Controller
{
    public function __construct(protected ClienteService $clienteService) {

    }


    /**
     * Lista os clientes.
     */
    public function index()
    {
        $clientes = Cliente::orderBy('nome')->get();

        return view('clientes.index', compact('clientes'));
    }


    /**
     * Exibe o formulário.
     */
    public function create()
    {
        return view('clientes.create');
    }


    /**
     * Salva um novo cliente.
     */
    public function store(StoreClienteRequest $request)
    {
        $this->clienteService->criar($request->validated());

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }


    /**
     * Exibe o formulário de edição.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }


    /**
     * Atualiza um cliente.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $this->clienteService->atualizar(
            $cliente,
            $request->validated()
        );

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }


    /**
     * Remove um cliente.
     */
    public function destroy(Cliente $cliente)
    {
        $this->clienteService->excluir($cliente);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente removido com sucesso!');
    }
}
