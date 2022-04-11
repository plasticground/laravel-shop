<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * StatisticsController constructor.
     */
    public function __construct()
    {
        $this->middleware(['permission:statistics@index']);
    }

    /**
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        $from = $request->from ? Carbon::make($request->from) : now()->subMonth();
        $to = $request->to ? Carbon::make($request->to) : now();

        $statistics = DB::table('order_product')
            ->select(['product_id', DB::raw('products.name as product_name')])
            ->addSelect(DB::raw('SUM(count) as sells_amount'))
            ->addSelect(DB::raw('SUM(order_product.price * count) as sells_profit'))
            ->leftJoin('products', 'order_product.product_id', '=', 'products.id')
            ->leftJoin('orders', 'order_product.order_uuid', '=', 'orders.uuid')
            ->whereIn('state', [Order::STATE_APPROVED, Order::STATE_DONE])
            ->whereBetween(Order::APPROVED_AT, [$from->startOfDay(), $to->endOfDay()])
            ->groupBy('product_id')
            ->orderBy('sells_profit', 'desc')
            ->get();

        return view('admin.statistics.index', compact('statistics', 'from', 'to'));
    }
}
