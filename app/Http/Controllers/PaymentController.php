<?php

namespace App\Http\Controllers;

use PayOS\PayOS;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function createVnpayPayment(Request $request)
    {
        $vnp_Url = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
        $vnp_Returnurl = 'http://127.0.0.1:8000/cart/detail';
        $vnp_TmnCode = 'OSZPQN70'; //Mã website tại VNPAY
        $vnp_HashSecret = 'CFUXUC35WIW0Q8SWRTNC87JP6JZD2XWH'; //Chuỗi bí mật

        $vnp_TxnRef = uniqid(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán đơn hàng test';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = 10000 * 100;
        $vnp_Locale = 'vn';
        // $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => $vnp_TmnCode,
            'vnp_Amount' => $vnp_Amount,
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $vnp_IpAddr,
            'vnp_Locale' => $vnp_Locale,
            'vnp_OrderInfo' => $vnp_OrderInfo,
            'vnp_OrderType' => $vnp_OrderType,
            'vnp_ReturnUrl' => $vnp_Returnurl,
            'vnp_TxnRef' => $vnp_TxnRef,
        ];

        if (isset($vnp_BankCode) && $vnp_BankCode != '') {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != '') {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = '';
        $i = 0;
        $hashdata = '';
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . '=' . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . '?' . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = [
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url,
        ];
        if (isset($_POST['redirect'])) {
            return redirect($vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }

    public function createPaymentPayOS(Request $request, $cart_id)
    {
        $cart = Cart::with('cartItems.productVariants.product')->findOrFail($cart_id);
        $shipping_fee = session('shipping_fee') == 'standard_delivery' ? 30000 : 50000;
        $shipping_address_id = $request->shipping_address_id;
        $amount = $cart->cartItems->sum('price') + $shipping_fee;

        $items = [];
        foreach ($cart->cartItems as $item) {
            $items[] = [
                'name' => $item->productVariants->product->name,
                'price' => (int) $item->price,
                'quantity' => (int) $item->quantity
            ];
        }

        $payOSClientId = config('services.payos.client_id');
        $payOSApiKey = config('services.payos.api_key');
        $payOSChecksumKey = config('services.payos.checksum_key');

        $payOS = new PayOS($payOSClientId, $payOSApiKey, $payOSChecksumKey);

        $data = [
            "orderCode" => intval(substr(strval(microtime(true) * 10000), -6)),
            "amount" => $amount,
            'Shipping Method' => session('shipping_fee'),
            "description" => "Thanh toán đơn hàng",
            "items" => $items,
            "returnUrl" => route('payment.payos.success', [
                'amount' => $amount,
                'cart_id' => $cart->id,
                'shipping_fee' => $shipping_fee,
                'shipping_address_id' => $shipping_address_id,
            ]),
            "cancelUrl" => route('cart.checkout.show')
        ];

        try {
            $response = $payOS->createPaymentLink($data);

            return redirect()->away($response['checkoutUrl']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function payosReturnSuccess(Request $request)
    {
        $cart_id = $request->cart_id;
        $shipping_address_id = $request->shipping_address_id;
        $total_amount = $request->amount;
        $cart = Cart::with('cartItems.productVariants.product')->findOrFail($cart_id);
        $order = Order::create([
            'user_id' => $cart->user_id,
            'shipping_address_id' => $shipping_address_id,
            'total_amount' => $total_amount,
            'shipping_method' => session('shipping_fee'),
            'payment_method' => 'payos',
            'payment_status' => 'paid',
            'status' => 'pending',
            'order_code' => 'DH' . time() . $cart->user_id,
        ]);

        foreach ($cart->cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_variant_id' => $cartItem->productVariants->id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->productVariants->product->sale_price ?? $cartItem->productVariants->product->price,
            ]);

            // Update product stock
            $variant = $cartItem->productVariants;
            $newStock = $variant->stock - $cartItem->quantity;
            $variant->stock = $newStock > 0 ? $newStock : 0;
            $variant->save();
        }

        $cart->status = 'completed';
        $cart->save();

        return redirect()->route('order.success' , ['order_id' => $order->id])->with('toastr', [
            'status' => 'success',
            'message' => 'Thanh toán thành công. Đơn hàng của bạn đã được xác nhận.',
        ]);
    }

    public function payosReturnError()
    {
        return redirect()->route('cart.checkout.show')->with('toastr', [
            'status' => 'error',
            'message' => 'Thanh toán thất bại. Vui lòng thử lại.',
        ]);
    }
}
