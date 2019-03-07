<?php

namespace Khuehm1511\Shoppingcart;

use Illuminate\Auth\Events\Logout;
use Illuminate\Session\SessionManager;
use Illuminate\Support\ServiceProvider;

class ShoppingcartServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->bind('cart', 'Khuehm1511\Shoppingcart\Cart');

        $config = __DIR__ . '/../config/cart.php';
        $this->mergeConfigFrom($config, 'cart');

        $this->publishes([__DIR__ . '/../config/cart.php' => config_path('cart.php')], 'config');

        $this->app['events']->listen(Logout::class, function () {
            if ($this->app['config']->get('cart.destroy_on_logout')) {
                $this->app->make(SessionManager::class)->forget('cart');
                $this->app->make(SessionManager::class)->forget('coupon');
            }
        });

        $this->app->bind('coupon', function () {
            return new Coupon(
                $this->app->make(SessionManager::class)
            );
        });
		
		$this->app->bind('cart', function () {
            return new Cart(
                $this->app->make(
                    $this->app['config']->get('cart.repository')
                ),
				$this->app->make(SessionManager::class),
				$this->app->make(\Illuminate\Contracts\Events\Dispatcher::class)
            );
        });

        if ( ! class_exists('CreateShoppingcartTable')) {
            // Publish the migration
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__.'/../database/migrations/0000_00_00_000000_create_shoppingcart_table.php' => database_path('migrations/'.$timestamp.'_create_shoppingcart_table.php'),
            ], 'migrations');
        }
    }
}
