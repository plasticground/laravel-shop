<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->name, fn(Builder $builder) => $builder->whereName($request->name))
            ->when($request->priceFrom, fn(Builder $builder) => $builder->where('price', '>=', $request->priceFrom))
            ->when($request->priceTo, fn(Builder $builder) => $builder->where('price', '<=', $request->priceTo))
            ->latest()
            ->paginate($request->get('limit', 15));

        return view('web.products.index', compact('products'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('web.products.show', compact('product'));
    }
}
