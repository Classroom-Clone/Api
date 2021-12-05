<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Commentable
{
    public function comments(): MorphMany;
}
