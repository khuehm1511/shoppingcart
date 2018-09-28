<?php
namespace Khuehm1511\Shoppingcart\Coupons;
class Fixed extends Coupon
{
    /**
     * @var float
     */
    private $discount;
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
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function apply($total)
    {
        return $this->discount;
    }
}