<?php

namespace App\Http\Controllers;

use App\Models\Bde\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Bde\Member;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

/**
 * @group Fouaille
 */
class FouailleController extends Controller
{


    /**
     * Orders
     * 
     * Fetch a paginated list of fouaille' orders of the current user
     * @queryParam per_page int Number of elements per page. Example: 10
     * @queryParam page int Page number. Example: 1
     * @param Request $request
     */
    public function show(Request $request)
    {
        $user = $request->user();

        $per_page = $request->query('per_page');

        if ($per_page == null) {
            $per_page = 10;
        }

        $orders = Order::where('member_id', $user->bde_id)->orderByDesc('date')->paginate($per_page);

        $balance = DB::connection('bde_bdd')->table('members')->where('id', '=', $user->bde_id)->first()->balance;

        global $actual_balance;

        $actual_balance = $balance;

        $datas = $orders->map(function ($order) use ($actual_balance){
            global $actual_balance;
            $actual_balance = $order->getFormerBalance($actual_balance);
            return [
                'date' => $order->date,
                'date_format' => $order->getDate(),
                'actual_balance' => $actual_balance,
                'total_price' => $order->price,
                'amount' => $order->amount,
                'product' => ($order->product == null) ? null : [
                    'name' => $order->product->name,
                    'type' => $order->product->productType->type,
                    'unit_price' => strval($order->price / $order->amount),
                ]
            ];
        });


        return response()->json([
            'data' => [
                'orders' => $datas
            ],
            'meta' => [
                'total' => $orders->total(),
                'per_page' => $orders->perPage(),
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'first_page_url' => $orders->url(1)."&per_page=".$per_page,
                'last_page_url' => $orders->url($orders->lastPage())."&per_page=".$per_page,
                'next_page_url' => $orders->nextPageUrl()."&per_page=".$per_page,
                'prev_page_url' => $orders->previousPageUrl()."&per_page=".$per_page,
                'path' => $orders->path(),
                'from' => $orders->firstItem(),
                'to' => $orders->lastItem()
            ]
        ], 200);
    }

    /**
     * Balance
     * 
     * Fetch the current balance of the user
     */
    public function balance(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'data' => [
                'balance' => DB::connection('bde_bdd')->table('members')->where('id', '=', $user->bde_id)->first()->balance,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'user_name' => $user->user_name,
            ],]);
    }
}
