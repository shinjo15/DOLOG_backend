<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class FavoriteTagModel extends Model
{
    protected $table = 'favorite_tags';

    protected $primaryKey = null;

    public $incrementing = false;

    protected $fillable = ['account_identifier', 'tag_identifier'];
}
