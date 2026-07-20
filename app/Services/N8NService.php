<?php

namespace App\Services;

use App\Models\Cliente;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class N8NService
{
    protected string $url;

    public function __construct()
    {
        $this->url = config('services.n8n.webhook');
    }


    /**
     * Envia um cliente para o webhook do n8n.
     * -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
     * Caso de certo, ele passa com log true
     * Caso contrário, ele emite um log = false
     */
    public function enviarCliente(Cliente $cliente): bool
    {
        try {

            $response = Http::timeout(15)
                ->acceptJson()
                ->post($this->url, [
                    'id'        => $cliente->id,
                    'nome'      => $cliente->nome,
                    'telefone'  => $cliente->telefone,
                    'cidade'    => $cliente->cidade,
                ]);

            if ($response->successful()) {

                $cliente->update([
                    'status_integracao' => Cliente::STATUS_ENVIADO,
                    'enviado_em' => now(),
                    'ultima_falha' => null,
                ]);

                Log::info('Cliente enviado ao n8n.', [
                    'cliente_id' => $cliente->id,
                ]);

                return true;
            }

            $cliente->update([
                'status_integracao' => Cliente::STATUS_ERRO,
                'ultima_falha' => $response->body(),
            ]);

            Log::error('Erro retornado pelo n8n.', [
                'cliente_id' => $cliente->id,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;

        } catch (\Throwable $e) {

            $cliente->update([
                'status_integracao' => Cliente::STATUS_ERRO,
                'ultima_falha' => $e->getMessage(),
            ]);

            Log::error('Falha ao conectar ao n8n.', [
                'cliente_id' => $cliente->id,
                'erro' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
