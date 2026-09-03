<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class ReportModel extends Model
{
    protected $table = 'reports';

    protected $primaryKey = 'report_identifier';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'report_identifier',
        'reporter_account_identifier',
        'target_account_identifier',
        'target_post_identifier',
        'category',
        'text',
    ];
}
