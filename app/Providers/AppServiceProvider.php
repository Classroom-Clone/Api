<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\Post;
use App\Observers\ClassroomObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider as BaseTelescopeServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->environment("local")) {
            $this->app->register(BaseTelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    public function boot(): void
    {
        Classroom::observe(ClassroomObserver::class);

        Relation::morphMap([
            "post" => Post::class,
            "assignment" => Assignment::class,
        ]);
    }
}
