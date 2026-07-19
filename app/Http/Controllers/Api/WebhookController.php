<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebhookController extends Controller
{

    // retorna a resposta
    public function receive(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Laravel recebeu os dados.',
            'dados' => $request->all()
        ]);
    }
}
