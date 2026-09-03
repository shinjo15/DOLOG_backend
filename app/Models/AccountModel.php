<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class AccountModel extends Model
{
    protected $table = 'accounts';

    protected $primaryKey = 'account_identifier';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['account_identifier', 'account_name', 'account_bio', 'email_address', 'social_links', 'favorite_tag_identifiers', 'available'];

    protected function casts(): array
    {
        return ['social_links' => 'array', 'favorite_tag_identifiers' => 'array', 'available' => 'boolean'];
    }
}
