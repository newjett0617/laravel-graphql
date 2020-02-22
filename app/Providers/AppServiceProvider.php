<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Database\Query\Builder::macro('sql', function () {
            $bindings = $this->getBindings();
            $sql = str_replace('?', '%s', $this->toSql());
            return sprintf($sql, ...$bindings);
        });
        \Illuminate\Database\Eloquent\Builder::macro('sql', function () {
            $bindings = $this->getBindings();
            $sql = str_replace('?', '%s', $this->toSql());
            return sprintf($sql, ...$bindings);
        });

        \Illuminate\Support\Facades\DB::listen(function (\Illuminate\Database\Events\QueryExecuted $query) {
            $bindings = $query->bindings;
            $sql = str_replace('?', '%s', $query->sql);
            \Illuminate\Support\Facades\Log::info('query event', [
                'sql' => sprintf($sql, ...$bindings),
                'time' => $query->time,
            ]);
        });
    }
}
