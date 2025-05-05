<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Carrinho vazio.');
        }

        $items = $cart->items;

        $mercadoPagoItems = $items->map(function ($item) {
            return [
                'id' => $item->product->id,
                'title' => $item->product->name,
                'quantity' => $item->quantity,
                'unit_price' => (float) $item->product->price,
                'currency_id' => 'BRL',
            ];
        });

        $client = new Client();

        try {
            $response = $client->post('https://api.mercadopago.com/checkout/preferences', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('MERCADOPAGO_ACCESS_TOKEN'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'items' => $mercadoPagoItems,
                    'back_urls' => [
                        'success' => route('home'),
                        'failure' => route('home'),
                        'pending' => route('home'),
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return response()->json([
                'init_point' => $data['init_point'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao criar a preferência de pagamento.',
            ], 500);
        }
    }
}
