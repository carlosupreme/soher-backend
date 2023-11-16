<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Builder::macro('matching', function ($value, ...$fields) {
            if (!$value || !count($fields)) {
                return $this;
            }

            foreach ($fields as $field) {
                $this->orWhere($field, 'like', '%' . $value . '%');
            }

            return $this;
        });
    }
}
