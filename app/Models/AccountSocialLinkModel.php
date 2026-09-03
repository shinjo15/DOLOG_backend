<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class AccountSocialLinkModel extends Model
{
    protected $table = 'account_social_links';

    protected $primaryKey = null;

    public $incrementing = false;

    protected $fillable = ['account_identifier', 'type', 'url', 'position'];
}
