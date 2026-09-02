<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class SupportModel extends Model
{
    protected $table = 'supports';

    protected $fillable = ['account_identifier', 'post_identifier'];
}
