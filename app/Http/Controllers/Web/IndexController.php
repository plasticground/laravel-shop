<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function __invoke()
    {
        $products = Product::query()
            ->select([
                'id',
                'name',
                'description',
                'products.price',
                DB::raw('SUM(count) as sells')
            ])
            ->join('order_product', 'products.id', '=', 'order_product.product_id')
            ->groupBy('product_id')
            ->orderBy('sells', 'desc')
            ->limit(3)
            ->get();

        return view('web.index.index', compact('products'));
    }
}
