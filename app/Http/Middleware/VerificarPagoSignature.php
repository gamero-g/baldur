<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class VerificarPagoSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $signature = $request->header('x-signature');
        $requestId = $request->header('x-request-id');
        $data = $request->input();

        $signatureParts = explode(',', $signature);

        $signatureTimeStamp = explode('=', $signatureParts[0])[1];
        $signatureClave = explode('=', $signatureParts[1])[1];

        $validationKey = "id:$data[id];request-id:$requestId;ts:$signatureTimeStamp;";

        $clave = hash_hmac('sha256', $validationKey, config('mercadopago.secret_key'));

        $request->merge(['payment-successful' => $signatureClave === $clave]);
        return $next($request);
    }
}
