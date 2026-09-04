<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class BlockModel extends Model
{
    protected $table = 'blocks';

    protected $fillable = [
        'blocking_account_identifier',
        'blocked_account_identifier',
    ];
}
