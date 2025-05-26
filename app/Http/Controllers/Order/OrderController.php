<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query()->with('shippingAddress');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('order_code', 'like', "%$q%")
                    ->orWhereHas('shippingAddress', function($q2) use ($q) {
                        $q2->where('full_name', 'like', "%$q%")
                           ->orWhere('phone', 'like', "%$q%");
                    });
            });
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $orders = $query->orderByDesc('created_at')->paginate(10)->withQueryString();
        return view('order.orderIndex')->with([
            'title' => 'Quản lý đơn hàng',
            'heading' => 'order',
            'orders' => $orders,
        ]);
    }

    public function show($id)
    {
        $order = Order::with([
            'orderItems.productVariants.product',
            'shippingAddress'
        ])->findOrFail($id);

        $orderItems = $order->orderItems;

        return view('order.orderDetail')->with([
            'title' => 'Chi tiết đơn hàng',
            'heading' => 'Order Detail',
            'order' => $order,
            'orderItems' => $orderItems,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,delivered,completed,cancelled',
        ]);
        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return redirect()->back()->with('toastr', [
            'status' => 'success',
            'message' => 'Cập nhật trạng thái đơn hàng thành công',
        ]);
    }
}
