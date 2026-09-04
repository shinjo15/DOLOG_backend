<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class FollowModel extends Model
{
    protected $table = 'follows';

    protected $fillable = [
        'following_account_identifier',
        'followed_account_identifier',
    ];
}
