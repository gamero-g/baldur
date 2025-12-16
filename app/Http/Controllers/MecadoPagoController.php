<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MecadoPagoController extends Controller
{
    public function carrito() {
        $carrito = session()->get('carrito', []);
        $productos = Game::with('bg_classes', 'platforms')->whereIn('juego_id', $carrito)->get();

        return view('compras.carrito', [
            'productos' => $productos,
        ]);
    }

    public function checkout() {
        try {
            $carrito = session()->get('carrito', []);
            $productos = Game::with('bg_classes', 'platforms')->whereIn('juego_id', $carrito)->get();

            $itemsParaMP = [];
            foreach ($productos as $producto) {
                $itemsParaMP[] = [
                    'title' => $producto->titulo,
                    'unit_price' => $producto->precio,
                    'quantity' => 1
                ];
            };

            // Inicializo MP
            MercadoPagoConfig::setAccessToken(config('mercadopago.access_token'));

            // Preferencia de pago
            $preferenceFactory = new PreferenceClient();
            $preference = $preferenceFactory->create([
                'items' => $itemsParaMP,
                'back_urls' => [
                    'success' => 'https://epilithic-reese-unpredicably.ngrok-free.dev/carrito/completar-compra/success',
                    'failure' => 'https://epilithic-reese-unpredicably.ngrok-free.dev/carrito/completar-compra/failure',
                ],
                'auto_return' => 'approved',
            ]);

            return view('compras.checkout', [
                'productos' => $productos,
                'preference' => $preference,
                'MPPublicKey' => config('mercadopago.public_key')
            ]);
        } catch (\MercadoPago\Exceptions\MPApiException $e) {
           print_r($e->getApiResponse()->getContent()['message']);
        } catch(\Throwable $th) {
            throw $th;
        }
    }

    public function success() {
        session()->put('carrito', []);
        return view('compras.success');
    }

    public function failure() {
        return view('compras.failure');
    }


    public function verificarPagoMiddleware(Request $request) {
        if ($request->boolean('payment-successful')) {
            Log::info('Compra realizada con éxito.', $request->all());
        } else {
            Log::info('Compra no existente.', $request->all());
        }
    }

    public function agregarAlCarrito(Request $request, int $id) {
        $carrito = session()->get('carrito', []);

        if(empty($carrito)) {
            $carrito = [];
        }

        if(!in_array($id, $carrito)) {
            $carrito[] = $id;
        }
        
        session()->put('carrito', $carrito);

        return to_route('games.all');
    }

    public function eliminarDelCarrito(int $id) {
        $carrito = session()->get('carrito', []);

        $itemAEliminar = array_search($id, $carrito);

        if($itemAEliminar !== false) {
            array_splice($carrito, $itemAEliminar, 1);
        }
        
        session()->put('carrito', $carrito);

        return to_route('compras.carrito')->with('feedback.message', 'Producto eliminado del carrito');
    }

    public function vaciarCarrito() {
        $carrito = []; 
        session()->put('carrito', $carrito);
        return to_route('compras.carrito');
    }
}
