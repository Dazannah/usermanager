<?php

namespace App\Models;

use App\Casts\SanitizedString;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkerRequestStatus
 * 
 * @property int $id
 * @property string $name
 * @property string $displayName
 * 
 * @property Collection|WorkerRequest[] $worker_request
 *
 * @package App\Models
 */
class WorkerRequestStatus extends Model {
    protected $table = 'worker_request_statuses';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $casts = [
        'name' => SanitizedString::class,
        'displayName' => SanitizedString::class
    ];
    protected $fillable = [
        'name',
        'displayName'
    ];

    public function worker_request() {
        return $this->hasMany(WorkerRequest::class, 'worker_request_status_id');
    }
}
