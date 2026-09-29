<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
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