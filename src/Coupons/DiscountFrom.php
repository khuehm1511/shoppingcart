<?php
namespace Khuehm1511\ShoppingCart\Coupons;

abstract class DiscountForm
{
    public $name;
    /**
     * Coupon constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }
    /**
     * Apply coupon to total price.
     *
     * @param $total
     *
     * @return float Discount.
     */
    abstract public function apply($total);
}