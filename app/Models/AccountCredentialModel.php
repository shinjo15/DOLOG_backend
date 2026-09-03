<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class AccountCredentialModel extends Model
{
    protected $table = 'account_credentials';

    protected $primaryKey = 'account_identifier';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['account_identifier', 'passcode_hash'];
}
