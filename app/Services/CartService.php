<?php


namespace App\Services;


use App\Contracts\CartContract;
use App\Models\Product;
use Illuminate\Support\Collection;

/**
 * Class CartService
 * @package App\Services
 */
class CartService implements CartContract
{
    /** @var Collection  */
    private Collection $cart;

    /** @var Collection  */
    private Collection $groupedCart;

    /** @var Collection  */
    private Collection $products;

    /** @var float  */
    private float $totalPrice;

    /**
     * @param ?Collection $cart
     * @return $this
     */
    public function setCart(?Collection $cart): self
    {
        $this->cart = $cart ?? $this->getCart();

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCart(): Collection
    {
        return $this->cart ?? $this->loadCartFromSession();
    }

    /**
     * @return Collection
     */
    public function getGroupedCart(): Collection
    {
        return $this->groupedCart ?? $this->groupCart();
    }

    /**
     * @return Collection
     */
    public function getProductsFromCart(): Collection
    {
        return $this->products ?? $this->loadProducts();
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->totalPrice ?? $this->calculateTotalPrice();
    }

    /**
     * @return Collection
     */
    private function groupCart(): Collection
    {
        return $this->groupedCart = $this->getCart()
            ->map(fn ($id) => ['id' => $id])
            ->groupBy('id')
            ->map(fn ($products) => $products->count());
    }

    /**
     * @return mixed
     */
    private function loadProducts()
    {
        $products = Product::whereIn('id', $this->getGroupedCart()->keys())
            ->get(['id', 'name', 'price']);

        $products->each(fn (Product $product) => $product->count = $this->getGroupedCart()->get($product->id));

        return $this->products = $products;
    }

    /**
     * @return float
     */
    private function calculateTotalPrice(): float
    {
        return $this->totalPrice = $this->loadProducts()
            ->map(fn (Product $product) => $product->count * $product->price)
            ->sum();
    }

    private function loadCartFromSession()
    {
        return collect(json_decode(session('cart', '[]'), true));
    }
}
