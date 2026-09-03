<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class AccountModel extends Model
{
    protected $table = 'accounts';

    protected $primaryKey = 'account_identifier';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['account_identifier', 'account_name', 'account_bio', 'email_address', 'favorite_tag_identifiers', 'available'];

    protected function casts(): array
    {
        return ['favorite_tag_identifiers' => 'array', 'available' => 'boolean'];
    }

    public function socialLinks(): HasMany
    {
        return $this->hasMany(AccountSocialLinkModel::class, 'account_identifier', 'account_identifier')->orderBy('position');
    }
}
