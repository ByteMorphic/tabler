<?php

namespace bytemorphic\Tabler;

use bytemorphic\Tabler\Commands\MakeTablerCommand;
use Illuminate\Support\ServiceProvider;

class TablerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeTablerCommand::class,
            ]);

            $this->publishes([
                __DIR__.'/../config/tabler.php' => config_path('tabler.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/tabler.php', 'tabler'
        );
    }
}
