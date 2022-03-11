<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:products@index'])->only(['index']);
        $this->middleware(['permission:products@show'])->only(['show']);
        $this->middleware(['permission:products@create'])->only(['create', 'store']);
        $this->middleware(['permission:products@edit'])->only(['edit', 'update']);
        $this->middleware(['permission:products@delete'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->with('author:id,name')
            ->when($request->name, fn(Builder $builder) => $builder->whereName($request->name))
            ->when($request->user && is_numeric($request->user), fn(Builder $builder) => $builder->whereUserId($request->user))
            ->when($request->user && is_string($request->user), fn(Builder $builder) => $builder->whereHas('author', fn (Builder $builder) => $builder->whereName($request->user)))
            ->when($request->price, fn(Builder $builder) => $builder->wherePrice($request->price))
            ->when($request->priceFrom, fn(Builder $builder) => $builder->where('price', '>=', $request->priceFrom))
            ->when($request->priceTo, fn(Builder $builder) => $builder->where('price', '<=', $request->priceTo))
            ->latest()
            ->paginate($request->get('limit', 15));

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO: make validation

        $product = Product::query()->create($request->only(['name', 'description', 'price']));

        return redirect()->route('admin.products.show', $product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $author = $product->author()->select(['id', 'name']);

        return view('admin.products.show', compact('product', 'author'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //TODO: make validation

        $product->update($request->only(['name', 'description', 'price']));

        return redirect()->route('admin.products.show', $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index');
    }
}
