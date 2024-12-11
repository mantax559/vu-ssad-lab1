<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Other
        // ...

        // Default
        if ($this->app->isLocal()) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    public function boot(): void
    {
        // Other
        // ...

        // Default
        Schema::defaultStringLength(255);
        Paginator::useBootstrapFive();
        JsonResource::withoutWrapping();
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        Model::preventLazyLoading($this->app->isLocal());
        Model::preventSilentlyDiscardingAttributes($this->app->isLocal());
        Model::preventAccessingMissingAttributes($this->app->isLocal());

        $this->loadJsonTranslationsFrom(base_path('lang/custom'));
    }
}
