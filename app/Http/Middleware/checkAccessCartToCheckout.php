<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkAccessCartToCheckout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->get('allow_checkout')) {
            return redirect()->route('cart.detail')->with('toastr', [
                'message' => 'Please press PLACE ORDER !',
                'status' => 'warning',
            ]);
        }
        return $next($request);
    }
}
