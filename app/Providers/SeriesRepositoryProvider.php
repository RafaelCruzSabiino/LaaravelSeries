<?php

namespace App\Providers;

use App\Repositories\EloquentSeriesRepository;
use App\Repositories\ISeriesRepository;
use Illuminate\Support\ServiceProvider;

class SeriesRepositoryProvider extends ServiceProvider
{
    public array $bindings = [
        ISeriesRepository::class => EloquentSeriesRepository::class
    ];

    /**
     * Register services.
     */
    // public function register(): void
    // {
    //     $this->app->bind(ISeriesRepository::class, EloquentSeriesRepository::class);
    // }
}
