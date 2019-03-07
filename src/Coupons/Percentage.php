<?php
namespace Khuehm1511\Shoppingcart\Coupons;

class Percentage extends DiscountForm
{
    /**
     * @var float
     */
    public $discount;
    /**
     * PercentCoupon constructor.
     *
     * @param string $name
     * @param float  $discount
     */
    public function __construct($name, $discount)
    {
        parent::__construct($name);
        $this->discount = $discount;
    }
    /**
     * Apply coupon to total price.
     *
     * @param $total
     *
     * @return float Discount.
     */
    public function apply($total)
    {
        return ($total * $this->discount)/100;
    }
}