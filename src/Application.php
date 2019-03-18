<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App;

use Cake\Core\Configure;
use Cake\Core\Exception\MissingPluginException;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication
{
    /**
     * {@inheritDoc}
     */
    public function bootstrap()
    {
        // Call parent to load bootstrap from files.
        parent::bootstrap();

        if (PHP_SAPI === 'cli') {
            $this->bootstrapCli();
        }

        /*
         * Only try to load DebugKit in development mode
         * Debug Kit should not be installed on a production system
         */
        if (Configure::read('debug')) {
            $this->addPlugin(\DebugKit\Plugin::class);
        }

        // Load more plugins here
    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware($middlewareQueue)
    {
        $middlewareQueue
            // Catch any exceptions in the lower layers,
            // and make an error page/response
            ->add(new ErrorHandlerMiddleware(null, Configure::read('Error')))

            // Handle plugin/theme assets like CakePHP normally does.
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime')
            ]))

            // Add routing middleware.
            // Routes collection cache enabled by default, to disable route caching
            // pass null as cacheConfig, example: `new RoutingMiddleware($this)`
            // you might want to disable this cache in case your routing is extremely simple
            ->add(new RoutingMiddleware($this, '_cake_routes_'));

          $middlewareQueue->add(new \ADmad\SocialAuth\Middleware\SocialAuthMiddleware([
            'requestMethod' => 'POST',
            'loginUrl' => '/users/login',
            'loginRedirect' => '/home',
            'userEntity' => false,
            'userModel' => 'Users',
            'finder' => 'all',
            'fields' => [
              'password' => 'password',
            ],
            'sessionKey' => 'Auth.User',
            'getUserCallback' => 'getUser',
            'serviceConfig' => [
              'provider' => [
                'facebook' => [
                  'applicationId' => env('FACEBOOK_APP_ID', '212086429517997'),
                  'applicationSecret' => env('FACEBOOK_APP_SECRET', '0f4a5cdf16bce0662f296d7f42f71bcd'),
                  'scope' => [
                    'email',
                    'basic_info'
                  ],
                  'fields' => [
                    'email',
                    'first_name',
                    'last_name',
                    'picture'
                    // To get a full list of all posible values, refer to
                    // https://developers.facebook.com/docs/graph-api/reference/user
                  ],
                ],
                'google' => [
                  'applicationId' => env('GOOGLE_APP_ID', '814644968693-logir5cvdukt746nfkt2teusdetmup0r.apps.googleusercontent.com'),
                  'applicationSecret' => env('GOOGLE_APP_SECRET', 'kgeur6OuOqFKuhRJr9QqVBn6'),
                  'scope' => [
                    'https://www.googleapis.com/auth/userinfo.email',
                    'https://www.googleapis.com/auth/userinfo.profile',
                  ],
                ],
              ],
            ],
            'logErrors' => true,
          ]));

        return $middlewareQueue;
    }

    /**
     * @return void
     */
    protected function bootstrapCli()
    {
        try {
            $this->addPlugin('Bake');
        } catch (MissingPluginException $e) {
            // Do not halt if the plugin is missing
        }

        $this->addPlugin('Migrations');

        // Load more plugins here
    }
}
