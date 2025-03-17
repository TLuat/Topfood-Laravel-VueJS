<?php

namespace App\Http\Controllers;

use App\Enums\TableStatus;
use App\Models\Menu;
use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Table::with('reservations')->get();
        $reservation = Reservation::with('tables')->get();
        $menus = Menu::all();
        return Inertia::render('Reservation', compact('reservation', 'tables', 'menus'));
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
        $user = Auth::user();
        $reservation = new Reservation;
        $reservation->user_id = $user->id;
        $reservation->email = $request->input('email');
        $reservation->name = $request->input('userName');
        $reservation->phone = $request->input('phone');
        $reservation->res_date = Carbon::parse($request->input('res_date'));
        $reservation->time = $request->input('time');
        $reservation->table_id = $request->input('table_id');
        $reservation->guest_number = $request->input('guest_number');
        $reservation->total_price = $request->input('total_price');

        $reservation->save();

        $table = Table::find($request->table_id);
        $table->update([
            'status' => 'Đã Đặt'
        ]);

        $selectedMenuItems = $request->selectedMenuItems;
        $menuQuantities = $request->menuQuantitiesData;


        foreach ($selectedMenuItems as $menuId) {
            $id = $menuId['id'];
            $quantity = $menuQuantities[$id] ?? 1;

            $reservation->menus()->attach($id, ['quantity' => $quantity]);
            if (isset($menuId['menus'])) {
                foreach ($menuId['menus'] as $menu) {
                    $reservation->menus()->attach($menu['id']);
                }
            }
        }

        $name = $request->userName;
        $email = $request->email;
        //thanh toan
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "https://topfood.com/successpayment";
        $vnp_TmnCode = "8ETOV7JP"; //Mã website tại VNPAY
        $vnp_HashSecret = "NIVDATOLBCFDAISSVCLSDKGXSFOGKHIM"; //Chuỗi bí mật

        $vnp_TxnRef = $reservation->id;
        $vnp_OrderInfo = 'Thanh toán đặt bàn';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $reservation->total_price * 100;
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

        Mail::send('email.ReservationEmail', ['name' => $name, 'reservation' => $reservation, 'table' => $table, 'selectedMenuItems' => $selectedMenuItems, 'menuQuantities' => $menuQuantities], function ($message) use ($email) {
            $message->to($email)->subject('ĐẶT BÀN THÀNH CÔNG!');
        });
        return Inertia::location($vnp_Url);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
