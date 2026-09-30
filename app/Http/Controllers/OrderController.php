<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function updateStatus(Request $request, $id)
{
    DB::table('orders')->where('id', $id)->update([
        'status' => $request->status,
        'updated_at' => now(),
    ]);
    return redirect('/orders');
}
    public function store(Request $request)
    {
        $orderCode = 'ORD' . strtoupper(uniqid());

        DB::table('orders')->insert([
            'order_code' => $orderCode,
            'customer'   => $request->customer,
            'items'      => json_encode($request->items),
            'total'      => $request->total,
            'status'     => 'Menunggu',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'order_code' => $orderCode]);
    }

    public function index()
    {
        $orders = DB::table('orders')->latest()->get();
        return view('orders', compact('orders'));
    }
}