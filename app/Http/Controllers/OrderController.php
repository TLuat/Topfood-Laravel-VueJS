<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'alolo';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->selectedProducts);
        $user = Auth::user();
        $selectedProducts = $request->selectedProducts;
        $totalQuantity = 0;
        $order = new Order;
        $order->user_id = $user->id;

        foreach ($selectedProducts as $product) {
            $quantity = $product['quantity'];
            $totalQuantity += $quantity;
        }

        $order->total_quantity = $totalQuantity;
        $order->total_price = $request->totalSum;
        $order->email = $request->email;
        $order->recipient_name = $request->userName;
        $order->phone_number = $request->numberPhone;
        $order->note = $request->note;
        $order->shipping_address = $request->selectedAddress;
        $order->payment_method = $request->paymentMethod;
        $order->status = $request->status;
        $order->save();
        $orderID = $order->id;
        // dd($selectedProducts);

        foreach ($selectedProducts as $product) {
            $id = $product['products']['id'];
            $quantity = $product['quantity'];

            $order->products()->attach($id, ['quantity' => $quantity]);
            if (isset($product['toppings'])) {
                foreach ($product['toppings'] as $topping) {
                    $order->toppings()->attach($topping['id']);
                }
            }
        }

        $name = $request->userName;
        $email = $request->email;



        if ($request->paymentMethod === "Ví VnPay") {
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = "https://topfood.com/successpayment";
            $vnp_TmnCode = "8ETOV7JP"; //Mã website tại VNPAY
            $vnp_HashSecret = "NIVDATOLBCFDAISSVCLSDKGXSFOGKHIM"; //Chuỗi bí mật

            $vnp_TxnRef = $orderID;
            $vnp_OrderInfo = 'Thanh toán đơn hàng';
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $request->totalSum * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = 'REMOTE_ADDR';

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,

            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array(
                'code' => '00'
                ,
                'message' => 'success'
                ,
                'data' => $vnp_Url
            );

            $order->status = 'processing';
            $order->save();
            Mail::send('email.OrderEmail', ['name' => $name, 'order' => $order, 'selectedProducts' => $selectedProducts], function ($message) use ($email) {
                $message->to($email)->subject('ĐẶT MÓN THÀNH CÔNG!');
            });
            return Inertia::location($vnp_Url);
        }
        Mail::send('email.OrderEmail', ['name' => $name, 'order' => $order, 'selectedProducts' => $selectedProducts], function ($message) use ($email) {
            $message->to($email)->subject('ĐẶT MÓN THÀNH CÔNG!');
        });
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $selectedProducts = $request->input('selectedProducts');
        $selectedProductCount = $request->input('selectedProductCount');
        $totalSum = $request->input('totalSum');
        // dd($selectedProducts);
        return Inertia::render('Payment', [
            'selectedProducts' => $selectedProducts,
            'totalSum' => $totalSum,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::find($id);
        $order->update($request->only('status'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
