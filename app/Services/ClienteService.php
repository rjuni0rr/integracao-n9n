<?php

namespace App\Services;

use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class ClienteService
{
    public function __construct(protected N8NService $n8nService) {

    }


    /**
     * Cria um cliente e envia para o n8n.
     */
    public function criar(array $dados): Cliente
    {
        return DB::transaction(function () use ($dados) {

            $cliente = Cliente::create($dados);

            $enviado = $this->n8nService->enviarCliente($cliente);

            if (! $enviado) {
                throw new \Exception('Não foi possível comunicar com o n8n.');
            }

            return $cliente;
        });
    }


    /**
     * Atualiza um cliente.
     */
    public function atualizar(Cliente $cliente, array $dados): Cliente
    {
        $cliente->update($dados);

        return $cliente;
    }


    /**
     * Exclui um cliente.
     */
    public function excluir(Cliente $cliente): void
    {
        $cliente->delete();
    }
}
