<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class TagModel extends Model
{
    protected $table = 'tags';

    protected $primaryKey = 'tag_identifier';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'tag_identifier',
        'tag_name',
        'available',
    ];

    protected function casts(): array
    {
        return [
            'available' => 'boolean',
        ];
    }
}
