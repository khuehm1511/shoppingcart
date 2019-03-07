<?php
namespace Khuehm1511\Shoppingcart\Facades;

use Illuminate\Support\Facades\Facade;

class Coupon extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'coupon';
    }
}
