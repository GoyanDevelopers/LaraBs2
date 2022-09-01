<?php

namespace Goyan\Bs2;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class Bs2ServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->registerConfig();

        if ($this->app->runningInConsole()) {
            $this->registerCommands();
            $this->registerPublishing();
        }

        $this->registerMixin();
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/bs2.php', 'bs2');
    }

    protected function registerCommands(): void
    {
        $this->commands([
            Console\WebhookCommand::class,
            Console\WebhookCreateCommand::class,
            Console\WebhookDeleteCommand::class,
        ]);
    }

    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../config/bs2.php' => config_path('bs2.php'),
        ], 'bs2-config');

        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'bs2-migrations');
    }

    protected function registerMixin(): void
    {
        Http::mixin(
            new Mixins\HttpMixin
        );
    }
}
