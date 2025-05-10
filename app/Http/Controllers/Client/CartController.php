<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function showCart()
    {
        $user = Auth::user();
        $cart = $user->cart()->where('status', 'active')->first();
        if($cart) {
            $totalQuantity = $cart->cartItems()->sum('quantity');
        }else {
            $totalQuantity = 0;
        }
        return view('layout.clientApp', compact('totalQuantity'));

    }  
}
