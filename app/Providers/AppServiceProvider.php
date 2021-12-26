<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Assignment;
use App\Models\Attachment;
use App\Models\Classroom;
use App\Models\Post;
use App\Models\Submission;
use App\Observers\AssignmentObserver;
use App\Observers\AttachmentObserver;
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
        Assignment::observe(AssignmentObserver::class);
        Attachment::observe(AttachmentObserver::class);

        Relation::morphMap([
            "post" => Post::class,
            "assignment" => Assignment::class,
            "submission" => Submission::class,
        ]);
    }
}
