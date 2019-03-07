<?php
namespace Khuehm1511\Shoppingcart;

use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use Khuehm1511\Shoppingcart\Coupons\DiscountForm;

/**
 * Coupon
 */
class Coupon
{
	const DEFAULT_INSTANCE = 'default';

    /**
     * Instance of the session manager.
     *
     * @var \Illuminate\Session\SessionManager
     */
    private $session;

    /**
     * Holds the current cart instance.
     *
     * @var string
     */
    private $instance;

    /**
     * Repository for cart store.
     *
     * @var RepositoryInterface
     */

    /**
     * Coupon constructor.
     *
     * @param \Illuminate\Session\SessionManager      $session
     */
    public function __construct(SessionManager $session)
    {
        $this->session = $session;
        $this->instance(self::DEFAULT_INSTANCE);
    }



    /**
     * Set the current cart instance.
     *
     * @param string|null $instance
     * @return \Khuehm1511\Shoppingcart\Cart
     */
    public function instance($instance = null)
    {
        $instance = $instance ?: self::DEFAULT_INSTANCE;

        $this->instance = sprintf('%s.%s', 'coupon', $instance);

        return $this;
    }

    /**
     * Get the current cart instance.
     *
     * @return string
     */
    public function currentInstance()
    {
        return str_replace('coupon.', '', $this->instance);
    }
    
    /**
     * Get Coupon code.
     *
     */
    public function code()
    {
        $this->content();
    }
	
    /**
     * Add coupon.
     *
     * @param Coupon $coupon
     */
    public function add(DiscountForm $coupon)
    {
        $this->session->put($this->instance, $coupon);
    }
    /**
     * Remove coupon.
     *
     * @param Coupon $coupon
     */
    public function remove()
    {
        $this->session->forget($this->instance);
    }



    /**
     * Get total price with coupons.
     *
     * @return float
     */
    public function total($total)
    {
        $totalWithCoupons = $total;
        if ($this->is())
		{
	        $totalWithCoupons = $this->getContent()->apply($total);
    	}
		return $totalWithCoupons;
    }
	
    /**
     * Get discount price with coupons.
     *
     * @return float
     */
    public function discount($total)
    {
        $discountWithCoupons = 0;
		if ($this->is())
		{
			$discountWithCoupons = $this->getContent()->discount;
		}
		return $discountWithCoupons;
    }

    /**
     * Get coupons.
     *
     * @return Collection
     */
    public function content()
    {
        
        return (array)$this->getContent();
    }
	
	/**
	 * Has coupons.
	 *
	 * @return true/false
	 */
	public function is()
	{
		return ($this->session->has($this->instance) ? true : false);
	}

	/**
     * Get coupons.
     *
     * @return Collection
     */
    protected function getContent()
    {
        
        $content = $this->session->has($this->instance)
            ? $this->session->get($this->instance)
            : new Collection;
        return $content;
    }
    
}