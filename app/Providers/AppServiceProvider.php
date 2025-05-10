<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Lấy giỏ hàng của người dùng nếu đăng nhập
            $user = Auth::user();
            $totalQuantity = 0;

            if ($user) {
                // Lấy giỏ hàng đang hoạt động của người dùng
                $cart = $user->cart()->where('status', 'active')->first();
                
                if ($cart) {
                    // Tính tổng số lượng sản phẩm trong giỏ hàng
                    $totalQuantity = $cart->cartItems->sum('quantity');
                }
            }

            // Chia sẻ biến với tất cả các view
            $view->with('totalQuantity', $totalQuantity);
        });
    }
}
