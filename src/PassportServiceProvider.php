<?php

/**
 * @author simon <simon@crcms.cn>
 * @datetime 2018-08-15 07:33
 * @link http://crcms.cn/
 * @copyright Copyright &copy; 2018 Rights Reserved CRCMS
 */

namespace CrCms\Foundation\Passport\Client;

use CrCms\Foundation\MicroService\Client\Service;
use CrCms\Foundation\Passport\Client\Contracts\InteractionContract;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

/**
 * Class PassportServiceProvider
 * @package CrCms\Foundation\Passport\Client
 */
class PassportServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    public $defer = false;
    /**
     * @var string
     */
    protected $namespaceName = 'passport-client';

    /**
     * @var string
     */
    protected $packagePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

    /**
     * @return void
     */
    public function boot()
    {
        //move config path
        if ($this->isLumen()) {

        } else {
            $this->publishes([
                $this->packagePath . 'config/config.php' => config_path($this->namespaceName . ".php"),
            ]);
        }

        //load middleware alias
        $this->aliasMiddleware();
    }

    /**
     *
     */
    public function register()
    {
        if ($this->isLumen()) {
            $this->app->configure($this->namespaceName);
        }

        //merge config
        $configFile = $this->packagePath . "config/config.php";
        if (file_exists($configFile)) $this->mergeConfigFrom($configFile, $this->namespaceName);

        $this->app->bind(InteractionContract::class, function ($app) {
            return new DefaultInteractor($app->make(Service::class));
        });
    }

    /**
     * Alias the middleware.
     *
     * @return void
     */
    protected function aliasMiddleware()
    {
        $router = $this->app['router'];

        $routerMiddleware = [
            'passport.user' => \CrCms\Foundation\Passport\Client\Middleware\UserMiddleware::class,
            'passport.auth' => \CrCms\Foundation\Passport\Client\Middleware\AuthMiddleware::class,
        ];

        foreach ($routerMiddleware as $alias => $middleware) {
            $router->aliasMiddleware($alias, $middleware);
        }
    }

    /**
     * @return bool
     */
    protected function isLumen(): bool
    {
        return class_exists(Application::class) && $this->app instanceof Application;
    }

    /**
     * @return array
     */
    public function provides(): array
    {
        return [InteractionContract::class];
    }
}