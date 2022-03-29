<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class OrderController
 * @package App\Http\Controllers\Admin
 */
class OrderController extends Controller
{
    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        $this->middleware(['permission:orders@index'])->only(['index']);
        $this->middleware(['permission:orders@show'])->only(['show']);
        $this->middleware(['permission:orders@moderate'])->only(['approve', 'reject']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with(['manager', 'customer'])
            ->when($request->state, fn(Builder $builder) => $builder->whereState($request->state))
            ->when($request->manager, fn(Builder $builder) => $builder->whereManagerId($request->manager)->orWhereHas('manager', fn (Builder $builder) => $builder->whereName($request->manager)))
            ->when($request->customer, fn(Builder $builder) => $builder->whereCustomerId($request->customer)->orWhereHas('customer', fn (Builder $builder) => $builder->whereName($request->customer)))
            ->when($request->customer_firstname, fn(Builder $builder) => $builder->whereCustomerFirstname($request->customer_firstname))
            ->when($request->customer_lastname, fn(Builder $builder) => $builder->whereCustomerLastname($request->customer_lastname))
            ->when($request->customer_phone, fn(Builder $builder) => $builder->whereCustomerPhone($request->customer_phone))
            ->latest()
            ->paginate($request->get('limit', 15));

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    /**
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Order $order)
    {
        $order->update([
            'manager_id' => auth()->id(),
            'state' => Order::STATE_APPROVED,
            Order::APPROVED_AT => now()
        ]);

        return redirect()->route('admin.orders.show', $order);
    }

    /**
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(Order $order)
    {
        $order->update([
            'manager_id' => auth()->id(),
            'state' => Order::STATE_REJECTED,
            Order::REJECTED_AT => now()
        ]);

        return redirect()->route('admin.orders.show', $order);
    }
}
