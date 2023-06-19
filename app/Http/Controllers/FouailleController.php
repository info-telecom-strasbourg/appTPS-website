<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class FouailleController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        $fouaille = DB::connection('bde_bdd')
        ->table('orders')
        ->select(
            'orders.date',
            'orders.price', 
            'orders.amount', 
            'products.name', 
            'products.title',
            'products.color',
            )
        ->join('products', 'orders.product_id', '=', 'products.id')
        ->where('orders.member_id', '=', $user->bde_id)
        ->get();

        $balance = DB::connection('bde_bdd')->table('members')->where('id', '=', $user->bde_id)->first()->balance;
        
        $data = $fouaille->map(function ($item) {
            return [
                'date' => $item->date,
                'total_price' => $item->price,
                'amount' => $item->amount,
                'product' => [
                    'name' => $item->name,
                    'title' => $item->title,
                    'unit_price' => strval($item->price / $item->amount),
                    'color' => $item->color,
                ]
            ];
        });

        return response()->json([
            'data' => [
                'balance' => $balance,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'user_name' => $user->user_name,
                'orders' => $data
            ],
        ], 200);
    }
}
