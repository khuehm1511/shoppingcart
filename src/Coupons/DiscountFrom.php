<?php
namespace Khuehm1511\Shoppingcart\Coupons;

abstract class DiscountForm
{
    public $code;
    /**
     * Coupon constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->code = $name;
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