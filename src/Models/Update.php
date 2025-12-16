<?php

namespace Maxkhim\MaxMessengerApiClient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Update extends Model
{
    protected $table = 'maxbot_updates';

    public const PROCESS_STATUS_PENDING = 'pending';
    public const PROCESS_STATUS_DUPLICATED = 'duplicated';
    public const PROCESS_STATUS_PROCESSING = 'processing';
    public const PROCESS_STATUS_FAILED = 'failed';
    public const PROCESS_STATUS_SUCCESS = 'success';
    public const PROCESS_STATUS_SKIPPED = 'skipped';

    protected $fillable = [
        'update_id',
        'update_hash',
        'update_type',
        'timestamp',
        'event_at',
        'chat_id',
        'user_id',
        'raw_data',
        'processed',
        'processing_error',
        'process_status',
    ];

    protected $casts = [
        'raw_data' => 'array',
        'event_at' => 'datetime',
    ];
}
