<?php


namespace App\Contracts;


use App\Services\CartService;
use Illuminate\Support\Collection;

/**
 * Interface CartContract
 * @package App\Contracts
 */
interface CartContract
{
    /**
     * @param ?Collection $cart
     * @return CartService
     */
    public function setCart(?Collection $cart): CartService;

    /**
     * @return Collection
     */
    public function getCart(): Collection;

    /**
     * @return Collection
     */
    public function getGroupedCart(): Collection;

    /**
     * @return Collection
     */
    public function getProductsFromCart(): Collection;

    /**
     * @return float
     */
    public function getTotalPrice(): float;
}
