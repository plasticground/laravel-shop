<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::whereCustomerId(auth()->id())
            ->latest()
            ->paginate($request->get('limit', 15));

        return view('web.orders.index', compact('orders'));
    }

    /**
     * @param CartService $cartService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(CartService $cartService)
    {
        $products = $cartService->getProductsFromCart();
        $totalPrice = $cartService->getTotalPrice();

        if ($products->isEmpty()) {
            return back();
        }

        return view('web.orders.create', compact('products', 'totalPrice'));
    }

    /**
     * @param Request $request
     * @param CartService $cartService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, CartService $cartService)
    {
        $products = $cartService->getProductsFromCart()
            ->mapWithKeys(fn (Product $product, $key) => [
                $product->id => [
                    'price' => $product->price,
                    'count' => $product->count
                ]
            ])
            ->toArray();

        $order = Order::create($request->only([
                'customer_firstname',
                'customer_lastname',
                'customer_phone',
                'comment'
            ]) + ['customer_id' => auth()->id(), 'state' => Order::STATE_MODERATION]
        );

        $order->products()->sync($products);

        session()->forget('cart');

        return redirect()->route('web.orders.show', compact('order'));
    }

    /**
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Order $order)
    {
        if ($order->customer_id && ($order->customer_id !== auth()->id())) {
            abort(404);
        }

        return view('web.orders.show', compact('order'));
    }
}
