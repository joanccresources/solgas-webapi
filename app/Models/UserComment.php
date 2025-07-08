<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use BeyondCode\Comments\Contracts\Commentator;

class UserComment extends Model implements Commentator
{
    /**
     * Check if a comment for a specific model needs to be approved.
     * @param mixed $model
     * @return bool
     */
    public function needsCommentApproval($model): bool
    {
        return false;
    }
}
