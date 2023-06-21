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

        $per_page = $request->query('per_page');

        if ($per_page == null) {
            $per_page = 10;
        }

        $datas = DB::connection('bde_bdd')
        ->table('orders')
        ->select(
            'orders.date',
            'orders.price', 
            'orders.amount', 
            'products.name', 
            'products.title',
            'products.color',
            )
        ->leftJoin('products', 'orders.product_id', '=', 'products.id')
        ->where('orders.member_id', '=', 6)
        ->orderByDesc('orders.date')
        ->paginate($per_page);
        
        $orders = $datas->map(function ($data) {
            return [
                'date' => $data->date,
                'total_price' => $data->price,
                'amount' => $data->amount,
                'product' => ($data->name == null) ? null : [
                    'name' => $data->name,
                    'title' => $data->title,
                    'unit_price' => strval($data->price / $data->amount),
                    'color' => $data->color,
                ]
            ];
        });


        return response()->json([
            'data' => [
                'balance' => DB::connection('bde_bdd')->table('members')->where('id', '=', 6)->first()->balance,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'user_name' => $user->user_name,
                'orders' => $orders
            ],
            'meta' => [
                'total' => $datas->total(),
                'per_page' => $datas->perPage(),
                'current_page' => $datas->currentPage(),
                'last_page' => $datas->lastPage(),
                'first_page_url' => $datas->url(1)."&per_page=".$per_page,
                'last_page_url' => $datas->url($datas->lastPage())."&per_page=".$per_page,
                'next_page_url' => $datas->nextPageUrl()."&per_page=".$per_page,
                'prev_page_url' => $datas->previousPageUrl()."&per_page=".$per_page,
                'path' => $datas->path(),
                'from' => $datas->firstItem(),
                'to' => $datas->lastItem()
            ]
        ], 200);
    }
}
