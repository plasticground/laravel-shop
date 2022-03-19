<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Class CartController
 * @package App\Http\Controllers\Web
 */
class CartController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $cart = $this->getCart()
            ->map(fn ($id) => ['id' => $id])
            ->groupBy('id')
            ->map(fn ($products) => $products->count());

        $products = Product::whereIn('id', $cart->keys())
            ->get(['id', 'name', 'price']);

        $products->each(fn (Product $product) => $product->count = $cart->get($product->id));
        $totalPrice = $products->map(fn (Product $product) => $product->count * $product->price)->sum();

        return view('web.cart.index', compact('products', 'totalPrice'));
    }

    /**
     * @return mixed
     */
    public function getCart()
    {
        return collect(json_decode(session('cart', '[]'), true));
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return count($this->getCart());
    }

    /**
     * @param int $product
     * @return \Illuminate\Http\RedirectResponse|int
     */
    public function addItem(int $product)
    {
        $cart = $this->getCart()->push($product);

        session()->put('cart', $cart->values());

        return request()->wantsJson() ? $this->getSize() : back();
    }

    /**
     * @param int $product
     * @return \Illuminate\Http\RedirectResponse|int
     */
    public function removeItem(int $product)
    {
        $cart = $this->getCart();

        if (($key = $cart->search($product)) !== false) {
            $cart->pull($key);
        }

        session()->put('cart', $cart->values());

        return request()->wantsJson() ? $this->getSize() : back();
    }
}
