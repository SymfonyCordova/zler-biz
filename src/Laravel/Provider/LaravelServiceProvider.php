<?php


namespace Zler\Biz\Laravel\Provider;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Zler\Biz\Context\Biz;
use Zler\Biz\Provider\AlibabaCloudClientProvider;
use Zler\Biz\Provider\AlipayEasySdkServiceProvider;
use Zler\Biz\Provider\DoctrineServiceProvider;
use Zler\Biz\Provider\WeChatPayGuzzleMiddlewareServiceProvider;

class LaravelServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Biz::class , function ($app) {
            $biz = new Biz(config('zler-biz.options'));
            $biz->register(new DoctrineServiceProvider());
            $biz->register(new WeChatPayGuzzleMiddlewareServiceProvider());
            $biz->register(new AlipayEasySdkServiceProvider());
            $biz->register(new AlibabaCloudClientProvider());
            return $biz;
        });
    }

    /**
     * 启动应用服务
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->app->tagged('zler.event.subscriber') as $tag){
            $biz = $this->app->make(Biz::class);
            $dispatcher = $biz['dispatcher'];
            $dispatcher->addSubscriber($tag);
        }

        $this->publishes([
            __DIR__ . '/../config/zler-biz.php' => config_path('zler-biz.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Zler\Biz\Laravel\Command\ScaffoldCommand::class,
            ]);
        }

        //$this->loadRoutesFrom(__DIR__ . '/../../routes/routes.php');

        //$this->loadMigrationsFrom(__DIR__.'/path/to/migrations');
    }

    /**
     * 获取由提供者提供的服务。
     *
     * @return array
     */
    public function provides()
    {
        return array(Biz::class);
    }
}