<?php

namespace App\Http\Controllers\Client;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class OrderManageController extends Controller
{
    public function showOrderManage()
    {
        $orders = Order::where('user_id', Auth::id())
        ->with('shippingAddress')
        ->orderByDesc('created_at')
        ->get();
        return view('client.order.order_manage', compact('orders'));
    }

    public function orderDetail($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['orderItems.productVariants.product', 'shippingAddress'])
            ->firstOrFail();
        return view('client.order.order_detail', compact('order'));
    }
}
